<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedimentoPessoa extends Model
{
    protected $table = 'tbl_procedimento_pessoa';
    public $timestamps = false;

    public function procedimento()
    {
        return $this->belongsTo('App\Models\Procedimento', 'id_procedimento');
    }

    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoa');
    }
}
