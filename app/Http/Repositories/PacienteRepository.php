<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Pessoa;
use App\Models\TipoPessoa;
use App\Models\Paciente;
use App\Models\Logradouro;
use App\Models\Telefone;
use Illuminate\Support\Facades\DB;

class PacienteRepository
{
    public function store($inputs)
    {
        $paciente = new Paciente;

        DB::transaction(function() use ($inputs, $paciente) {
            // Tipo de Pessoa
            $tipoPessoa = TipoPessoa::where('sigla', 'PP')->first();

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

            // Paciente
            $paciente->cpf = str_replace(['.', '-'], '', $inputs['txtCpf']);
            $paciente->rg = $inputs['txtRg'];
            if (isset($inputs['chkDeficiencia'])) {
                $paciente->deficiencia_auditiva = 'S';
            }
            $paciente->dt_nascimento = $inputs['txtDataNascimento'];
            $paciente->id_pessoa = $pessoa->id;
            $paciente->id_logradouro = $logradouro->id;
            $paciente->save();
        });

        return $paciente;
    }
}
