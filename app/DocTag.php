<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_doc
 * @property int $id_tag
 * @property Documenti $documenti
 * @property Tag $tag
 */
class DocTag extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_doc', 'id_tag'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function documenti()
    {
        return $this->hasOne('App\Documenti', 'id', 'id_doc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tag()
    {
        return $this->hasOne('App\Tag', 'id', 'id_tag');
    }
}
