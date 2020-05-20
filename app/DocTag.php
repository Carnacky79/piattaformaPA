<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property int $id_doc
 * @property int $id_tag
 * @property Documenti $documenti
 * @property Tag $tag
 */
class DocTag extends Pivot
{
    protected $table = 'doc_tags';
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['id_doc', 'id_tag'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function documenti()
    {
        return $this->belongsTo('App\Documento', 'id', 'id_doc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function tag()
    {
        return $this->belongsTo('App\Tag', 'id', 'id_tag');
    }

    public function utente(){
        return $this->belongsTo('App\Utente', 'id', 'id_utente');
    }
}
