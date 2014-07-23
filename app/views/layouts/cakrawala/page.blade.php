<!DOCTYPE html>
<html lang="id">
    <head>
        @include('includes.cakrawala.page.head')
        @yield('head')
    </head>
    <body>
        @include('includes.cakrawala.page.header')

        @yield('content')
        @yield('tagline')

        @include('includes.footer')
        @include('includes.cakrawala.page.javascript')
        @yield('javascript')
    </body>
</html>