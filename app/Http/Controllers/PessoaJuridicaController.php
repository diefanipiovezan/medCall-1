<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\PessoaRepository;
use App\Http\Repositories\PessoaJuridicaRepository;

class PessoaJuridicaController extends Controller
{
    public function getCreate(PessoaRepository $pessoaRepository)
    {
        $estados = $pessoaRepository->getEstados();
        $tiposTelefone = $pessoaRepository->getTiposTelefone();

        return view('cadastro.pessoajuridica', [
            'estados' => $estados,
            'tiposTelefone' => $tiposTelefone
        ]);
    }

    public function postStore(Request $request, PessoaJuridicaRepository $pessoaJuridicaRepository)
    {
        $inputs = $request->all();
        $pessoaJuridica = $pessoaJuridicaRepository->store($inputs);

        if ($pessoaJuridica->id) {
            return redirect('login')->with('success-msg', 'Cadastro realizado com sucesso!');
        } else {
            return back()->withInput();
        }
    }
}
