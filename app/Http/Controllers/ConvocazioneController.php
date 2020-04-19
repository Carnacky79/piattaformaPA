<?php

namespace App\Http\Controllers;

use App\Ordine;
use App\TipoEventi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Convocazione;

class ConvocazioneController extends Controller
{
    public function index()
    {
        $items = Convocazione::All();
        foreach($items as $key => $value){
            $tipo = $items[$key]['id_tipo'];
            switch($tipo){
                case 0:
                    $items[$key]['color'] = '#43C6DB';
                    break;
                case 1:
                    $items[$key]['color'] = '#4AA02C';
                    break;
                case 2:
                    $items[$key]['color'] = '#FDD017';
                    break;
                case 3:
                    $items[$key]['color'] = '#C34A2C';
                    break;
                case 4:
                    $items[$key]['color'] = '#FF0000';
                    break;
            }

        }

        return view('dashboard',['Events' => $items]);
    }

    public function listaConv(){
        $conv = Convocazione::All();
        $tipologie = TipoEventi::All();


        return view('listaconv',['Convocazioni' => $conv, 'Tipologie' => $tipologie]);

    }

    public function listaConvTipologie($id_tipo = NULL){
        $convocazioni = Convocazione::where('id_tipo','=',$id_tipo)->get();
        $conv = [];
        foreach($convocazioni as $key => $value){
            $conv[$key]['id'] = $value['id'];
            $conv[$key]['titolo'] = $value['titolo'];
            $conv[$key]['descrizione'] = $value['descrizione'];
            $conv[$key]['data_inizio'] = $value['data_inizio'];
            $conv[$key]['data_fine'] = $value['data_fine'];
            $conv[$key]['id_tipo'] = $value['id_tipo'];
        }

        $tipologie = TipoEventi::All();
        if($id_tipo === NULL) {
            return view('listatipologie', ['Convocazioni' => json_encode($conv), 'Tipologie' => $tipologie]);
        }else{
            return response()->json($conv);
        }

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titolo_convocazione' => 'required',
            'desc_convocazione' => 'required',
            'data_inizio' => 'required|date',
        ]);

        if($validator->fails()){
            return redirect('creaconv')->withErrors($validator)->withInput();
        }

        $conv = new Convocazione;

        $data = $request->all();

        $conv->titolo = $data['titolo_convocazione'];
        $conv->descrizione = $data['desc_convocazione'];
        $conv->data_inizio = $data['data_inizio'];
        if($data['data_fine'] !== '') {
            $conv->data_fine = $data['data_fine'];
        }
        $conv->id_tipo = $data['tipologia'];

        $conv->save();

        if($data['titolo_ordine'][0] != '') {
            foreach ($data['titolo_ordine'] as $index => $titolo_ordine) {
                $conv->ordiniGiorno()->create(['titolo_og' => $titolo_ordine, 'descrizione_og' => $data['desc_ordine'][$index]]);
            }
        }

        if($request->hasFile('file')) {
            $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx', 'doc', 'ppt', 'pptx', 'p7n'];
            $files = $data['file'];
            foreach ($files as $file) {
                $random = rand(1,999);
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                $exist = Storage::disk('local')->exists('documenti/'.$filename);

                if ($check) {
                    if($exist){
                        $filename = substr($filename, 0, strpos($filename, '.'.$extension)).$random.'.'.$extension;
                    }
                    $filepath = $file->storeAs(
                        'documenti', $filename
                    );
                    $conv->documenti()->create(['nome_file' => $filename, 'tipo_file' => $extension, 'percorso_file' => $filepath]);
                }
            }
        }

        return $this->listaConv()->with(['success' => 'Convocazione inserita correttamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $conv = Convocazione::find($id);

        $format = 'Y-m-d\TH:i:s';
        $data_inizio = date_create($conv->data_inizio);
        $data_fine = date_create($conv->data_fine);
        $odg = $conv->ordiniGiorno();

        return view('showconv',[
            'id' => $conv->id,
            'titolo' => $conv->titolo,
            'descrizione' => $conv->descrizione,
            'datainizio' => date_format($data_inizio, $format),
            'datafine' => date_format($data_fine, $format),
            'tipologia' => $conv->tipologia->nome_evento,
            'ordinidelgiorno' => $conv->ordiniGiorno()->get(),
            'documenti' => $conv->documenti()->get(),
        ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $req = $request->all();

        $conv = Convocazione::find($id);

        $titolo = $req['titolo_convocazione'];
        $descrizione = $req['desc_convocazione'];
        $data_inizio = $req['data_inizio'];
        $data_fine = $req['data_fine'];
        $tipologia = $req['tipologia'];

        $conv->titolo = $titolo;
        $conv->descrizione = $descrizione;
        $conv->data_inizio = $data_inizio;
        $conv->data_fine = $data_fine;
        $conv->id_tipo = $tipologia;

        $conv->save();

        $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx', 'doc', 'ppt', 'pptx', 'p7n'];
        if($request->hasFile('file')) {
            foreach($req['file'] as $file){
                $random = rand(1,999);
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                $exist = Storage::disk('local')->exists('documenti/'.$filename);

                if ($check) {
                    if($exist){
                        $filename = substr($filename, 0, strpos($filename, '.'.$extension)).$random.'.'.$extension;
                    }
                    $filepath = $file->storeAs(
                        'documenti', $filename
                    );
                    $conv->documenti()->create(['nome_file' => $filename, 'tipo_file' => $extension, 'percorso_file' => $filepath]);
                }
            }
        }

        if($request->has('titolo_ordine')) {

            foreach($req['titolo_ordine'] as $index => $titolo_ordine){
                if($titolo_ordine != '') {
                    //dd($req['id_ordine'][$index]);
                    $odg = Ordine::findOrNew($req['id_ordine'][$index]??0);
                    $odg->titolo_og = $titolo_ordine;
                    $odg->descrizione_og = $req['desc_ordine'][$index];
                    $odg->id_convocazione = $conv->id;
                    $odg->save();
                }
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $convocazione = Convocazione::find($id);
        $convocazione->ordiniGiorno()->delete();
        $convocazione->delete();
    }
}
