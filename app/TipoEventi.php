<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEventi extends Model
{
    public $timestamps = false;

    protected $table = 'tipo_eventi';

    public function convocazioni(){
        return $this->belongsTo('App\Convocazione','id_tipo');
    }
}
