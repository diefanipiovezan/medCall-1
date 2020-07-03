<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspecialidadePessoa extends Model
{
    protected $table = 'tbl_especialidade_pessoa';
    public $timestamps = false;

    public function especialidade()
    {
        return $this->belongsTo('App\Models\Especialidade', 'id_especialidade');
    }

    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoa');
    }
}
