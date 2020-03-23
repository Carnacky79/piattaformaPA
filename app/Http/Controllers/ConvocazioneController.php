<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Convocazione;

class ConvocazioneController extends Controller
{
    public function index()
    {
        $conv = DB::table('convocazioni')->get();

        //dd(count($conv));

        $Events = array
        (
            "0" => array
            (
                "title" => "Event One",
                "start" => "2018-10-31",
            ),
            "1" => array
            (
                "title" => "Event Two",
                "start" => "2018-11-01",
            )
        );
        return view('dashboard',['Events' => $Events]);
    }

    public function listaConv(){
        $conv = Convocazione::All();

        return view('listaconv',['Convocazioni' => $conv]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('creaconv');
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
}
