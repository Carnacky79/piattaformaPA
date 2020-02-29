<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nome_file
 * @property string $tipo_file
 * @property string $percorso_file
 * @property integer $preferito
 * @property int $id_convocazione
 * @property DocTag $docTag
 * @property Convocazioni $convocazioni
 */
class Documento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'documenti';

    /**
     * @var array
     */
    protected $fillable = ['nome_file', 'tipo_file', 'percorso_file', 'preferito', 'id_convocazione'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docTag()
    {
        return $this->belongsTo('App\DocTag', 'id', 'id_doc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function convocazioni()
    {
        return $this->hasOne('App\Convocazioni', 'id', 'id_convocazione');
    }
}
