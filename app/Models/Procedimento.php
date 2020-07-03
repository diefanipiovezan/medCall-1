<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{
    protected $table = 'tbl_procedimento';
    public $timestamps = false;

    public function procedimentosPessoas()
    {
        return $this->hasMany('App\Models\ProcedimentoPessoa', 'id_procedimento');
    }
}
