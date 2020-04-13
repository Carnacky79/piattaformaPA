<?php

namespace App\Http\Controllers;

use App\Documento;
use App\Tag;
use Illuminate\Http\Request;

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
            $doc->tags()->attach($inTag->id);
        }else{
            $Tag = new Tag;
            $Tag->tag = $tag;
            $Tag->save();
            $doc->tags()->attach($Tag->id);
        }
    }

    public function percTag(){
        $tags = Tag::All();
        $data = json_encode($tags);
        return view('perctag')->with(['data' => $data]);
    }
}
