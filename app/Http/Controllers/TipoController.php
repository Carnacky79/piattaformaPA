<?php

namespace App\Http\Controllers;

use App\TipoEventi;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function tipologie(){
        $tipologie = TipoEventi::All();
        return response()->json($tipologie);
    }
}
