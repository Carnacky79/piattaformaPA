@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'HomePage'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = {!!$Events!!};
            var url = '{{ route('showConv', ':id') }}';

            events = events.map(function(val){
                url = url.replace(':id', val.id);
                return {
                    title: val.titolo,
                    start: val.data_inizio,
                    end: val.data_fine,
                    url: url
                }
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
                defaultView: 'dayGridMonth',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: events
            });

            calendar.render();
            calendar.setOption('locale', 'it');
        });




    </script>
@endpush
