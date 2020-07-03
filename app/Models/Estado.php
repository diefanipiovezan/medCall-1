<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'tbl_estado';
    public $timestamps = false;

    public function cidades()
    {
        return $this->hasMany('App\Models\Cidade', 'id_estado');
    }
}
