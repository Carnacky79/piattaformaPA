@extends('layouts.app', ['activePage' => 'listadocpref', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'Lista Documenti Caricati'])

@section('content')
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">
                    <table id='table_id' class="stripe cell-border">

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Tipo</th>

                            <th>Azioni</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Tipo</th>

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
        console.log(documenti);

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
                    "targets": 3
                },
            ],



        } );


        $('#table_id tbody').on( 'click', 'button#button-addon2', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var idInput = '#inputTag' + data['id'];
            var inputTag = $(this).siblings(idInput).val();
            var tag = '<button id="delTag" class="btn btn-sm btn-info"><i class="fa fa-close"></i>' + inputTag + "</button>" + " ";
            $(this).parents('div#formtag').siblings('button#addTag').children('i').removeClass('fa-minus').addClass('fa-plus');
            $(this).parents('div#formtag').removeClass('show').addClass('hidden');
            $(this).closest('td').prepend(tag);
            addingTag(data['id'], inputTag);
        } );

        $('#table_id tbody').on( 'click', 'button#download', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var url = '{{ route('download', ':id') }}';
            url = url.replace(':id', data['nome_file']);
            window.location = url;
        } );

        $('#table_id tbody').on( 'click', 'button#delete', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var confirmmssg = confirm("Sicuro di voler eliminare il documento?");
            if (confirmmssg ) {
                DeleteThis(data['id']);
                table.row($(this).parents('tr')).remove().draw();
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
                table.row($(this).parents('tr')).remove().draw();
            }
        } );
    } );

    function DeleteThis( id )
    {
        var url = '{{ route('delDoc', ':id') }}';
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
