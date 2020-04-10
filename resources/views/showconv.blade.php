@extends('layouts.app', ['activePage' => 'creaconv', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'Aggiungi nuova Convocazione'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <form class="form" method="POST" action="{{ route('addConv') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-login card-hidden">
                            <div class="card-header ">
                                <h3 class="header text-center">{{ __('Aggiungi Convocazione') }}</h3>
                            </div>
                            <div class="card-body ">

                                    <div class="form-group">
                                        <label for="titolo_convocazione" class="col-md-6 col-form-label">{{ __('Titolo') }}</label>

                                        <div class="col-md-14">
                                            <input @if(Auth::user()->ruolo == 'consigliere') disabled="disabled"@endif placeholder="Titolo della convocazione" id="titolo_convocazione" type="text" class="form-control @error('titolo_convocazione') is-invalid @enderror" name="titolo_convocazione"
                                                   value="@if($titolo != ''){{$titolo}}@else{{ old('titolo_convocazione') }}@endif" required autofocus>

                                            @error('titolo_convocazione')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="desc_convocazione" class="col-md-6 col-form-label">{{ __('Descrizione') }}</label>

                                            <div class="col-md-14">
                                                <textarea placeholder="Descrizione della convocazione" style="height:6rem" rows="3" id="desc_convocazione" class="form-control @error('desc_convocazione') is-invalid @enderror" name="desc_convocazione"  required >
                                                </textarea>
                                                @error('desc_convocazione')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mt-2 col-6">
                                                <label for="data_inizio" class="col-md-6 col-form-label">{{ __('Data inizio') }}</label>

                                                <div class="col-md-12">
                                                    <input id="data_inizio" type="datetime-local" class="form-control @error('data_inizio') is-invalid @enderror" name="data_inizio" value="{{ old('tdata_inizio') }}" required autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 col-6">
                                                <label for="data_fine" class="col-md-6 col-form-label">{{ __('Data fine') }}</label>

                                                <div class="col-md-12">
                                                    <input id="data_fine" type="datetime-local" class="form-control @error('data_fine') is-invalid @enderror" name="data_fine" value="{{ old('data_fine') }}" required autofocus>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group mt-3" id="added">
                                        <div class="col-12 text-left mt-5 mb-1">
                                            <h5>Ordine del Giorno</h5>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mt-2 col-4">
                                                <label for="titolo_ordine" class="d-inline col-md-6 col-form-label">{{ __('Titolo') }}</label>
                                                <input style="width:60%" id="titolo_ordine" type="text" class="d-inline form-control " name="titolo_ordine[]" value="{{ old('titolo_ordine') }}"  autofocus>
                                            </div>
                                            <div class="form-group mt-2 col-5">
                                                <label for="desc_ordine" class="d-inline col-md-6 col-form-label">{{ __('Descrizione') }}</label>
                                                <input style="width:60%" id="desc_ordine" type="text" class="d-inline form-control " name="desc_ordine[]" value="{{ old('desc_ordine') }}"  autofocus>
                                            </div>
                                            <div class="form-group mt-2 col-3">
                                                <button onclick="addOrder(event)" id="aggiungiordine" class="btn btn-success btn-wd">{{ __('Aggiungi') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3" id="files">
                                        <div class="col-12 text-left mt-5 mb-1">
                                            <h5>Lista Documenti e Files</h5>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mt-2 col-6">
                                                <label for="file" class="d-inline col-md-6 col-form-label">{{ __('Documento') }}</label>
                                                <input style="width:60%" id="file" type="file" class="d-inline form-control " name="file[]" autofocus>
                                            </div>
                                            <div class="form-group mt-2 col-3">

                                            </div>
                                            <div class="form-group mt-2 col-3">
                                                <button onclick="addDoc(event)" id="aggiungidocumento" class="btn btn-success btn-wd">{{ __('Aggiungi Documento') }}</button>
                                            </div>
                                        </div>
                                    </div>

                                <div class="card-footer ml-auto mr-auto">
                                    <div class="container text-center mx-auto" style="max-width: 100%" >
                                        <button type="submit" class="btn btn-warning btn-wd">{{ __('Salva') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function addOrder(event){
        event.preventDefault();
        $("#aggiungiordine").remove();
        const html =`
        <div class="row">
            <div class="form-group mt-2 col-4">
                <label for="titolo_ordine" class="d-inline col-md-6 col-form-label">{{ __('Titolo') }}</label>
                <input style="width:60%" id="titolo_ordine" type="text" class="d-inline form-control " name="titolo_ordine[]" value="{{ old('titolo_ordine') }}"  autofocus>
            </div>
            <div class="form-group mt-2 col-5">
                <label for="desc_ordine" class="d-inline col-md-6 col-form-label">{{ __('Descrizione') }}</label>
                <input style="width:60%" id="desc_ordine" type="text" class="d-inline form-control " name="desc_ordine[]" value="{{ old('desc_ordine') }}"  autofocus>
            </div>
            <div class="form-group mt-2 col-3">
                <button onclick="addOrder(event)" id="aggiungiordine" class="btn btn-success btn-wd">{{ __('Aggiungi') }}</button>
            </div>
        </div>
        `;

         $("#added").append(html);
    }

    function addDoc(event){
        event.preventDefault();
        $("#aggiungidocumento").parent('div').remove();
        const html =`
        <div class="row">
            <div class="form-group mt-2 col-6">
                <label for="file" class="d-inline col-md-6 col-form-label">{{ __('Documento') }}</label>
                <input style="width:60%" id="file" type="file" class="d-inline form-control " name="file[]" autofocus>
            </div>
            <div class="form-group mt-2 col-3">
                <button onclick="delDoc(event)" id="eliminadocumento" class="btn btn-danger btn-wd">{{ __('Elimina Documento') }}</button>
            </div>
            <div class="form-group mt-2 col-3">
                <button onclick="addDoc(event)" id="aggiungidocumento" class="btn btn-success btn-wd">{{ __('Aggiungi Documento') }}</button>
            </div>
        </div>
        `;

        $("#files").append(html);
    }

    function delDoc(event){
        const button =`
            <div class="form-group mt-2 col-3">
                <button onclick="addDoc(event)" id="aggiungidocumento" class="btn btn-success btn-wd">{{ __('Aggiungi Documento') }}</button>
            </div>
        `;

        event.preventDefault();

        if($(event.target).parent().siblings('div').has('button').length != 0) {
            $(event.target).parent().parent().prev().append(button);
        }
        $(event.target).parent().parent().remove();
    }
</script>
@endpush
