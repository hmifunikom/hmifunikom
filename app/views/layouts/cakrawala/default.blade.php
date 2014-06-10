<!DOCTYPE html>
<html lang="id">
    <head>
        @include('includes.cakrawala.head')
        @yield('head')
    </head>
    <body>
        @include('includes.cakrawala.header')

        @yield('content')

        @include('includes.cakrawala.javascript')
        @yield('javascript')
    </body>
</html>
