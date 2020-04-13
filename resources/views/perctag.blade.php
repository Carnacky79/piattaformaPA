@extends('layouts.app', ['activePage' => 'listatag', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'Lista Tags'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <canvas id="myChart" style="width:100%; height: 600px;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        var ctx = document.getElementById('myChart');
        var firstlabel = "<a href='link'>Label</a>";
        var myChart = new Chart(
            ctx,
            {
                "type":"polarArea",
                "data":
                    {
                        "labels":[
                            firstlabel,"Green","Yellow","Grey","Blue"
                        ],
                        "datasets":[
                            {
                                "data":[11,16,7,3,14],
                                "backgroundColor":[
                                    "rgb(255, 99, 132)",
                                    "rgb(75, 192, 192)",
                                    "rgb(255, 205, 86)",
                                    "rgb(201, 203, 207)",
                                    "rgb(54, 162, 235)"
                                ]
                            }
                        ]
                    },
                "options":{
                    onClick: graphClickEvent
                }
            });

        function graphClickEvent(event, array){
            if(array[0]){
                console.log({!!$data!!});
            }
        }
    </script>
@endpush
