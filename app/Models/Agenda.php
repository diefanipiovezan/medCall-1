<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'tbl_agenda';
    public $timestamps = false;

    public function profissional()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_profissional');
    }

    public function paciente()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_paciente');
    }

    public function procedimento()
    {
        return $this->belongsTo('App\Models\Procedimento', 'id_procedimento');
    }

    public function convenio()
    {
        return $this->belongsTo('App\Models\Convenio', 'id_convenio');
    }
}
