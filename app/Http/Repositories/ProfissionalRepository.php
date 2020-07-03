<?php

namespace App\Http\Repositories;

use App\Models\Pessoa;
use App\Models\Convenio;
use App\Models\ConvenioPessoa;
use App\Models\Especialidade;
use App\Models\EspecialidadePessoa;
use App\Models\Procedimento;
use App\Models\ProcedimentoPessoa;
use App\Models\Assistente;
use App\Models\TipoPessoa;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfissionalRepository
{
    public function getConvenios()
    {
        $convenios = Convenio::select('id', 'convenio')->orderBy('convenio')->get();

        return $convenios;
    }

    public function getEspecialidades()
    {
        $especialidades = Especialidade::select('id', 'especialidade')->orderBy('especialidade')->get();

        return $especialidades;
    }


    public function getProcedimentos()
    {
        $procedimentos = Procedimento::select('id', 'procedimento')->orderBy('procedimento')->get();

        return $procedimentos;
    }

    public function getTipoPessoa($idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        return $pessoa->TipoPessoa->sigla;
    }

    public function getConveniosByUsuario($idUsuario)
    {
        $convenios = DB::table('tbl_pessoa AS pe')
                        ->join('tbl_convenio_pessoa AS cp', 'pe.id', '=', 'cp.id_pessoa')
                        ->join('tbl_convenio AS co', 'cp.id_convenio', '=', 'co.id')
                        ->where('pe.id_usuario', '=', $idUsuario)
                        ->select('cp.id', 'co.convenio')
                        ->orderBy('co.convenio', 'asc')
                        ->get();

        return $convenios;
    }

    public function getEspecialidadesByUsuario($idUsuario)
    {
        $convenios = DB::table('tbl_pessoa AS pe')
                        ->join('tbl_especialidade_pessoa AS ep', 'pe.id', '=', 'ep.id_pessoa')
                        ->join('tbl_especialidade AS es', 'ep.id_especialidade', '=', 'es.id')
                        ->where('pe.id_usuario', '=', $idUsuario)
                        ->select('ep.id', 'es.especialidade')
                        ->orderBy('es.especialidade', 'asc')
                        ->get();

        return $convenios;
    }

    public function getProcedimentosByUsuario($idUsuario)
    {
        $procedimentos = DB::table('tbl_pessoa AS pe')
                        ->join('tbl_procedimento_pessoa AS pp', 'pe.id', '=', 'pp.id_pessoa')
                        ->join('tbl_procedimento AS pr', 'pp.id_procedimento', '=', 'pr.id')
                        ->where('pe.id_usuario', '=', $idUsuario)
                        ->select('pp.id', 'pr.procedimento', 'pp.valor')
                        ->orderBy('pr.procedimento', 'asc')
                        ->get();

        return $procedimentos;
    }

    public function getAssistentes($idUsuario)
    {
        $assistentes = DB::table('tbl_assistente AS ae')
                        ->join('tbl_pessoa AS pp', 'pp.id', '=', 'ae.id_profissional')
                        ->join('tbl_usuario AS up', 'up.id', '=', 'pp.id_usuario')
                        ->join('tbl_pessoa AS pa', 'pa.id', '=', 'ae.id_pessoa')
                        ->join('tbl_usuario AS ua', 'ua.id', '=', 'pa.id_usuario')
                        ->where('up.id', '=', $idUsuario)
                        ->select(
                            'ae.id',
                            'pa.nome',
                            'ae.cpf',
                            'ae.rg',
                            'ua.email',
                            'ua.username',
                            DB::raw('CASE ua.status WHEN \'A\' THEN \'Ativo\' ELSE \'Inativo\' END AS status')
                        )
                        ->orderBy('pa.nome', 'asc')
                        ->get();

        return $assistentes;
    }

    public function addNewConvenioProfissional($nome, $idUsuario)
    {
        $convenio = new Convenio;
        $convenio->convenio = $nome;
        $convenio->save();

        $convenioPessoa = $this->addConvenioProfissional($convenio->id, $idUsuario);

        return $convenioPessoa;
    }

    public function addNewEspecialidadeProfissional($nome, $idUsuario)
    {
        $especialidade = new Especialidade;
        $especialidade->especialidade = $nome;
        $especialidade->save();

        $especialidadePessoa = $this->addEspecialidadeProfissional($especialidade->id, $idUsuario);

        return $especialidadePessoa;
    }

    public function addNewProcedimentoProfissional($nome, $valor, $idUsuario)
    {
        $procedimento = new Procedimento;
        $procedimento->procedimento = $nome;
        $procedimento->save();

        $procedimentoPessoa = $this->addProcedimentoProfissional($procedimento->id, $valor, $idUsuario);

        return $procedimentoPessoa;
    }

    public function addConvenioProfissional($idConvenio, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        $convenioPessoa = new ConvenioPessoa;
        $convenioPessoa->id_convenio = $idConvenio;
        $convenioPessoa->id_pessoa = $pessoa->id;
        $convenioPessoa->save();

        return $convenioPessoa;
    }

    public function addEspecialidadeProfissional($idEspecialidade, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        $especialidadePessoa = new EspecialidadePessoa;
        $especialidadePessoa->id_especialidade = $idEspecialidade;
        $especialidadePessoa->id_pessoa = $pessoa->id;
        $especialidadePessoa->save();

        return $especialidadePessoa;
    }

    public function addProcedimentoProfissional($idProcedimento, $valor, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        $procedimentoPessoa = new ProcedimentoPessoa;
        $procedimentoPessoa->valor = $valor;
        $procedimentoPessoa->id_procedimento = $idProcedimento;
        $procedimentoPessoa->id_pessoa = $pessoa->id;
        $procedimentoPessoa->save();

        return $procedimentoPessoa;
    }

    public function alterProcedimentoProfissional($idProcedimento, $valor, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();
        $procedimentoPessoa = ProcedimentoPessoa::find($idProcedimento);

        if ((int)$procedimentoPessoa->id_pessoa === $pessoa->id) {
            $procedimentoPessoa->valor = $valor;
            $procedimentoPessoa->save();

            $result =  [
                'status'  => 'OK',
                'message' => 'Registro excluído.'
            ];
        } else {
            $result =  [
                'status'  => 'NOK',
                'message' => 'Não é possível alterar o registro! Está associado a outro usuário.'
            ];
        }

        return $result;
    }

    public function dropConvenioProfissional($idConvenio, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();
        $convenioPessoa = ConvenioPessoa::find($idConvenio);

        // Apaga somente se o registro for do usuário.
        if ((int)$convenioPessoa->id_pessoa === $pessoa->id ) {
            $convenioPessoa->delete();

            $result =  [
                'status'  => 'OK',
                'message' => 'Registro excluído.'
            ];
        } else {
            $result =  [
                'status'  => 'NOK',
                'message' => 'Não é possível excluir o registro! Está associado a outro usuário.'
            ];
        }

        return $result;
    }

    public function dropEspecialidadeProfissional($idEspecialidade, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();
        $especialidadePessoa = EspecialidadePessoa::find($idEspecialidade);

        // Apaga somente se o registro for do usuário.
        if ((int)$especialidadePessoa->id_pessoa === $pessoa->id ) {
            $especialidadePessoa->delete();

            $result =  [
                'status'  => 'OK',
                'message' => 'Registro excluído.'
            ];
        } else {
            $result =  [
                'status'  => 'NOK',
                'message' => 'Não é possível excluir o registro! Está associado a outro usuário.'
            ];
        }

        return $result;
    }

    public function dropProcedimentoProfissional($idProcedimento, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();
        $procedimentoPessoa = procedimentoPessoa::find($idProcedimento);

        // Apaga somente se o registro for do usuário.
        if ((int)$procedimentoPessoa->id_pessoa === $pessoa->id ) {
            $procedimentoPessoa->delete();

            $result =  [
                'status'  => 'OK',
                'message' => 'Registro excluído.'
            ];
        } else {
            $result =  [
                'status'  => 'NOK',
                'message' => 'Não é possível excluir o registro! Está associado a outro usuário.'
            ];
        }

        return $result;
    }

    public function addAssistente($inputs, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();
        $assistente = new Assistente;
        $assistente->id_profissional = $pessoa->id;

        DB::transaction(function() use ($inputs, $assistente) {
            // Tipo de Pessoa - PA = Assistente
            $tipoPessoa = TipoPessoa::where('sigla', 'PA')->first();

            // Usuario
            $user = new User;
            $user->username = $inputs['txtUsuario'];
            $user->password = bcrypt($inputs['txtSenha']);
            $user->email = $inputs['txtEmail'];
            $user->save();

            // Pessoa
            $pessoa = new Pessoa;
            $pessoa->nome = $inputs['txtNome'];
            $pessoa->id_tipo_pessoa = $tipoPessoa->id;
            $pessoa->id_usuario = $user->id;
            $pessoa->save();

            // Assistente
            $assistente->cpf = str_replace(['.', '-'], '', $inputs['txtCpf']);
            $assistente->rg = $inputs['txtRg'];
            $assistente->id_pessoa = $pessoa->id;
            $assistente->save();
        });

        return $assistente;
    }

    public function updateAssistenteStatus($idAssistente, $idUsuario)
    {
        $result = [
            'status' => 'NOK',
            'message' => 'Não foi possível alterar o Status!'
        ];

        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        $assistente = Assistente::with('Pessoa')->where('id', $idAssistente)
                        ->where('id_profissional', $pessoa->id)
                        ->first();

        if ($assistente !== null) {
            $usuarioAssistente = User::find($assistente->Pessoa->id_usuario);

            $status = 'I';
            if ($usuarioAssistente->status === 'I') {
                $status = 'A';
            }
            $usuarioAssistente->status = $status;
            $usuarioAssistente->save();

            $result = [
                'status' => 'OK',
                'message' => 'Status alterado com sucesso!'
            ];
        }

        return $result;
    }
}
