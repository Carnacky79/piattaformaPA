@extends('layouts.app', ['activePage' => 'listaconv', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'Lista Convocazioni'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            @if(Auth::user()->ruolo == 'amministratore')
            <div class="row" style="margin-bottom: 20px">
                <div class="col">
                    <a href="{{route('creaConv')}}" class="btn btn-success btn-fill">
                    <span class="nc-icon nc-simple-add"></span>&nbsp;Aggiungi Convocazione
                    </a>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col">
                    <table id='table_id'>

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titolo</th>
                            <th>Descrizione</th>
                            <th>Data Inizio</th>
                            <th>Data Fine</th>
                            @if(Auth::user()->ruolo == 'amministratore')
                                <th>Azioni</th>
                            @endif
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Titolo</th>
                            <th>Descrizione</th>
                            <th>Data Inizio</th>
                            <th>Data Fine</th>
                            @if(Auth::user()->ruolo == 'amministratore')
                                <th>Azioni</th>
                            @endif
                        </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
    $(document).ready( function () {

        function Employee ( name, position, salary, office ) {
            this.name = name;
            this.position = position;
            this.salary = salary;
            this._office = office;

            this.office = function () {
                return this._office;
            }
        };

    let table = $('#table_id').DataTable( {

        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Italian.json"
        },

    data: [
        {
            "id" : '1',
            "titolo" : 'titolo di prova',
            "descrizione" : 'descrizione di prova',
            "datainizio" : "2012/03/29",
            "datafine" : "2012/04/02",

        }
    ],

    columns: [

    { data: 'id' },
    { data: 'titolo' },
    { data: 'descrizione' },
    { data: 'datainizio' },
    { data: 'datafine' },
        {
            "targets": -1,
            "data": null,
            "defaultContent": "<button class='btn btn-outline-primary'><i class='nc-icon nc-tap-01'></i></button>"
        },
    ],

    } );

        $('#table_id tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            alert( data['id'] +"'s salary is: "+ data[ 5 ] );
        } );

    } );
    </script>
@endpush
