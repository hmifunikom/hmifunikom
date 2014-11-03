@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.custom-big'))

@section('title')
Open Recruitment
@stop

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron lkmm">
        <?php
        $sekarang = new DateTime("now");
        $target = new DateTime("2014/11/03 09:00:00");
        ?>
        @if($sekarang < $target)
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
        @endif
    </div>
    @endif

    @if($sekarang < $target)
    <div class="big-container">
        <div class="container">
            <img src="{{ asset('assets/images/oprec-banner.jpg') }}" width="100%" alt="Open Recruitment" />
        </div>
    </div>

    <div class="big-container grey">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    {{
                        Button::primary_lg_link_block(URL::route('oprec.create'), Helper::fa('clipboard').' Daftar Online')
                    }}
                </div>
                <div class="col-md-6">
                    {{
                        Button::success_lg_link_block('http://bit.ly/oprechmif2014', Helper::fa('download').' Download Formulir Pendaftaran')
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

@section('javascript')
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script type="text/javascript">
    $(function(){
        $('.countdown').countdown("2014/11/03 09:00:00", function(event) {
            $(this).find('.hari').text(event.strftime('%D'));
            $(this).find('.jam').text(event.strftime('%H'));
            $(this).find('.menit').text(event.strftime('%M'));
            $(this).find('.detik').text(event.strftime('%S'));
        });
    });
    </script>
@stop