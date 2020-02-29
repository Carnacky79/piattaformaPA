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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documenti()
    {
        return $this->belongsTo('App\Documenti', 'id', 'id_convocazione');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ordiniGiorno()
    {
        return $this->belongsTo('App\OrdiniGiorno', 'id', 'id_convocazione');
    }
}
