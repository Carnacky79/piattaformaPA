@extends('layouts.app', ['activePage' => 'creaconv', 'title' => 'Piattaforma consultazione contenuti multimediali', 'navName' => 'Aggiungi nuova Convocazione'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <form class="form" method="POST" action="{{ route('addConv') }}">
                        @csrf
                        <div class="card card-login card-hidden">
                            <div class="card-header ">
                                <h3 class="header text-center">{{ __('Aggiungi Convocazione') }}</h3>
                            </div>
                            <div class="card-body ">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nome_utente" class="col-md-6 col-form-label">{{ __('Titolo') }}</label>

                                        <div class="col-md-14">
                                            <input id="titolo_convocazione" type="text" class="form-control @error('titolo_convocazione') is-invalid @enderror" name="titolo_convocazione" value="{{ old('titolo_convocazione') }}" required autofocus>

                                            @error('titolo_convocazione')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-md-6 col-form-label">{{ __('Password') }}</label>

                                            <div class="col-md-14">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password', 'secret') }}" required autocomplete="current-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer ml-auto mr-auto">
                                    <div class="container text-center" >
                                        <button type="submit" class="btn btn-warning btn-wd">{{ __('Login') }}</button>
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

@endpush
