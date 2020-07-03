<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Telefone;
use App\Models\Agenda;
use App\Models\Pessoa;
use App\Models\Assistente;

class AgendaRepository
{
    private $filterColumns = [
        'estado'        => 'uf.id',
        'cidade'        => 'ci.id',
        'especialidade' => 'ep.id_especialidade',
        'procedimento'  => 'pp.id_procedimento',
        'convenio'      => 'cp.id_convenio',
        'profissional'  => 'pe.id'
    ];

    private function getIdProfissional($idUsuario)
    {
        $pessoa = Pessoa::with('TipoPessoa')->where('id_usuario', $idUsuario)->first();
        $idProfissional = $pessoa->id;

        // Se for Assistente busca Profissional associado
        if ($pessoa->tipoPessoa->sigla === 'PA') {
            $assistente = Assistente::where('id_pessoa', $pessoa->id)->first();
            $idProfissional = $assistente->id_profissional;
        }

        return $idProfissional;
    }

    private function queryBaseDisponibilidade()
    {
        // Busca disponibilidade de profissionais um mês adiante
        $query = DB::table('vw_dias_futuro AS dt')
                    ->join('tbl_disponibilidade AS di', 'di.dia_semana', '=', DB::raw('DAYOFWEEK(dt.dia)'))
                    ->join('tbl_pessoa AS pe', 'pe.id', '=', 'di.id_pessoa')
                    ->leftJoin('tbl_pessoa_fisica AS pf', 'pf.id_pessoa', '=', 'pe.id')
                    ->leftJoin('tbl_pessoa_juridica AS pj', 'pj.id_pessoa', '=', 'pe.id')
                    ->join('tbl_logradouro AS lo', 'lo.id', '=', DB::raw('COALESCE(pf.id_logradouro, pj.id_logradouro)'))
                    ->join('tbl_bairro AS ba', 'ba.id', '=', 'lo.id_bairro')
                    ->join('tbl_cidade AS ci', 'ci.id', '=', 'ba.id_cidade')
                    ->join('tbl_estado AS uf', 'uf.id', '=', 'ci.id_estado')
                    ->join('tbl_especialidade_pessoa AS ep', 'ep.id_pessoa', '=', 'pe.id')
                    ->join('tbl_procedimento_pessoa AS pp', 'pp.id_pessoa', '=', 'pe.id')
                    ->join('tbl_convenio_pessoa AS cp', 'cp.id_pessoa', '=', 'pe.id')
                    ->whereRaw('dt.dia BETWEEN DATE(NOW()) AND DATE_ADD(DATE(NOW()), INTERVAL 1 MONTH)')
                    ->whereRaw('CONCAT(dt.dia, \' \', di.horario) > DATE_ADD(NOW(), INTERVAL 1 HOUR)')
                    ->whereNotExists(function($q) {
                        $q->select(DB::raw(1))
                            ->from('tbl_agenda AS ag')
                            ->whereRaw('ag.id_profissional = pe.id')
                            ->whereRaw('DATE(ag.data) = dt.dia')
                            ->whereRaw('TIME(ag.data) = di.horario')
                            ->whereRaw('ag.status IN (0, 1)');
                    });

        return $query;
    }

    public function getProfissionaisDisponiveis($filters)
    {
        $query = $this->queryBaseDisponibilidade();
        $query->select(
            'pe.id AS id_profissional',
            DB::raw('COALESCE(pj.nome_fantasia, pe.nome) AS profissional')
        )
        ->groupBy([
            'pe.id',
            DB::raw('COALESCE(pj.nome_fantasia, pe.nome)')
        ])
        ->orderBy(DB::raw('COALESCE(pj.nome_fantasia, pe.nome)'), 'asc');

        // Aplica os filtros
        foreach ($filters as $key => $value) {
            $query->where($this->filterColumns[$key], '=', $value);
        }

        // Executa a query
        $result = $query->get();

        return $result;
    }

    public function getHorariosDisponiveisByProfissional($filters)
    {
        $query = $this->queryBaseDisponibilidade();
        $query->select(
            DB::raw('DATE_FORMAT(dt.dia, \'%d/%m/%Y\') AS dia'),
            'di.dia_semana',
            'di.horario',
            'pe.id AS id_profissional'
        )
        ->groupBy([
            'dt.dia',
            'di.dia_semana',
            'di.horario',
            'pe.id',
            DB::raw('COALESCE(pj.nome_fantasia, pe.nome)')
        ])
        ->orderBy('dt.dia', 'asc')
        ->orderBy('di.horario', 'asc');

        // Aplica os filtros
        foreach ($filters as $key => $value) {
            $query->where($this->filterColumns[$key], '=', $value);
        }

        // Executa a query
        // $result = $query->toSql();
        // dd($result);
        // DB::connection()->enableQueryLog();
        $result = $query->get();
        // $queries = DB::getQueryLog();
        // dd($queries);

        return $result;
    }

    public function getDetalhesProfissional($idPessoa, $userIsLogged)
    {
        $result = [
            'dados',
            'fones',
            'especialidades',
            'procedimentos'
        ];

        $result['dados'] = DB::table('tbl_pessoa AS pe')
                            ->leftJoin('tbl_pessoa_fisica AS pf', 'pf.id_pessoa', '=', 'pe.id')
                            ->leftJoin('tbl_pessoa_juridica AS pj', 'pj.id_pessoa', '=', 'pe.id')
                            ->join('tbl_logradouro AS lo', 'lo.id', '=', DB::raw('COALESCE(pf.id_logradouro, pj.id_logradouro)'))
                            ->join('tbl_bairro AS ba', 'ba.id', '=', 'lo.id_bairro')
                            ->where('pe.id', '=', $idPessoa)
                            ->select(
                                'pe.id',
                                DB::raw('COALESCE(pj.nome_fantasia, pe.nome) AS nome'),
                                DB::raw('COALESCE(pj.registro, pf.registro) AS registro'),
                                DB::raw('lo.nome AS logradouro'),
                                'lo.numero',
                                'lo.complemento',
                                'lo.cep',
                                DB::raw('ba.nome AS bairro')
                            )
                            ->get();
        $result['fones'] = null;
        if ($userIsLogged) {
            $result['fones'] = Telefone::with('TipoTelefone')->where('id_pessoa', $idPessoa)->get();
        }
        $result['especialidades'] = DB::table('tbl_especialidade_pessoa AS ep')
                                    ->join('tbl_especialidade AS es', 'es.id', '=', 'ep.id_especialidade')
                                    ->where('ep.id_pessoa', '=', $idPessoa)
                                    ->select('es.id', 'es.especialidade')
                                    ->orderBy('es.especialidade', 'asc')
                                    ->get();
        $result['procedimentos'] = DB::table('tbl_procedimento_pessoa AS pp')
                                    ->join('tbl_procedimento AS pr', 'pr.id', '=', 'pp.id_procedimento')
                                    ->where('pp.id_pessoa', '=', $idPessoa)
                                    ->select('pr.id', 'pr.procedimento')
                                    ->orderBy('pr.procedimento', 'asc')
                                    ->get();

        return $result;
    }

    public function getEspecialidadesByCidade($idCidade)
    {
        $result = DB::table('tbl_especialidade AS es')
                    ->join('tbl_especialidade_pessoa AS ep', 'ep.id_especialidade', '=', 'es.id')
                    ->leftJoin('tbl_pessoa_fisica AS pf', 'pf.id_pessoa', '=', 'ep.id_pessoa')
                    ->leftJoin('tbl_pessoa_juridica AS pj', 'pj.id_pessoa', '=', 'ep.id_pessoa')
                    ->join('tbl_logradouro AS lo', 'lo.id', '=', DB::raw('COALESCE(pf.id_logradouro, pj.id_logradouro)'))
                    ->join('tbl_bairro AS ba', 'ba.id', '=', 'lo.id_bairro')
                    ->where('ba.id_cidade', '=', $idCidade)
                    ->orderBy('es.especialidade', 'asc')
                    ->select('es.id', 'es.especialidade')
                    ->distinct()
                    ->get();

        return $result;
    }

