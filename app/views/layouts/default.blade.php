<!DOCTYPE html>
<html lang="id">
    <head>
        @include('includes.head')
    </head>

    <body>
        @include('includes.header')

        @yield('content')
        @yield('tagline')

        @include('includes.footer')
        @include('includes.javascript')
    </body>
</html>
