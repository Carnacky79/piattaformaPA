<?php

namespace App\Http\Controllers;

use App\DocTag;
use App\Documento;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listaTag(){
        $suggestions = ['suggestions' => []];
        $tags = Tag::get('tag')->toArray();
        foreach($tags as $key => $values){
            foreach($values as $k => $value){
                array_push($suggestions['suggestions'], $value);
            }
        }


        return $suggestions;
    }

    public function addTag($id, $tag){
        $doc = Documento::find($id);
        $inTag = Tag::where('tag', '=', $tag)->first();
        if($inTag !== null){
            $doc->tags()->attach($inTag->id, ['id_utente' =>Auth::id()]);
        }else{
            $Tag = new Tag;
            $Tag->tag = $tag;
            $Tag->save();
            $doc->tags()->attach($Tag->id, ['id_utente' =>Auth::id()]);
        }

    }

    public function percTag($input = ''){
        $numeroDocumenti = [];
        $tags = DocTag::where('id_utente', Auth::id())->with('tag')->get()->map(function($docTag) use(&$numeroDocumenti){
            if (!isset($numeroDocumenti[$docTag->tag->tag])) {
                $numeroDocumenti[$docTag->tag->tag] = 0;
            }
            $numeroDocumenti[$docTag->tag->tag] += 1;

            return $docTag->tag;
        })->unique(function($tag) {
            return $tag->id;
        });

        $documenti = Documento::with('tags')->whereHas('tags', function($query) use($input){
            $query->where('tag', 'like', $input);
        })->get();

        $data = [];
        $data['labels'] = [];
        $data['datasets']['data'] = [];
        $data['datasets']['backgroundColor'] = [];

        foreach($tags as $tag){
            $primo = random_int(0,255);
            $secondo = random_int(0,255);
            $terzo = random_int(0,255);
            $rgb = 'rgb('.$primo.','.$secondo.','.$terzo.')';
            $data['labels'][] = $tag['tag'];
            $data['datasets']['data'][] = $numeroDocumenti[$tag->tag];
            $data['datasets']['backgroundColor'][] = $rgb;
        }

        if($input === '') {
            return view('perctag')->with(['data' => json_encode($data), 'Documenti' => $documenti]);
        }else{
            return response()->json($documenti);
        }

    }
}
