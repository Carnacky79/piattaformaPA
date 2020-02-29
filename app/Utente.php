<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nome_utente
 * @property string $password
 * @property string $ruolo
 */
class Utente extends Model
{
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

}
