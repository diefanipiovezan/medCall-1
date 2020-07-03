<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\AgendaRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacaoProfissionalAgendamento;
use App\Mail\NotificacaoProfissionalCancelamento;
use App\Mail\NotificacaoProfissionalAprovacao;
use App\Mail\NotificacaoPacienteCancelamento;

class AgendaController extends Controller
{
    protected $request;
    protected $agendaRepository;

    public function __construct(Request $request, AgendaRepository $agendaRepository)
    {
        $this->request = $request;
        $this->agendaRepository = $agendaRepository;
    }

    public function getProfissionaisDisponiveis()
    {

        $filters = [
            'cidade' => $this->request->input('cidade')
        ];

        if ($this->request->has('especialidade')) {
            $filters['especialidade'] = $this->request->input('especialidade');
        }

        if ($this->request->has('procedimento')) {
            $filters['procedimento'] = $this->request->input('procedimento');
        }

        if ($this->request->has('convenio')) {
            $filters['convenio'] = $this->request->input('convenio');
        }

        $result = $this->agendaRepository->getProfissionaisDisponiveis($filters);

        return json_encode($result);
    }

    public function getHorariosDisponiveisByProfissional()
    {
        $filters = [
            'profissional' => $this->request->input('idProfissional')
        ];

        $result = $this->agendaRepository->getHorariosDisponiveisByProfissional($filters);

        return json_encode($result);
    }

    public function getDetalhesProfissional()
    {
        $userIsLogged = Auth::check();
        $idPessoa = $this->request->input('idProfissional');
        $result = $this->agendaRepository->getDetalhesProfissional($idPessoa, $userIsLogged);

        return $result;
    }

    public function getEspecialidadesByCidade()
    {
        $idCidade = $this->request->input('idCidade');
        $result = $this->agendaRepository->getEspecialidadesByCidade($idCidade);

        return $result;
    }

    public function getProcedimentosByCidade()
    {
        $idCidade = $this->request->input('idCidade');
        $result = $this->agendaRepository->getProcedimentosByCidade($idCidade);

        return $result;
    }

    public function getConveniosByCidade()
    {
        $idCidade = $this->request->input('idCidade');
        $result = $this->agendaRepository->getConveniosByCidade($idCidade);

        return $result;
    }

    public function getAgendamentoProfissional()
    {
        if (Auth::check()) {
            $dia = $this->request->input('dia');
            $horario = $this->request->input('horario');
            $id_profissional = $this->request->input('id_profissional');

            $view = view('partials.agendamento-modal-form', [
                'dia' => $dia,
                'horario' => $horario,
                'id_profissional' => $id_profissional,
                'procedimentos' => $this->agendaRepository->getProcedimentosProfissional($id_profissional),
                'convenios' => $this->agendaRepository->getConveniosProfissional($id_profissional)
            ]);
        } else {
            $view = view('partials.agendamento-modal-alerta');
        }

        return $view;
    }

    public function getAgendaProfissional()
    {
        $user = $this->request->user();
        $tipoPessoa = $this->agendaRepository->getTipoPessoa($user->id);

        if ($tipoPessoa === 'PP') {
            return redirect()->route('home')->with('error-msg', 'Você não possui acesso a esta página!');
        } else {
            return view('agenda.profissional');
        }
    }

    public function getAgendaPaciente()
    {
        $user = $this->request->user();
        $tipoPessoa = $this->agendaRepository->getTipoPessoa($user->id);

        if ($tipoPessoa !== 'PP') {
            return redirect('/')->with('error-msg', 'Você não possui acesso a esta página!');
        } else {
            return view('agenda.paciente');
        }
    }

    public function getDadosAgendaProfissional()
    {
        $user = $this->request->user();

        $result = $this->agendaRepository->getDadosAgendaProfissional($user->id);

        return $result;
    }

    public function getDadosAgendaPaciente()
    {
        $user = $this->request->user();

        $result = $this->agendaRepository->getDadosAgendaPaciente($user->id);

        return $result;
    }

    public function getDetalhesAgendamentoProfissional()
    {
        $user = $this->request->user();
        $idAgendamento = $this->request->input('idAgendamento');

        $result = $this->agendaRepository->getDetalhesAgendamentoProfissional($user->id, $idAgendamento);

        return $result;
    }

    public function getDetalhesAgendamentoPaciente()
    {
        $user = $this->request->user();
        $idAgendamento = $this->request->input('idAgendamento');

        $result = $this->agendaRepository->getDetalhesAgendamentoPaciente($user->id, $idAgendamento);

        return $result;
    }

    public function addAgendamentoProfissional()
    {
        // Mensagem de erro
        $result = [
            'status' => 'NOK',
            'message' => 'É necessário estar logado para realizar um agendamento!'
        ];

        if (Auth::check()) {
            $user = $this->request->user();

            $dadosAgendamento = [
                'user' => $user,
                'dia' => $this->request->input('txtDia'),
                'horario' => $this->request->input('txtHorario'),
                'id_profissional' => $this->request->input('txtIdProfissional'),
                'id_procedimento' => $this->request->input('cboProcedimentoAgendar')
            ];

            if ($this->request->has('cboConvenioAgendar')) {
                $dadosAgendamento['id_convenio'] = $this->request->input('cboConvenioAgendar');
            } else {
                $dadosAgendamento['valor'] = $this->request->input('txtValor');
                $dadosAgendamento['pagamento'] = $this->request->input('cboFormaPagamentoAgendar');
            }

            $result = $this->agendaRepository->addAgendamentoProfissional($dadosAgendamento);

            // Notificacao email
            if ($result['status'] === 'OK') {
                $dadosEmail = $this->agendaRepository->getDadosEnvioEmail($result['idAgendamento']);

                // Enfileirar email
                Mail::to($dadosEmail->email_profissional)->queue(new NotificacaoProfissionalAgendamento($dadosEmail));
            }
        }

        return $result;
    }

    public function alterAgendamentoProfissionalStatus()
    {
        $user = $this->request->user();
        $path = $this->request->path();
        $idAgendamento = $this->request->input('idAgendamento');

        //$path === 'agenda/profissional/cancel'
        $status = 3; // Cancelado pelo Profissional

        if ($path === 'agenda/profissional/approve') {
            $status = 1; // Aprovado
        }

        $result = $this->agendaRepository->alterAgendamentoProfissionalStatus($user->id, $idAgendamento, $status);

        // Notificação de email
        if ($result['status'] === 'OK') {
            $dadosEmail = $this->agendaRepository->getDadosEnvioEmail($idAgendamento);

            if ($status == 1) {
                Mail::to($dadosEmail->email_paciente)->queue(new NotificacaoProfissionalAprovacao($dadosEmail));
            } else {
                Mail::to($dadosEmail->email_paciente)->queue(new NotificacaoProfissionalCancelamento($dadosEmail));
            }
        }

        return $result;
    }

    public function alterAgendamentoPacienteStatus()
    {
        $user = $this->request->user();
        $idAgendamento = $this->request->input('idAgendamento');

        $result = $this->agendaRepository->alterAgendamentoPacienteStatus($user->id, $idAgendamento);

        // Notificacao de email
        if ($result['status'] === 'OK') {
            $dadosEmail = $this->agendaRepository->getDadosEnvioEmail($idAgendamento);

            Mail::to($dadosEmail->email_profissional)->queue(new NotificacaoPacienteCancelamento($dadosEmail));
        }

        return $result;
    }
}
