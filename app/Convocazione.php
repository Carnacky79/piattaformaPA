<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $titolo
 * @property string $descrizione
 * @property string $data_inizio
 * @property string $data_fine
 * @property Documenti $documenti
 * @property OrdiniGiorno $ordiniGiorno
 */
class Convocazione extends Model
{
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'convocazioni';

    /**
     * @var array
     */
    protected $fillable = ['titolo', 'descrizione', 'data_inizio', 'data_fine'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documenti()
    {
        return $this->hasMany('App\Documento', 'id_convocazione', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordiniGiorno()
    {
        return $this->hasMany('App\Ordine', 'id_convocazione', 'id');
    }

    public function tipologia(){
        return $this->hasOne('App\TipoEventi', 'id', 'id_tipo');
    }
}
