<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(),[
            'titolo_convocazione' => 'required',
            'desc_convocazione' => 'required',
            'data_inizio' => 'required|date',
            'data_fine' => 'required|date'
        ]);

        if($validator->fails()){
            return redirect('creaconv')->withErrors($validator)->withInput();
        }

        $conv = new Convocazione;

        $data = $request->all();

        $conv->titolo = $data['titolo_convocazione'];
        $conv->descrizione = $data['desc_convocazione'];
        $conv->data_inizio = $data['data_inizio'];
        $conv->data_fine = $data['data_fine'];

        $conv->save();

        foreach($data['titolo_ordine'] as $index => $titolo_ordine){
            $conv->ordiniGiorno()->create(['titolo_og' => $titolo_ordine, 'descrizione_og' => $data['desc_ordine'][$index]]);
        }

        //dd($request->input('titolo_convocazione'));
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
