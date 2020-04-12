@extends('layouts.app', ['activePage' => 'listadoc', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'Lista Documenti Caricati'])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">
                    <table id='table_id'>

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Tags</th>
                            <th>Azioni</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Tags</th>
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
        var documenti = {!!$Documenti!!};
        //console.log(documenti);

    let table = $('#table_id').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Italian.json"
        },

    data: documenti,
    "columnDefs": [
        {
            "render": function ( data, type, row ) {
                return row['id'];
            },
            "width": "5%",
            "targets": 0
        },
        {
            "render": function ( data, type, row ) {
                return row['nome_file'];
            },
            "targets": 1
        },
        {
            "render": function ( data, type, row ) {
                return row['tipo_file'];
            },
            "width": "10%",
            "targets": 2
        },

        {
            "render": function(data, type, row){


                //console.log(row);
                if(row['tags'].length > 0){
                    let tags = '';
                    row['tags'].forEach(function(item, index){
                        tags += '<button id="delTag" class="btn btn-sm btn-info"><i class="fa fa-close"></i>' + item['tag'] + "</button>" + " ";
                        }
                    );
                    tags += '<button id="addTag" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i></button>';

                    return tags;

                }else{
                    return '<button id="addTag" docid="' + row['id'] + '"  class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i></button>';
                }


            },
            "width": "35%",
            "targets": 3
        },
        {
            "render": function ( data, type, row ) {
                var btnclass = row['preferito'] == 1 ? 'btn-fill' : '';
                return "<button id='download' title='Scarica il Documento' class='btn btn-primary btn-fill'><i class='nc-icon nc-tap-01'></i></button>" +
                    "<button id='addfav' title='Aggiungi ai preferiti' class='ml-4 btn btn-success " + btnclass + "'><i class='nc-icon nc-favourite-28'></i></button>"
                    @if(Auth::user()->ruolo == 'amministratore')
                    +
                    "<button id='delete' title='Elimina il Documento' class='ml-4 btn btn-danger btn-fill'><i class='nc-icon nc-simple-remove'></i></button>"
                    @endif;
            },
            "width": "15%",
            "targets": 4
        },
    ],



    } );

        $('#table_id tbody').on( 'click', 'button#download', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var url = '{{ route('download', ':id') }}';
            url = url.replace(':id', data['nome_file']);
            window.open(url);
        } );

        $('#table_id tbody').on( 'click', 'button#delete', function () {
            var data = table.row( $(this).parents('tr') ).data();
            DeleteThis(data['id']);
            table.row($(this).parents('tr')).remove().draw();
        } );

        $('#table_id tbody').on( 'click', 'button#delTag', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var conf = confirm("Eliminare il tag?");
            if(conf){
                DeleteTag(data['id']);
                $(this).remove();
            }

        } );

        $('#table_id tbody').on( 'click', 'button#addfav', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var msg = '';
            if($(this).hasClass('btn-fill')){
                msg = 'Eliminare il documento dai preferiti?';
            }else{
                msg = 'Aggiungere il documento ai preferiti?';
            }
            var conf = confirm(msg);
            if(conf){
                addFav(data['id']);
                $(this).toggleClass('btn-fill');
            }
        } );
    } );

    function DeleteThis( id )
    {
        var confirmmssg = confirm("Sicuro di voler eliminare il documento?");
        var url = '{{ route('delDoc', ':id') }}';
        url = url.replace(':id', id);
        if (confirmmssg ){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "delete",
                url: url,
            });
        }
    }

    function DeleteTag( id )
    {
        var url = '{{ route('delTag', ':id') }}';
        url = url.replace(':id', id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "delete",
                url: url,
            });

    }

    function addFav( id )
    {
        var url = '{{ route('addDocFav', ':id') }}';
        url = url.replace(':id', id);

        $.ajax({
            type: "get",
            url: url,
        });

    }
    </script>
@endpush