    public function getProcedimentosByCidade($idCidade)
    {
        $result = DB::table('tbl_procedimento AS pr')
                    ->join('tbl_procedimento_pessoa AS pp', 'pp.id_procedimento', '=', 'pr.id')
                    ->leftJoin('tbl_pessoa_fisica AS pf', 'pf.id_pessoa', '=', 'pp.id_pessoa')
                    ->leftJoin('tbl_pessoa_juridica AS pj', 'pj.id_pessoa', '=', 'pp.id_pessoa')
                    ->join('tbl_logradouro AS lo', 'lo.id', '=', DB::raw('COALESCE(pf.id_logradouro, pj.id_logradouro)'))
                    ->join('tbl_bairro AS ba', 'ba.id', '=', 'lo.id_bairro')
                    ->where('ba.id_cidade', '=', $idCidade)
                    ->orderBy('pr.procedimento', 'asc')
                    ->select('pr.id', 'pr.procedimento')
                    ->distinct()
                    ->get();

        return $result;
    }

    public function getConveniosByCidade($idCidade)
    {
        $result = DB::table('tbl_convenio AS co')
                    ->join('tbl_convenio_pessoa AS cp', 'cp.id_convenio', '=', 'co.id')
                    ->leftJoin('tbl_pessoa_fisica AS pf', 'pf.id_pessoa', '=', 'cp.id_pessoa')
                    ->leftJoin('tbl_pessoa_juridica AS pj', 'pj.id_pessoa', '=', 'cp.id_pessoa')
                    ->join('tbl_logradouro AS lo', 'lo.id', '=', DB::raw('COALESCE(pf.id_logradouro, pj.id_logradouro)'))
                    ->join('tbl_bairro AS ba', 'ba.id', '=', 'lo.id_bairro')
                    ->where('ba.id_cidade', '=', $idCidade)
                    ->orderBy('co.convenio', 'asc')
                    ->select('co.id', 'co.convenio')
                    ->distinct()
                    ->get();

        return $result;
    }

    public function getProcedimentosProfissional($idProfissional)
    {
        $result = DB::table('tbl_procedimento_pessoa AS pp')
                    ->join('tbl_procedimento AS pr', 'pr.id', '=', 'pp.id_procedimento')
                    ->where('pp.id_pessoa', '=', $idProfissional)
                    ->orderBy('pr.procedimento', 'asc')
                    ->select('pr.id', 'pr.procedimento', 'pp.valor')
                    ->distinct()
                    ->get();

        return $result;
    }

    public function getConveniosProfissional($idProfissional)
    {
        $result = DB::table('tbl_convenio_pessoa AS cp')
                    ->join('tbl_convenio AS co', 'co.id', '=', 'cp.id_convenio')
                    ->where('cp.id_pessoa', '=', $idProfissional)
                    ->orderBy('co.convenio', 'asc')
                    ->select('co.id', 'co.convenio')
                    ->distinct()
                    ->get();

        return $result;
    }

    public function getTipoPessoa($idUsuario) {
        $pessoa = Pessoa::with('TipoPessoa')->where('id_usuario', $idUsuario)->first();

        return $pessoa->tipoPessoa->sigla;
    }

    public function getDadosAgendaProfissional($idUsuario)
    {
        $idProfissional = $this->getIdProfissional($idUsuario);

        $result = DB::table('tbl_agenda AS ag')
                    ->join('tbl_pessoa AS pe', 'pe.id', '=', 'ag.id_paciente')
                    ->join('tbl_paciente AS pa', 'pa.id_pessoa', '=', 'pe.id')
                    ->whereRaw('ag.data > DATE(NOW())')
                    ->where('ag.id_profissional', '=', $idProfissional)
                    ->orderBy('ag.data')
                    ->select(
                        'ag.id',
                        'ag.status',
                        DB::raw('DATE_FORMAT(ag.data, \'%d/%m/%Y\') AS dia'),
                        DB::raw('DATE_FORMAT(ag.data, \'%H:%i:%s\') AS horario'),
                        DB::raw('DAYOFWEEK(ag.data) AS dia_semana'),
                        'pe.nome AS paciente',
                        'pa.deficiencia_auditiva'
                    )
                    ->get();

        return $result;
    }

