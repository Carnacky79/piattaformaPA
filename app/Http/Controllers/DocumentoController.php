<?php

namespace App\Http\Controllers;

use App\Documento;
use App\Tag;
use App\Utente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function listaDoc(){
        $user = Utente::find(Auth::id());
        $docs = Documento::with(['tags' => function($query) use($user){
            $query->wherePivot('id_utente', $user->id);
        }, 'utenti_preferiti' => function($query) use($user){
            $query->where('id_utente', $user->id);
        }])->get()->each(function($documento) {
            $documento->preferito = ($documento->utenti_preferiti->count() > 0);
        });

        return view('listadoc',['Documenti' => $docs]);

    }

    public function listaDocPref(){
        $docs = Documento::with('tags')->whereHas('utenti_preferiti', function($query) {
            $query->where('id_utente', '=', Auth::id());
        })->get();

        $count = count($docs);

        for($i = 0; $i < $count; $i++){
            $docs[$i]['preferito'] = 1;
        }

        return view('listadocpref',['Documenti' => $docs]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $filedoc = Documento::find($id);
        $filedoc->tags()->detach();
        $filedoc = $filedoc->nome_file;

        Documento::destroy($id);
        Storage::delete('documenti/'.$filedoc);
        return response()->json(['success' => true]);

    }

    public function deltag($id, $tagName)
    {
        $tag = Tag::where('tag', 'like', $tagName)->get();
        //dd($tag);
        return DB::table('doc_tags')->where([
            ['id_doc', $id],
            ['id_tag', $tag[0]->id],
            ['id_utente', Auth::id()]
        ])->delete();

        return response()->json(['success' => true]);

    }

    public function addDocFav($id)
    {
        $doc = Documento::find($id);
        $utente = Auth::id();

        $doc->utenti_preferiti()->toggle($utente);

        $doc->save();

        return response()->json(['success' => true]);

    }
}
