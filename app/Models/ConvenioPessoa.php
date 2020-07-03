<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConvenioPessoa extends Model
{
    protected $table = 'tbl_convenio_pessoa';
    public $timestamps = false;

    public function convenio()
    {
        return $this->belongsTo('App\Models\Convenio', 'id_convenio');
    }

    public function pessoa()
    {
        return $this->belongsTo('App\Models\Pessoa', 'id_pessoa');
    }
}
