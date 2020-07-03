<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTelefone extends Model
{
    protected $table = 'tbl_tipo_telefone';
    public $timestamps = false;

    public function telefones()
    {
        return $this->hasMany('App\Models\Telefone', 'id_tipo_telefone');
    }
}
