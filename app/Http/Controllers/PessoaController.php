<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\PessoaRepository;

class PessoaController extends Controller
{
    protected $request;
    protected $pessoaRepository;

    public function __construct(Request $request, PessoaRepository $pessoaRepository)
    {
        $this->request = $request;
        $this->pessoaRepository = $pessoaRepository;
    }

    public function checkUniqueLogin()
    {
        $username = $this->request->input('username');
        $result = $this->pessoaRepository->checkUniqueLogin($username);

        return $result;
    }

    public function getCidadesByEstado()
    {
        $idEstado = $this->request->input('idEstado');
        $cidades = $this->pessoaRepository->getCidadesByEstado($idEstado);

        return $cidades;
    }

    public function getBairrosByCidade()
    {
        $idCidade = $this->request->input('idCidade');
        $bairros = $this->pessoaRepository->getBairrosByCidade($idCidade);

        return $bairros;
    }

    public function postAddCidade()
    {
        $idEstado = $this->request->input('idEstado');
        $nome = $this->request->input('nome');

        $cidade = $this->pessoaRepository->addCidade($idEstado, $nome);

        return $cidade;
    }

    public function postAddBairro()
    {
        $idCidade = $this->request->input('idCidade');
        $nome = $this->request->input('nome');

        $bairro = $this->pessoaRepository->addBairro($idCidade, $nome);

        return $bairro;
    }

    public function getUpdateInformacoesUsuario()
    {
        $usuario = $this->request->user();
        $dados = $this->pessoaRepository->getInformacoesUsuario($usuario);

        return view('cadastro.atualizar-dados', ['dados' => $dados]);
    }

    public function postUpdateInformacoesUsuario()
    {
        $inputs = $this->request->all();
        $usuario = $this->request->user();

        $result = $this->pessoaRepository->updateInformacoesUsuario($inputs, $usuario);

        if ($result['status'] === 'OK') {
            return redirect('/');
        } else {
            return back()->withInput();
        }
    }

}
