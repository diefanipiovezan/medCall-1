<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPessoa extends Model
{
    protected $table = 'tbl_tipo_pessoa';
    public $timestamps = false;

    public function pessoas()
    {
        return $this->hasMany('App\Models\Pesssoa', 'id_tipo_pessoa');
    }
}
