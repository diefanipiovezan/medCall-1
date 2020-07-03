<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logradouro extends Model
{
    protected $table = 'tbl_logradouro';
    public $timestamps = false;

    public function pessoasFisicas()
    {
        return $this->hasMany('App\Models\PessoaFisica', 'id_logradouro');
    }

    public function pessoasJuridicas()
    {
        return $this->hasMany('App\Models\PessoaJuridica', 'id_logradouro');
    }

    public function pacientes()
    {
        return $this->hasMany('App\Models\Paciente', 'id_logradouro');
    }

    public function bairro()
    {
        return $this->belongsTo('App\Models\Bairro', 'id_bairro');
    }
}
