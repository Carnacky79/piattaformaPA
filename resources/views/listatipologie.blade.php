@extends('layouts.app', ['activePage' => 'listatipologie', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'Lista Convocazioni per Tipologia'])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row" style="margin-bottom: 20px">
                @if(Auth::user()->ruolo == 'amministratore')
                <div class="col-2">
                    <a href="{{route('creaConv')}}" class="btn btn-success btn-fill">
                    <span class="nc-icon nc-simple-add"></span>&nbsp;Aggiungi Convocazione
                    </a>
                </div>
                @endif
                    <div class="col-2">
                        <select id="tipologia" name="tipologia" class="form-control">

                        </select>
                    </div>
            </div>

            <div class="row">
                <div class="col">
                    <table id='table_id'>

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipologia</th>
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
                            <th>Tipologia</th>
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

        $.ajax({
            url: '{{route('listaTipologie')}}',
            type: 'GET',
            success: function(response){    // response contains json object in it
                var options = '<option value="0">Scegli la tipologia</option>';
                for(var i=0;i<response.length; i++)
                {
                    options += "<option value='"+response[i].id+"'>" + response[i].nome_evento + "</option>";
                }

                $("#tipologia").html(options);
            }
        });

        $('#tipologia').change(function(){
            var url = '{{ route('listaConvTip', ':id') }}';
            url = url.replace(':id', $(this).val());
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response){
                    table.clear();
                    table.rows.add(response);
                    table.draw();
                }
            });
        });

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
        {
            "targets": 1,
            "data": "id_tipo",
            "render": function(data, type, row){
                var tipologie = {!!$Tipologie!!};
                return tipologie[data-1] === undefined ? data : tipologie[data-1]['nome_evento'] ;
            }
        },
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

        $('#table_id tbody').on( 'click', 'tr', function () {
            var data = table.row($(this)).data();
            convocazioni = "fottiti";
            table.clear();
            table.draw();
            console.log(convocazioni);
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
