<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\ProfissionalRepository;

class ProfissionalController extends Controller
{
    protected $request;
    protected $profissionalRepository;

    public function __construct(Request $request, ProfissionalRepository $profissionalRepository)
    {
        $this->request = $request;
        $this->profissionalRepository = $profissionalRepository;
    }

    public function getConvenios()
    {
        $convenios = $this->profissionalRepository->getConvenios();

        return $convenios;
    }

    public function getEspecialidades()
    {
        $especialidades = $this->profissionalRepository->getEspecialidades();

        return $especialidades;
    }

    public function getProcedimentos()
    {
        $procedimentos = $this->profissionalRepository->getProcedimentos();

        return $procedimentos;
    }

    public function getProfissional()
    {
        $tiposPessoaPermitidos = ['PJ', 'PF'];
        $usuario = $this->request->user();
        $tipoPessoa = $this->profissionalRepository->getTipoPessoa($usuario->id);

        // Checa se é um Profissional
        if (in_array($tipoPessoa, $tiposPessoaPermitidos)) {
            return view('cadastro.profissional',[
                'perfil' => 'profissional'
            ]);
        } else {
            return redirect()->route('home')->with('error-msg', 'Você não possui acesso a esta página!');
        }
    }

    public function getConveniosProfissional()
    {
        $usuario = $this->request->user();
        $convenios = $this->profissionalRepository->getConveniosByUsuario($usuario->id);

        return json_encode($convenios);
    }

    public function getEspecialidadesProfissional()
    {
        $usuario = $this->request->user();
        $especialidades = $this->profissionalRepository->getEspecialidadesByUsuario($usuario->id);

        return json_encode($especialidades);
    }

    public function getProcedimentosProfissional()
    {
        $usuario = $this->request->user();
        $procedimentos = $this->profissionalRepository->getProcedimentosByUsuario($usuario->id);

        return json_encode($procedimentos);
    }

    public function getAssistentes()
    {
        return view('cadastro.assistentes');
    }

    public function getAssistentesList()
    {
        $usuario = $this->request->user();
        $assistentes = $this->profissionalRepository->getAssistentes($usuario->id);

        return $assistentes;
    }

    public function addAssistente()
    {
        return view('cadastro.assistente');
    }

    public function addNewConvenioProfissional()
    {
        $usuario = $this->request->user();
        $nome = $this->request->input('nome');

        $convenioProfissional = $this->profissionalRepository->addNewConvenioProfissional($nome, $usuario->id);

        return $convenioProfissional;
    }

    public function addNewEspecialidadeProfissional()
    {
        $usuario = $this->request->user();
        $nome = $this->request->input('nome');

        $especialidadeProfissional = $this->profissionalRepository->addNewEspecialidadeProfissional($nome, $usuario->id);

        return $especialidadeProfissional;
    }

    public function addNewProcedimentoProfissional()
    {
        $usuario = $this->request->user();
        $nome = $this->request->input('nome');
        $valor = $this->request->input('valor');

        $procedimentoProfissional = $this->profissionalRepository->addNewProcedimentoProfissional($nome, $valor, $usuario->id);

        return $procedimentoProfissional;
    }

    public function addConvenioProfissional()
    {
        $idConvenio = $this->request->input('idConvenio');
        $usuario = $this->request->user();

        $convenioProfissional = $this->profissionalRepository->addConvenioProfissional($idConvenio, $usuario->id);

        return $convenioProfissional;
    }

    public function addEspecialidadeProfissional()
    {
        $idEspecialidade = $this->request->input('idEspecialidade');
        $usuario = $this->request->user();

        $especialidadeProfissional = $this->profissionalRepository->addEspecialidadeProfissional($idEspecialidade, $usuario->id);

        return $especialidadeProfissional;
    }

    public function addProcedimentoProfissional()
    {
        $idProcedimento = $this->request->input('idProcedimento');
        $valor = $this->request->input('valor');
        $usuario = $this->request->user();

        $procedimentoProfissional = $this->profissionalRepository->addProcedimentoProfissional($idProcedimento, $valor, $usuario->id);

        return $procedimentoProfissional;
    }

    public function alterProcedimentoProfissional()
    {
        $idProcedimento = $this->request->input('idProcedimento');
        $valor = $this->request->input('valorNovo');
        $usuario = $this->request->user();

        $procedimentoProfissional = $this->profissionalRepository->alterProcedimentoProfissional($idProcedimento, $valor, $usuario->id);

        return $procedimentoProfissional;
    }

    public function dropConvenioProfissional()
    {
        $idConvenio = $this->request->input('idConvenio');
        $usuario = $this->request->user();

        $result = $this->profissionalRepository->dropConvenioProfissional($idConvenio, $usuario->id);

        return json_encode($result);
    }

    public function dropEspecialidadeProfissional()
    {
        $idEspecialidade = $this->request->input('idEspecialidade');
        $usuario = $this->request->user();

        $result = $this->profissionalRepository->dropEspecialidadeProfissional($idEspecialidade, $usuario->id);

        return json_encode($result);
    }

    public function dropProcedimentoProfissional()
    {
        $idProcedimento = $this->request->input('idProcedimento');
        $usuario = $this->request->user();

        $result = $this->profissionalRepository->dropProcedimentoProfissional($idProcedimento, $usuario->id);

        return json_encode($result);
    }

    public function postAssistenteStore()
    {
        $usuario = $this->request->user();
        $inputs = $this->request->all();
        $assistente = $this->profissionalRepository->addAssistente($inputs, $usuario->id);

        if ($assistente->id) {
            return redirect('/cadastro/profissional/assistentes');
        } else {
            return back()->withInput();
        }
    }

    public function postAssistenteUpdate()
    {
        $usuario = $this->request->user();
        $idAssistente = $this->request->input('idAssistente');

        $result = $this->profissionalRepository->updateAssistenteStatus($idAssistente, $usuario->id);

        return $result;
    }

    private function checkAcessoProfissional()
    {
        $tiposPessoaPermitidos = ['PJ', 'PF'];
        $usuario = $this->request->user();
        $tipoPessoa = $this->profissionalRepository->getTipoPessoa($usuario->id);

        return in_array($tipoPessoa, $tiposPessoaPermitidos);
    }

}
