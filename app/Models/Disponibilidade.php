<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilidade extends Model
{
    protected $table = 'tbl_disponibilidade';
    public $timestamps = false;

    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoa');
    }
}
