<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Pessoa;
use App\Models\TipoPessoa;
use App\Models\PessoaJuridica;
use App\Models\Logradouro;
use App\Models\Telefone;
use Illuminate\Support\Facades\DB;

class PessoaJuridicaRepository
{
    public function store($inputs)
    {
        $pessoaJuridica = new PessoaJuridica;

        DB::transaction(function() use ($inputs, $pessoaJuridica) {
            // Tipo de Pessoa
            $tipoPessoa = TipoPessoa::where('sigla', 'PJ')->first();

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

            // PessoaJuridica
            $pessoaJuridica->razao_social = $inputs['txtRazaoSocial'];
            $pessoaJuridica->nome_fantasia = $inputs['txtNomeFantasia'];
            $pessoaJuridica->cnpj = str_replace(['.', '-'], '', $inputs['txtCnpj']);
            $pessoaJuridica->registro = $inputs['txtRegistro'];
            $pessoaJuridica->id_pessoa = $pessoa->id;
            $pessoaJuridica->id_logradouro = $logradouro->id;
            $pessoaJuridica->save();
        });

        return $pessoaJuridica;
    }
}
