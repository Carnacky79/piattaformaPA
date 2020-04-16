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
                            <th>Azioni</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Titolo</th>
                            <th>Descrizione</th>
                            <th>Data Inizio</th>
                            <th>Data Fine</th>
                            <th>Azioni</th>

                        </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        @isset($success)
        $.notify({
            icon: "glyphicon glyphicon-warning-sign",
            message: "{{$success}}"
        },{
            type: 'success',
            timer: 3000,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
        @endisset
        var convocazioni = {!!$Convocazioni!!};

    let table = $('#table_id').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Italian.json"
        },

    data: convocazioni,

    columns: [

    { data: 'id' },
    { data: 'titolo' },
    { data: 'descrizione' },
        {
            "targets": 3,
            "data": "data_inizio",
            "render": function(data, type, row){

                return moment(data).locale('it').format('LLLL');
            }

        },
        {
            "targets": 4,
            "data": "data_fine",
            "render": function(data, type, row){
                if(data !== null){
                    return moment(data).locale('it').format('LLLL');
                }else{
                    return "Nessuna data inserita";
                }
            }

        },
        {
            "targets": -1,
            "data": null,
            "defaultContent": "" +
                "<button id='view' class='btn btn-primary btn-fill'><i class='nc-icon nc-zoom-split'></i></button>"
                @if(Auth::user()->ruolo == 'amministratore')
                +
                "<button id='delete' class='ml-4 btn btn-danger btn-fill'><i class='nc-icon nc-simple-remove'></i></button>"
                @endif
        },
    ],

    } );

        $('#table_id tbody').on( 'click', 'button#view', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var url = '{{ route('showConv', ':id') }}';
            url = url.replace(':id', data['id']);
            window.location = url;
        } );

        $('#table_id tbody').on( 'click', 'button#delete', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var confirmmssg = confirm("Sicuro di voler eliminare la convocazione?");
            if (confirmmssg ) {
                DeleteThis(data['id']);
                table.row($(this).parents('tr')).remove().draw();
            }
        } );

    } );

    function DeleteThis( id )
    {

        var url = '{{ route('delConv', ':id') }}';
        url = url.replace(':id', id);

            $.ajax({
                type: "get",
                url: url,
                success: function () {
                    $.notify({
                        icon: "glyphicon glyphicon-warning-sign",
                        message: "Record eliminato correttamente"
                    },{
                        type: 'danger',
                        timer: 3000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });

                },
            });
    }
    </script>
@endpush
