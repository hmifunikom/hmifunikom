@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <h2 class="center">Panduan Pendaftaran</h2>
            {{-- Alert::info('Pendaftaran sudah berakhir.') --}}
            <div class="well well-lg">
                <ol>
                    
                </ol>
            </div>
        </div>
    </div>

    @if(! Auth::cakrawala()->check())
    <div class="big-container grey">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    {{
                        Button::primary_lg_link_block(URL::route('cakrawala.lomba'), Helper::fa('clipboard').' Daftar')
                    }}
                </div>
                <div class="col-md-6">
                    {{
                        Button::success_lg_link_block(URL::route('cakrawala.sessions.create'), Helper::fa('sign-in').' Masuk')
                    }}
                </div>
            </div>
        </div>
    </div>
    @endif

   
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop