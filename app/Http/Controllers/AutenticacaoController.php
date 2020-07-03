<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Repositories\PessoaRepository;

class AutenticacaoController extends Controller
{
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('login');
    }

    public function postLogin(Request $request, PessoaRepository $pessoaRepository)
    {
        $credenciais = $request->only('username', 'password');
        $credenciais['status'] = 'A';
        if (Auth::attempt($credenciais)) {
            $user = Auth::user();
            $tipoPessoa = $pessoaRepository->getTipoPessoa($user->id);

            session()->put('TIPO_PESSOA', $tipoPessoa);

            // Se for Paciente (PP) vai p/ pagina de pesquisa, senão é Profissional (PF, PJ) ou Assistente (PA)
            if ($tipoPessoa === 'PP') {
                return redirect()->route('home');
            } else {
                return redirect('/agenda/profissional');
            }

        }

        return redirect()->route('login')->with('error-msg', 'Usuário ou senha inválidos!');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
