<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $nome_utente
 * @property string $password
 * @property string $ruolo
 */
class Utente extends Authenticatable
{
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'utenti';

    /**
     * @var array
     */
    protected $fillable = ['nome_utente', 'password', 'ruolo'];

    public function tags(){
        return $this->hasMany('App\DocTag', 'id_utente', 'id');
    }

    public function doc_preferiti(){
        return $this->belongsToMany('App\Documento', 'doc_preferiti', 'id_utente', 'id_doc');
    }
}
