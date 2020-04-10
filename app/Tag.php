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
    public function docTag()
    {
        return $this->hasMany('App\DocTag', 'id_tag', 'id');
    }
}
