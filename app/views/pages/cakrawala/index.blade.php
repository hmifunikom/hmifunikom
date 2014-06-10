@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.default'))

@section('content')
    <div id="fullpage">
        @include('pages.cakrawala.section.debat')
        @include('pages.cakrawala.section.itcontest')
        @include('pages.cakrawala.section.lkti')
        @include('pages.cakrawala.section.contact')
    </div>
@stop
