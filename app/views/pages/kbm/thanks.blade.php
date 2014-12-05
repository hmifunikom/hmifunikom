@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.custom'))

@section('title')
HMIF Unikom
@stop

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="center">Pendaftaran KBM</h2>
                </div>
            </div>
            {{ Alert::success('Terimakasih atas partisipasinya.') }}
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop
