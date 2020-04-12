<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $tag
 * @property DocTag $docTag
 */
class Tag extends Model
{

    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['tag'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docs()
    {
        return $this->belongsToMany('App\Documento', 'doc_tags', 'id_tag', 'id_doc');
    }
}