    public function getDadosAgendaPaciente($idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        $result = DB::table('tbl_agenda AS ag')
                    ->join('tbl_pessoa AS pe', 'pe.id', '=', 'ag.id_profissional')
                    ->leftJoin('tbl_pessoa_fisica AS pf', 'pf.id_pessoa', '=', 'pe.id')
                    ->leftJoin('tbl_pessoa_juridica AS pj', 'pj.id_pessoa', '=', 'pe.id')
                    ->whereRaw('ag.data > DATE(NOW())')
                    ->where('ag.id_paciente', '=', $pessoa->id)
                    ->orderBy('ag.data')
                    ->select(
                        'ag.id',
                        'ag.status',
                        DB::raw('DATE_FORMAT(ag.data, \'%d/%m/%Y\') AS dia'),
                        DB::raw('DATE_FORMAT(ag.data, \'%H:%i:%s\') AS horario'),
                        DB::raw('DAYOFWEEK(ag.data) AS dia_semana'),
                        DB::raw('COALESCE(pj.nome_fantasia, pe.nome) AS profissional')
                    )
                    ->get();

        return $result;
    }

    public function getDetalhesAgendamentoProfissional($idUsuario, $idAgendamento)
    {
        // Restringe busca pelo id do profissional para impossibilitar a visualização de dados de outro usuário
        $idProfissional = $this->getIdProfissional($idUsuario);

        $result['dados'] = DB::table('tbl_agenda AS ag')
                            ->join('tbl_procedimento AS pr', 'pr.id', '=', 'ag.id_procedimento')
                            ->join('tbl_pessoa AS pe', 'pe.id', '=', 'ag.id_paciente')
                            ->join('tbl_paciente AS pa', 'pa.id_pessoa', '=', 'pe.id')
                            ->join('tbl_usuario AS us', 'us.id', '=', 'pe.id_usuario')
                            ->join('tbl_logradouro AS lo', 'lo.id', '=', 'pa.id_logradouro')
                            ->join('tbl_bairro AS ba', 'ba.id', '=', 'lo.id_bairro')
                            ->join('tbl_cidade AS ci', 'ci.id', '=', 'ba.id_cidade')
                            ->join('tbl_estado AS es', 'es.id', '=', 'ci.id_estado')
                            ->leftJoin('tbl_convenio AS co', 'co.id', '=', 'ag.id_convenio')
                            ->where('ag.id', '=', $idAgendamento)
                            ->where('ag.id_profissional', '=', $idProfissional)
                            ->select(
                                'pe.nome',
                                DB::raw('DATE_FORMAT(pa.dt_nascimento, \'%d/%m/%Y\') AS dt_nascimento'),
                                'pa.rg',
                                DB::raw('CONCAT(SUBSTRING(pa.cpf,1,3), \'.\', SUBSTRING(pa.cpf,4,3), \'.\', SUBSTRING(pa.cpf,7,3), \'-\', SUBSTRING(pa.cpf,10,2)) AS cpf'),
                                'us.email',
                                'pa.deficiencia_auditiva',
                                'lo.nome AS logradouro',
                                'lo.numero',
                                'lo.complemento',
                                'ba.nome AS bairro',
                                'ci.nome AS cidade',
                                'es.uf',
                                'lo.cep',
                                'pr.procedimento',
                                'co.convenio',
                                'ag.pagamento',
                                'ag.valor'
                            )
                            ->get();

        $result['fones'] = DB::table('tbl_agenda AS ag')
                            ->join('tbl_pessoa AS pe', 'pe.id', '=', 'ag.id_paciente')
                            ->join('tbl_telefone AS te', 'te.id_pessoa', '=', 'pe.id')
                            ->join('tbl_tipo_telefone AS tt', 'tt.id', '=', 'te.id_tipo_telefone')
                            ->select('tt.tipo', 'te.ddd', 'te.numero')
                            ->where('ag.id', '=', $idAgendamento)
                            ->where('ag.id_profissional', '=', $idProfissional)
                            ->get();

        return $result;
    }

