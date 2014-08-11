@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.default'))

@section('content')
    <div id="preloader" class="preloader">
        <img src="{{ asset('assets/images/cakrawala/main.jpg') }}" width="550px" class="logo" />
        <div class="spinner-bounce-circle-container">
            <div class="spinner-bounce-circle">
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <div id="fullpage">
        @include('pages.cakrawala.section.main')
        @include('pages.cakrawala.section.debat')
        @include('pages.cakrawala.section.itcontest')
        @include('pages.cakrawala.section.lkti')
        @include('pages.cakrawala.section.thecolorrun')
        @include('pages.cakrawala.section.contact')
    </div>
@stop
