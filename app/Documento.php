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
    public $timestamps = false;

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
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'doc_tags', 'id_doc', 'id_tag');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function convocazioni()
    {
        return $this->belongsTo('App\Convocazioni', 'id_convocazione', 'id');
    }
}
