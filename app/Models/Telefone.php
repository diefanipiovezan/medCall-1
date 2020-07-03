<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $table = 'tbl_telefone';
    public $timestamps = false;

    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoa');
    }

    public function tipoTelefone()
    {
        return $this->belongsTo('App\Models\TipoTelefone', 'id_tipo_telefone');
    }
}
