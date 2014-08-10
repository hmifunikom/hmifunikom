@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Daftar Lomba</h2>
                </div>
            </div>

            {{
                Button::lg_link(URL::route('cakrawala.pendaftaran'), '&laquo Kembali')
            }}

            <div class="clear"></div>
            <a href="{{ URL::route('cakrawala.sessions.create') }}">Sudah mendaftar? Login disini.</a>

            @include('includes.alert')

            <div class="row cabang">
                <div style="background:#b71524;" class="col-xs-12">
                    <a href="{{ URL::route('cakrawala.create', 'Debat') }}">
                        <span class="big-title">Debat IT</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div style="background:#009B4C;" class="col-xs-12">
                    <a href="{{ URL::route('cakrawala.create', 'ITContest') }}">
                        <span class="big-title">IT Contest</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div style="background:#008CD6;" class="col-xs-12">
                    <a href="{{ URL::route('cakrawala.create', 'LKTI') }}">
                        <span class="big-title">LKTI</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div style="background:#333333;" class="col-xs-12">
                    <a href="{{ URL::route('cakrawala.create', 'TheColorRun') }}">
                        <span class="big-title">The Color Run</span>
                        {{ Helper::fa('chevron-right') }}
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>            
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop