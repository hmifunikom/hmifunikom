@extends('layouts.default')

@section('content')
    <div class="big-container no-jumbotron ">
        <div class="container">
            <h2>Ooopsss..!!</h2>
            <h3>Maaf anda tidak memiliki hak akses untuk halaman ini.</h3>
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop