<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'tbl_pessoa';
    public $timestamps = false;

    public function pessoasJuridicas()
    {
        return $this->hasMany('App\Models\PessoaJuridica', 'id_pessoa');
    }

    public function pessoasFisicas()
    {
        return $this->hasMany('App\Models\PessoaFisica', 'id_pessoa');
    }

    // tbl_assistente mappings begin
    public function assistentes()
    {
        return $this->hasMany('App\Models\Assistente', 'id_pessoa');
    }

    public function profissionaisAsistentes()
    {
        return $this->hasMany('App\Models\Assistente', 'id_profissional');
    }
    // tbl_assistente mappings end

    public function pacientes()
    {
        return $this->hasMany('App\Models\Paciente', 'id_pessoa');
    }

    public function telefones()
    {
        return $this->hasMany('App\Models\Telefone', 'id_pessoa');
    }

    public function procedimentosPessoas()
    {
        return $this->hasMany('App\Models\ProcedimentoPessoa', 'id_pessoa');
    }

    public function especialidadesPessoas()
    {
        return $this->hasMany('App\Models\EspecialidadePessoa', 'id_pessoa');
    }

    public function conveniosPessoas()
    {
        return $this->hasMany('App\Models\ConvenioPessoa', 'id_pessoa');
    }

    public function disponibilidades()
    {
        return $this->hasMany('App\Models\Disponibilidade', 'id_pessoa');
    }

    // tbl_agenda mappings begin
    public function profissionaisAgendas()
    {
        return $this->hasMany('App\Models\Agenda', 'id_profissional');
    }

    public function pacientesAgendas()
    {
        return $this->hasMany('App\Models\Agenda', 'id_paciente');
    }
    // tbl_agenda mappings end

    public function tipoPessoa()
    {
        return $this->belongsTo('App\Models\TipoPessoa', 'id_tipo_pessoa');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'id_usuario');
    }
}