    public function getDetalhesAgendamentoPaciente($idUsuario, $idAgendamento)
    {
        $result['dados'] = DB::table('tbl_pessoa AS pe')
                            ->join('tbl_agenda AS ag', 'ag.id_paciente', '=', 'pe.id')
                            ->join('tbl_procedimento AS pr', 'pr.id', '=', 'ag.id_procedimento')
                            ->leftJoin('tbl_pessoa_fisica AS pf', 'pf.id_pessoa', '=', 'ag.id_profissional')
                            ->leftJoin('tbl_pessoa_juridica AS pj', 'pj.id_pessoa', '=', 'ag.id_profissional')
                            ->join('tbl_pessoa AS pp', 'pp.id', '=', DB::raw('COALESCE(pf.id_pessoa, pj.id_pessoa)'))
                            ->join('tbl_usuario AS us', 'us.id', '=', 'pp.id_usuario')
                            ->join('tbl_logradouro AS lo', 'lo.id', '=', DB::raw('COALESCE(pf.id_logradouro, pj.id_logradouro)'))
                            ->join('tbl_bairro AS ba', 'ba.id', '=', 'lo.id_bairro')
                            ->join('tbl_cidade AS ci', 'ci.id', '=', 'ba.id_cidade')
                            ->join('tbl_estado AS es', 'es.id', '=', 'ci.id_estado')
                            ->leftJoin('tbl_convenio AS co', 'co.id', '=', 'ag.id_convenio')
                            ->where('pe.id_usuario', '=', $idUsuario)
                            ->where('ag.id', '=', $idAgendamento)
                            ->select(
                                'pr.procedimento',
                                DB::raw('COALESCE(pj.nome_fantasia, pp.nome) AS profissional'),
                                DB::raw('COALESCE(pj.registro, pf.registro) AS registro'),
                                'us.email',
                                'lo.nome AS logradouro',
                                'lo.numero',
                                'lo.complemento',
                                'ba.nome AS bairro',
                                'ci.nome AS cidade',
                                'es.uf',
                                'lo.cep',
                                'co.convenio',
                                'ag.pagamento',
                                'ag.valor'
                            )
                            ->get();

        $result['fones'] = DB::table('tbl_agenda AS ag')
                            ->join('tbl_pessoa AS pe', 'pe.id', '=', 'ag.id_paciente')
                            ->join('tbl_pessoa AS pp', 'pp.id', '=', 'ag.id_profissional')
                            ->join('tbl_telefone AS te', 'te.id_pessoa', '=', 'pp.id')
                            ->join('tbl_tipo_telefone AS tt', 'tt.id', '=', 'te.id_tipo_telefone')
                            ->select('tt.tipo', 'te.ddd', 'te.numero')
                            ->where('ag.id', '=', $idAgendamento)
                            ->where('pe.id_usuario', '=', $idUsuario)
                            ->get();

        return $result;
    }

