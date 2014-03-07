@extends('layouts.maintenance')

@section('content')
    <div class="big-container no-jumbotron ">
        <div class="container">
            <h2>Ooopsss..!!</h2>
            <h3>Situs sedang dalam perbaikan. Silahkan kembali beberapa saat lagi.</h3>
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop