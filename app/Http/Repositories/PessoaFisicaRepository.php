<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Pessoa;
use App\Models\TipoPessoa;
use App\Models\PessoaFisica;
use App\Models\Logradouro;
use App\Models\Telefone;
use Illuminate\Support\Facades\DB;

class PessoaFisicaRepository
{
    public function store($inputs)
    {
        $pessoaFisica = new PessoaFisica;

        DB::transaction(function() use ($inputs, $pessoaFisica) {
            // Tipo de Pessoa
            $tipoPessoa = TipoPessoa::where('sigla', 'PF')->first();

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

            // Logradouro
            $logradouro = new Logradouro;
            $logradouro->cep = $inputs['txtCep'];
            $logradouro->nome = $inputs['txtLogradouro'];
            $logradouro->numero = $inputs['txtNumero'];
            $logradouro->complemento = $inputs['txtComplemento'];
            $logradouro->id_bairro = $inputs['cboBairro'];
            $logradouro->save();

            // Telefone(s)
            for ($i=0, $j = count($inputs['txtNumeroTelefone']); $i < $j; $i++) {
                $ddd = substr($inputs['txtNumeroTelefone'][$i], 0, 2);
                $numero = substr($inputs['txtNumeroTelefone'][$i], 2);

                $telefone = new Telefone;
                $telefone->ddd = $ddd;
                $telefone->numero = $numero;
                $telefone->id_tipo_telefone = $inputs['cboTipoTelefone'][$i];
                $telefone->id_pessoa = $pessoa->id;
                $telefone->save();
            }

            // PessoaFisica
            $pessoaFisica->cpf = str_replace(['.', '-'], '', $inputs['txtCpf']);
            $pessoaFisica->rg = $inputs['txtRg'];
            $pessoaFisica->registro = $inputs['txtRegistro'];
            $pessoaFisica->id_pessoa = $pessoa->id;
            $pessoaFisica->id_logradouro = $logradouro->id;
            $pessoaFisica->save();
        });

        return $pessoaFisica;
    }
}
