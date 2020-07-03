<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\ProfissionalRepository;
use App\Http\Repositories\ProfissionalDisponibilidadeRepository;

class ProfissionalDisponibilidadeController extends Controller
{
    protected $request;
    protected $profissionalRepository;
    protected $profissionalDisponibilidadeRepository;

    public function __construct(
        Request $request,
        ProfissionalRepository $profissionalRepository,
        ProfissionalDisponibilidadeRepository $profissionalDisponibilidadeRepository
    ) {
        $this->request = $request;
        $this->profissionalRepository = $profissionalRepository;
        $this->profissionalDisponibilidadeRepository = $profissionalDisponibilidadeRepository;
    }

    public function getDisponibilidadeProfissional()
    {
        $tiposPessoaPermitidos = ['PJ', 'PF'];
        $usuario = $this->request->user();
        $tipoPessoa = $this->profissionalRepository->getTipoPessoa($usuario->id);

        // Checa se é um Profissional
        if (in_array($tipoPessoa, $tiposPessoaPermitidos)) {
            return view('cadastro.disponibilidade',[
                'perfil' => 'profissional'
            ]);
        } else {
            return redirect()->route('home')->with('error-msg', 'Você não possui acesso a esta página!');
        }
    }

    public function getHorariosDisponibilidadeProfissional()
    {
        $user = $this->request->user();

        $result = $this->profissionalDisponibilidadeRepository->getHorariosDisponiveis($user->id);

        return json_encode($result);
    }

    public function addDisponibilidadeProfissional()
    {
        $user = $this->request->user();
        $dia = $this->request->input('dia');
        $horario = $this->request->input('horario');

        $result = $this->profissionalDisponibilidadeRepository->addDisponibilidadeProfissional($dia, $horario, $user->id);

        return $result;
    }

    public function dropDisponibilidadeProfissional()
    {
        $user = $this->request->user();
        $idDisponibilidade = $this->request->input('idDisponibilidade');

        $result = $this->profissionalDisponibilidadeRepository->dropDisponibilidadeProfissional($idDisponibilidade, $user->id);

        return $result;
    }
}
