<!DOCTYPE html>
<html lang="id">
    <head>
        @include('panel.includes.head')
    </head>
    <body class="hmifpanel">
        @include('panel.includes.header')
        <div class="container body">
            <div class="page-container">
                <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
                <li class="start {{ Helper::active('panel.index', false) }}">
                    <a href="{{action('panel.index')}}">{{Helper::fa('home')}} <span class="title">Dashboard</span></a>
                </li>
                <li class="{{ Helper::active('panel.keanggotaan.index', false) }}">
                    <a href="{{action('panel.keanggotaan.index')}}">{{Helper::fa('users')}} <span class="title">Keanggotaan</span></a>
                </li>
                <li class="{{ Helper::active('panel.event.index', false) }}">
                    <a href="{{action('panel.event.index')}}">{{Helper::fa('calendar')}} <span class="title">Acara</span></a>
                </li>
                <li class="{{ Helper::active('panel.arsip.index', false) }}">
                    <a href="{{action('panel.arsip.index')}}">{{Helper::fa('copy')}} <span class="title">Arsip</span></a>
                </li>
                <li class=" ">
                    <a href="{{action('panel.index')}}">{{Helper::fa('book')}} <span class="title">Perpustakaan</span></a>
                </li>
                <li class=" ">
                    <a href="{{action('panel.index')}}">{{Helper::fa('user')}} <span class="title">User</span></a>
                </li>
                <li class=" ">
                    <a href="{{action('panel.index')}}">{{Helper::fa('bullhorn')}} <span class="title">IF Center</span></a>
                </li>
                <li class="last ">
                    <a href="{{action('panel.index')}}">{{Helper::fa('user')}} <span class="title">User</span></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
                <div class="page-content-wrapper">
                    <div class="page-content">
                        @yield('content')
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>

        @include('panel.includes.footer')
        @include('panel.includes.javascript')
        @yield('script')
    </body>
</html>
