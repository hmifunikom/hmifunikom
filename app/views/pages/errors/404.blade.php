@extends('layouts.default')

@section('content')
    <div class="big-container no-jumbotron ">
        <div class="container">
            <h2>Ooopsss..!!</h2>
            <h3>Sepertinya halaman yang anda minta tidak tersedia.</h3>
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop