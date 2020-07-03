<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistente extends Model
{
    protected $table = 'tbl_assistente';
    public $timestamps = false;

    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoa');
    }

    public function profissional()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_profissional');
    }
}
