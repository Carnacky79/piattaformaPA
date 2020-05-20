<div class="sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{route('dashboard')}}" class="simple-text">
                {{ __("Piattaforma") }}
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>{{ __("Agenda") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'listaconv') active @endif">
                <a class="nav-link" href="{{route('listaConv')}}">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Lista Convocazioni") }}</p>
                </a>
            </li>



            <li class="nav-item @if($activePage == 'listadoc') active @endif">
                <a class="nav-link" href="{{route('listaDoc')}}">
                    <i class="nc-icon nc-paper-2"></i>
                    <p>{{ __("Lista Documenti") }}</p>
                </a>
            </li>
            @if(Auth::user()->ruolo == 'consigliere')
            <li class="nav-item @if($activePage == 'listadocpref') active @endif">
                <a class="nav-link" href="{{route('listadocPref')}}">
                    <i class="nc-icon nc-favourite-28"></i>
                    <p>{{ __("Lista Documenti Pref") }}</p>
                </a>
            </li>
            @endif
            <li class="nav-item @if($activePage == 'listatipologie') active @endif">
                <a class="nav-link" href="{{route('listaConvTip')}}">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>{{ __("Tipologia Convocazioni") }}</p>
                </a>
            </li>
        <!--<li class="nav-item @if($activePage == 'listatag') active @endif">
                <a class="nav-link" href="{{route('percTag')}}">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    <p>{{ __("Lista Tags") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'icons') active @endif">
                <a class="nav-link" href="{{route('page.index', 'icons')}}">
                    <i class="nc-icon nc-atom"></i>
                    <p>{{ __("Icons") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'maps') active @endif">
                <a class="nav-link" href="{{route('page.index', 'maps')}}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>{{ __("Maps") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'notifications') active @endif">
                <a class="nav-link" href="{{route('page.index', 'notifications')}}">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __("Notifications") }}</p>
                </a>
            </li>-->

        </ul>
    </div>
</div>
