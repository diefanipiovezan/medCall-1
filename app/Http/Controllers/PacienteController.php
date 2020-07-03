<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\PessoaRepository;
use App\Http\Repositories\PacienteRepository;

class PacienteController extends Controller
{
    public function getCreate(PessoaRepository $pessoaRepository)
    {
        $estados = $pessoaRepository->getEstados();
        $tiposTelefone = $pessoaRepository->getTiposTelefone();

        return view('cadastro.paciente', [
            'estados' => $estados,
            'tiposTelefone' => $tiposTelefone
        ]);
    }

    public function postStore(Request $request, PacienteRepository $pacienteRepository)
    {
        $inputs = $request->all();
        $paciente = $pacienteRepository->store($inputs);

        if ($paciente->id) {
            return redirect('login')->with('success-msg', 'Cadastro realizado com sucesso!');
        } else {
            return back()->withInput();
        }
    }
}
