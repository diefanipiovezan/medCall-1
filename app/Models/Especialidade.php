<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    protected $table = 'tbl_especialidade';
    public $timestamps = false;

    public function especialidadesPessoas()
    {
        return $this->hasMany('App\Models\EspecialidadePessoa', 'id_especialidade');
    }
}
