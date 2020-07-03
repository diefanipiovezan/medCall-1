<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $table = 'tbl_convenio';
    public $timestamps = false;

    public function conveniosPessoas()
    {
        return $this->hasMany('App\Models\ConvenioPessoa', 'id_convenio');
    }

    public function agendas()
    {
        return $this->hasMany('App\Models\Agenda', 'id_convenio');
    }
}