    public function getDadosEnvioEmail($idAgendamento)
    {
        $result = DB::table('tbl_agenda AS ag')
                    ->join('tbl_procedimento AS pr', 'pr.id', '=', 'ag.id_procedimento')
                    ->join('tbl_pessoa AS pa', 'pa.id', '=', 'ag.id_paciente')
                    ->join('tbl_usuario AS ua', 'ua.id', '=', 'pa.id_usuario')
                    ->join('tbl_pessoa AS pp', 'pp.id', '=', 'ag.id_profissional')
                    ->join('tbl_usuario AS up', 'up.id', '=', 'pp.id_usuario')
                    ->leftJoin('tbl_pessoa_juridica AS pj', 'pj.id_pessoa', '=', 'pp.id')
                    ->leftJoin('tbl_convenio AS co', 'co.id', '=', 'ag.id_convenio')
                    ->select(
                        'ag.id',
                        DB::raw('DATE_FORMAT(ag.`data`, \'%d/%m/%Y\') AS dia'),
                        DB::raw('DATE_FORMAT(ag.`data`, \'%H:%i:%s\') AS horario'),
                        DB::raw('CASE DAYOFWEEK(ag.`data`)
                            WHEN 1 THEN \'Domingo\'
                            WHEN 2 THEN \'Segunda\'
                            WHEN 3 THEN \'Terça\'
                            WHEN 4 THEN \'Quarta\'
                            WHEN 5 THEN \'Quinta\'
                            WHEN 6 THEN \'Sexta\'
                            WHEN 7 THEN \'Sábado\'
                            END AS dia_semana'),
                        'pr.procedimento',
                        DB::raw('COALESCE(pj.nome_fantasia, pp.nome) AS profissional'),
                        'up.email AS email_profissional',
                        'pa.nome AS paciente',
                        'ua.email AS email_paciente',
                        'ag.status',
                        DB::raw('CASE(ag.pagamento)
                            WHEN 1 THEN \'Dinheiro\'
                            WHEN 2 THEN \'Crédito\'
                            WHEN 3 THEN \'Débito\'
                            END AS pagamento'),
                        'ag.valor',
                        'co.convenio'
                    )
                    ->where('ag.id', '=', $idAgendamento)
                    ->first();

        return $result;
    }

    public function alterAgendamentoProfissionalStatus($idUsuario, $idAgendamento, $status)
    {
        // Retorno de erro
        $result = [
            'status' => 'NOK',
            'message' => 'Não foi possível executar a ação solicitada!'
        ];

        // Restringe busca pelo id do profissional para impossibilitar a alteração de dados de outro usuário
        $idProfissional = $this->getIdProfissional($idUsuario);

        $agenda = Agenda::where('id', $idAgendamento)
                    ->where('id_profissional', $idProfissional)
                    ->first();

        if ($agenda !== null) {
            $agenda->status = $status;
            $agenda->save();

            // Retorno OK
            $result = [
                'status' => 'OK',
                'message' => 'Registro atualizado com sucesso!'
            ];

        }

        return $result;
    }

    public function alterAgendamentoPacienteStatus($idUsuario, $idAgendamento)
    {
        // Retorno de erro
        $result = [
            'status' => 'NOK',
            'message' => 'Não foi possível executar a ação solicitada!'
        ];

        // Restringe busca pelo id do paciente para impossibilitar a alteração de dados de outro usuário
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        $agenda = Agenda::where('id', $idAgendamento)
                    ->where('id_paciente', $pessoa->id)
                    ->first();

        if ($agenda !== null) {
            $agenda->status = 2; // Cancelado pelo Paciente
            $agenda->save();

            // Retorno OK
            $result = [
                'status' => 'OK',
                'message' => 'Registro atualizado com sucesso!'
            ];
        }

        return $result;
    }

    public function addAgendamentoProfissional($dadosAgendamento)
    {
        // Retorno de erro
        $result = [
            'status' => 'NOK',
            'message' => 'Já existe um agendamento para o horário e profissional em questão!'
        ];

        // Converte a data
        $dataString = $dadosAgendamento['dia'].' '.$dadosAgendamento['horario'];
        $data = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $dataString)->toDateTimeString();

        // Checa se a agenda está disponível
        $agenda = Agenda::where('data', $data)
                    ->where('id_profissional', $dadosAgendamento['id_profissional'])
                    ->whereRaw('status IN (0, 1)')
                    ->first();

        if (!$agenda) {
            $pessoa = Pessoa::where('id_usuario', $dadosAgendamento['user']->id)->first();

            $agenda = new Agenda;
            $agenda->data = $data;
            $agenda->id_profissional = $dadosAgendamento['id_profissional'];
            $agenda->id_paciente = $pessoa->id;
            $agenda->id_procedimento = $dadosAgendamento['id_procedimento'];
            $agenda->status = 0;
            if (isset($dadosAgendamento['id_convenio'])) {
                $agenda->id_convenio = $dadosAgendamento['id_convenio'];
            } else {
                $agenda->valor = $dadosAgendamento['valor'];
                $agenda->pagamento = $dadosAgendamento['pagamento'];
            }
            $agenda->save();

            $result = [
                'status' => 'OK',
                'message' => 'Agendamento realizado com sucessso!',
                'idAgendamento' => $agenda->id
            ];

        }

        return $result;
    }
}
