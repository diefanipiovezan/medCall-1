<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    protected $table = 'tbl_bairro';
    public $timestamps = false;

    public function logradouros()
    {
        return $this->hasMany('App\Models\Logradouro', 'id_bairro');
    }

    public function cidade()
    {
        return $this->belongsTo('App\Models\Cidade', 'id_cidade');
    }
}
