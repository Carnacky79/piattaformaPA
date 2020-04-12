<?php

namespace App\Http\Controllers;

use App\Documento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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
        $docs = Documento::with('tags')->get();
        //dd($docs);

        return view('listadoc',['Documenti' => $docs]);

    }

    public function listaDocPref(){
        $docs = Documento::with('tags')->where('preferito','=', 1)->get();
        //dd($docs);

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

    public function deltag($id)
    {
        $doc = Documento::find($id);
        $doc->tags()->detach();

        return response()->json(['success' => true]);

    }

    public function addDocFav($id)
    {
        $doc = Documento::find($id);
        if($doc->preferito == 0){
            $doc->preferito = 1;
        }else{
            $doc->preferito = 0;
        }

        $doc->save();

        return response()->json(['success' => true]);

    }
}
