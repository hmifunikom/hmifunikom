<!DOCTYPE html>
<html lang="id">
    <head>
        @include('includes.head')
        @yield('head')
    </head>
    <body>
        @include('includes.header-custom-big')

        @yield('content')
        @yield('tagline')

        @include('includes.footer')
        @include('includes.javascript')
        @yield('javascript')
    </body>
</html>
