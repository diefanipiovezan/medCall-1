<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\PessoaRepository;
use App\Http\Repositories\PessoaFisicaRepository;

class PessoaFisicaController extends Controller
{
    public function getCreate(PessoaRepository $pessoaRepository)
    {
        $estados = $pessoaRepository->getEstados();
        $tiposTelefone = $pessoaRepository->getTiposTelefone();

        return view('cadastro.pessoafisica', [
            'estados' => $estados,
            'tiposTelefone' => $tiposTelefone
        ]);
    }

    public function postStore(Request $request, PessoaFisicaRepository $pessoaFisicaRepository)
    {
        $inputs = $request->all();
        $pessoaFisica = $pessoaFisicaRepository->store($inputs);

        if ($pessoaFisica->id) {
            return redirect('login')->with('success-msg', 'Cadastro realizado com sucesso!');
        } else {
            return back()->withInput();
        }
    }
}
