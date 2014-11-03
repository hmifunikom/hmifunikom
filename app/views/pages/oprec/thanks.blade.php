@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.custom'))

@section('title')
Open Recruitment
@stop

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron lkmm">

    </div>
    @endif

    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="center">Formulir<br>Open Recruitment</h2>
                </div>
            </div>
            {{ Alert::success('Terimakasih atas partisipasinya. Silahkan untuk melakukan pembayaran sebesar Rp. 98.000 ke Sekretariat HMIF') }}
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop
