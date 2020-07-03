<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = 'tbl_cidade';
    public $timestamps = false;

    public function bairros()
    {
        return $this->hasMany('App\Models\Bairro', 'id_cidade');
    }

    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'id_estado');
    }
}
