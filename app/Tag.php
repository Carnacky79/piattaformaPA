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
    /**
     * @var array
     */
    protected $fillable = ['tag'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docTag()
    {
        return $this->belongsTo('App\DocTag', 'id', 'id_tag');
    }
}
