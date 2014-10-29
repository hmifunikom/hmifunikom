@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.custom-big'))

@section('title')
LKMM HMIF Unikom
@stop

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron lkmm">
        <div class="container">
            <div class="row countdown">
                <div class="col-xs-3 text-center">
                    <h2 class="center hari">00</h2>
                    <span class="center">Hari</span>
                </div>
                <div class="col-xs-3 text-center">
                    <h2 class="center jam">00</h2>
                    <span class="center">Jam</span>
                </div>
                <div class="col-xs-3 text-center">
                    <h2 class="center menit">00</h2>
                    <span class="center">Menit</span>
                </div>
                <div class="col-xs-3 text-center">
                    <h2 class="center detik">00</h2>
                    <span class="center">Detik</span>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop

@section('javascript')
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script type="text/javascript">
    $(function(){
        $('.countdown').countdown("2014/11/03", function(event) {
            $(this).find('.hari').text(event.strftime('%D'));
            $(this).find('.jam').text(event.strftime('%H'));
            $(this).find('.menit').text(event.strftime('%M'));
            $(this).find('.detik').text(event.strftime('%S'));
        });
    });
    </script>
@stop