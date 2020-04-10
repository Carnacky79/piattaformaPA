<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $titolo_og
 * @property string $descrizione_og
 * @property int $id_convocazione
 * @property Convocazioni $convocazioni
 */
class Ordine extends Model
{

    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ordini_giorno';

    /**
     * @var array
     */
    protected $fillable = ['titolo_og', 'descrizione_og', 'id_convocazione'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function convocazioni()
    {
        return $this->belongsTo('App\Convocazione', 'id_convocazione');
    }
}
