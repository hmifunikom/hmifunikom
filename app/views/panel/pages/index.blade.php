@extends('panel.layouts.default')

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Dashboard</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary(Helper::fa('plus').' Tambah anggota') }}
        </div>
    </div>

{{ Breadcrumbs::render() }}
@stop