<?php

namespace App\Http\Repositories;

use App\Models\Telefone;
use App\Models\TipoTelefone;
use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Bairro;
use App\Models\Logradouro;
use App\Models\Pessoa;
use App\Models\PessoaFisica;
use App\Models\PessoaJuridica;
use App\Models\Assistente;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Convenio;
use App\Models\ConvenioPessoa;
use App\Models\Especialidade;
use Illuminate\Support\Facades\DB;

class PessoaRepository
{
    public function checkUniqueLogin($login)
    {
        $result = [
            'status' => 'NOK',
            'message' => 'Já existe um usuário cadastrado com este nome!'
        ];

        $usuario = User::where('username', $login)->first();

        if ($usuario === null) {
            $result = [
                'status' => 'OK',
                'message' => 'OK, username não existente.'
            ];
        }

        return $result;
    }

    public function getTipoPessoa($idUsuario)
    {
        $pessoa = Pessoa::with('TipoPessoa')->where('id_usuario', $idUsuario)->first();
        $tipoPessoa = $pessoa->tipoPessoa->sigla;

        return $tipoPessoa;
    }

    public function getTiposTelefone()
    {
        $tiposTelefone = TipoTelefone::all()->sortBy('tipo');

        return $tiposTelefone;
    }

    public function getEstados()
    {
        $estados = Estado::all();

        return $estados;
    }

    public function getCidadesByEstado($idEstado)
    {
        $cidades = Cidade::where('id_estado', $idEstado)
                    ->orderBy('nome', 'asc')
                    ->get();

        return $cidades;
    }

    public function getBairrosByCidade($idCidade)
    {
        $bairros = Bairro::where('id_cidade', $idCidade)
                    ->orderBy('nome', 'asc')
                    ->get();

        return $bairros;
    }

    public function addCidade($idEstado, $nome)
    {
        $cidade = new Cidade;
        $cidade->nome = $nome;
        $cidade->id_estado = $idEstado;
        $cidade->save();

        return $cidade;
    }

    public function addBairro($idCidade, $nome)
    {
        $bairro = new Bairro;
        $bairro->nome = $nome;
        $bairro->id_cidade = $idCidade;
        $bairro->save();

        return $bairro;
    }

    public function getInformacoesUsuario($usuario)
    {
        $result = [];
        $pessoa = Pessoa::with('TipoPessoa')->where('id_usuario', $usuario->id)->first();

        if ($pessoa->tipoPessoa->sigla === 'PP') {
            $paciente = Paciente::where('id_pessoa', $pessoa->id)->first();
            $logradouro = Logradouro::find($paciente->id_logradouro);
            $bairro = Bairro::find($logradouro->id_bairro);
            $cidade = Cidade::find($bairro->id_cidade);
            $cidades = Cidade::where('id_estado', $cidade->id_estado)->get();
            $bairros = Bairro::where('id_cidade', $cidade->id)->get();

            $result['paciente'] = $paciente;
            $result['cidades'] = $cidades;
            $result['bairros'] = $bairros;
        } elseif ($pessoa->tipoPessoa->sigla === 'PF') {
            $pessoaFisica = PessoaFisica::where('id_pessoa', $pessoa->id)->first();

            $logradouro = Logradouro::find($pessoaFisica->id_logradouro);
            $bairro = Bairro::find($logradouro->id_bairro);
            $cidade = Cidade::find($bairro->id_cidade);
            $cidades = Cidade::where('id_estado', $cidade->id_estado)->get();
            $bairros = Bairro::where('id_cidade', $cidade->id)->get();

            $result['pessoafisica'] = $pessoaFisica;
            $result['cidades'] = $cidades;
            $result['bairros'] = $bairros;
        } elseif ($pessoa->tipoPessoa->sigla === 'PJ') {
            $pessoaJuridica = PessoaJuridica::where('id_pessoa', $pessoa->id)->first();

            $logradouro = Logradouro::find($pessoaJuridica->id_logradouro);
            $bairro = Bairro::find($logradouro->id_bairro);
            $cidade = Cidade::find($bairro->id_cidade);
            $cidades = Cidade::where('id_estado', $cidade->id_estado)->get();
            $bairros = Bairro::where('id_cidade', $cidade->id)->get();

            $result['pessoajuridica'] = $pessoaJuridica;
            $result['cidades'] = $cidades;
            $result['bairros'] = $bairros;
        } elseif ($pessoa->tipoPessoa->sigla === 'PA') {
            $assistente = Assistente::where('id_pessoa', $pessoa->id)->first();

            $result['assistente'] = $assistente;
            $logradouro = null;
            $logradouro = null;
            $bairro = null;
            $cidade = null;

        }
        $estados = Estado::all();
        $tiposTelefone = TipoTelefone::all();
        $telefones = Telefone::with('TipoTelefone')->where('id_pessoa', $pessoa->id)->get();

        $result['usuario'] = $usuario;
        $result['pessoa'] = $pessoa;
        $result['logradouro'] = $logradouro;
        $result['bairro'] = $bairro;
        $result['cidade'] = $cidade;
        $result['estados'] = $estados;
        $result['tiposTelefone'] = $tiposTelefone;
        $result['telefones'] = $telefones;

        return $result;
    }

    // TODO: Refatorar este método, dividir em mais métodos de acordo com o tipo de pessoa...
    public function updateInformacoesUsuario($inputs, $usuario)
    {
        $result = [
            'status' => 'NOK',
            'message' => 'Erro ao atualizar dados!'
        ];

        DB::transaction(function() use ($inputs, $usuario, &$result) {
            $usuario->email = $inputs['txtEmail'];
            if ($inputs['txtSenha'] !== '') {
                $usuario->password = bcrypt($inputs['txtSenha']);
            }
            $usuario->save();

            $pessoa = Pessoa::with('TipoPessoa')->where('id_usuario', $usuario->id)->first();

            if ($pessoa->tipoPessoa->sigla === 'PP') {
                $pessoa->nome = $inputs['txtNome'];
                $pessoa->save();

                $paciente = Paciente::where('id_pessoa', $pessoa->id)->first();
                $paciente->cpf = str_replace(['.', '-'], '', $inputs['txtCpf']);
                $paciente->rg = $inputs['txtRg'];
                $paciente->deficiencia_auditiva = 'N';
                if (isset($inputs['chkDeficiencia'])) {
                    $paciente->deficiencia_auditiva = 'S';
                }
                $paciente->dt_nascimento = $inputs['txtDataNascimento'];
                $paciente->save();

                $logradouro = Logradouro::find($paciente->id_logradouro);
                $logradouro->cep = $inputs['txtCep'];
                $logradouro->nome = $inputs['txtLogradouro'];
                $logradouro->numero = $inputs['txtNumero'];
                $logradouro->complemento = $inputs['txtComplemento'];
                $logradouro->id_bairro = $inputs['cboBairro'];
                $logradouro->save();

                Telefone::where('id_pessoa', $pessoa->id)->delete();
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

                $result = [
                    'status' => 'OK',
                    'message' => 'Dados atualizados com sucesso!'
                ];
            } elseif ($pessoa->tipoPessoa->sigla === 'PF') {
                $pessoa->nome = $inputs['txtNome'];
                $pessoa->save();

                $pessoaFisica = PessoaFisica::where('id_pessoa', $pessoa->id)->first();
                $pessoaFisica->cpf = str_replace(['.', '-'], '', $inputs['txtCpf']);
                $pessoaFisica->rg = $inputs['txtRg'];
                $pessoaFisica->registro = $inputs['txtRegistro'];
                $pessoaFisica->save();

                $logradouro = Logradouro::find($pessoaFisica->id_logradouro);
                $logradouro->cep = $inputs['txtCep'];
                $logradouro->nome = $inputs['txtLogradouro'];
                $logradouro->numero = $inputs['txtNumero'];
                $logradouro->complemento = $inputs['txtComplemento'];
                $logradouro->id_bairro = $inputs['cboBairro'];
                $logradouro->save();

                Telefone::where('id_pessoa', $pessoa->id)->delete();
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

                $result = [
                    'status' => 'OK',
                    'message' => 'Dados atualizados com sucesso!'
                ];
            } elseif ($pessoa->tipoPessoa->sigla === 'PJ') {
                $pessoa->nome = $inputs['txtNome'];
                $pessoa->save();

                $pessoaJuridica = PessoaJuridica::where('id_pessoa', $pessoa->id)->first();
                $pessoaJuridica->razao_social = $inputs['txtRazaoSocial'];
                $pessoaJuridica->nome_fantasia = $inputs['txtNomeFantasia'];
                $pessoaJuridica->cnpj = str_replace(['.', '-'], '', $inputs['txtCnpj']);
                $pessoaJuridica->registro = $inputs['txtRegistro'];
                $pessoaJuridica->save();

                $logradouro = Logradouro::find($pessoaJuridica->id_logradouro);
                $logradouro->cep = $inputs['txtCep'];
                $logradouro->nome = $inputs['txtLogradouro'];
                $logradouro->numero = $inputs['txtNumero'];
                $logradouro->complemento = $inputs['txtComplemento'];
                $logradouro->id_bairro = $inputs['cboBairro'];
                $logradouro->save();

                Telefone::where('id_pessoa', $pessoa->id)->delete();
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

                $result = [
                    'status' => 'OK',
                    'message' => 'Dados atualizados com sucesso!'
                ];
            } elseif ($pessoa->tipoPessoa->sigla === 'PA') {
                $pessoa->nome = $inputs['txtNome'];
                $pessoa->save();

                $assistente = Assistente::where('id_pessoa', $pessoa->id)->first();
                $assistente->cpf = str_replace(['.', '-'], '', $inputs['txtCpf']);
                $assistente->rg = $inputs['txtRg'];
                $assistente->save();

                $result = [
                    'status' => 'OK',
                    'message' => 'Dados atualizados com sucesso!'
                ];
            }
        });

        return $result;
    }

}
