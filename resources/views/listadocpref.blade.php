@extends('layouts.app', ['activePage' => 'listadocpref', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'Lista Documenti Caricati'])

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


                        idInput = 'inputTag' + row['id'];
                        if(row['tags'].length > 0){
                            let tags = '';
                            row['tags'].forEach(function(item, index){
                                    tags += '<button id="delTag" class="btn btn-sm btn-info"><i class="fa fa-close"></i>' + item['tag'] + "</button>" + " ";
                                }
                            );
                            tags += '<button id="addTag" class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i></button>';
                            tags += '<div class="hidden" style="width:100px;" id="formtag"><input id="' + idInput + '" style="display:inline; height:18px; width:80px;" type="text" class="ml-3 form-control" aria-describedby="button-addon2">' +
                                '<button style="display:inline; height:18px;" class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2">Add Tag</button></div>';

                            return tags;

                        }else{
                            return '<button style="display:inline; height:18px;" id="addTag" docid="' + row['id'] + '"  class="btn btn-sm btn-secondary"><i class="fa fa-plus"></i></button>' +
                                '<div class="hidden" style="width:100px;" id="formtag"><input id="' + idInput + '" style="display:inline; height:18px; width:80px;" type="text" class="ml-3 form-control" aria-describedby="button-addon2">' +
                                '<button style="display:inline; height:18px;" class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2">Add Tag</button></div>';
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

        $('#table_id tbody').on( 'click', 'button#addTag', function () {
            var sib = $(this).siblings('div#formtag');
            var data = table.row( $(this).parents('tr') ).data();
            if(sib.hasClass('hidden')) {
                $(this).children('i').removeClass('fa-plus').addClass('fa-minus');
                sib.removeClass('hidden').addClass('show');
                sib.children('#inputTag'+data['id']).autocomplete({
                    serviceUrl: '{{route('listaTag')}}',
                    onSelect: null
                });
            }else {
                if(sib.hasClass('show')){
                    $(this).children('i').removeClass('fa-minus').addClass('fa-plus');
                    sib.removeClass('show').addClass('hidden');
                }
            }
        });

        $('#table_id tbody').on( 'click', 'button#download', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var url = '{{ route('download', ':id') }}';
            url = url.replace(':id', data['nome_file']);
            window.location = url;
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
                table.row($(this).parents('tr')).remove().draw();
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

    function addingTag(id, tag){
        var url = '{{ route('addTag', [':id', ':tag']) }}';
        url = url.replace(':id', id);
        url = url.replace(':tag', tag);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: url,
        });
    }

    </script>
@endpush
