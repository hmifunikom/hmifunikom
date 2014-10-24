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
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="center">Form Pendaftaran Pelatihan Kompetisi</h2>
                </div>
            </div>

            @include('includes.alert')
            
            {{
                Former::open()->route('pelatihan.store')
            }}
                {{ Former::text('nama') }}
                {{ Former::text('nim') }}
                {{ Former::text('tahun_masuk') }}
                {{ Former::text('no_hp') }}
                {{ Former::text('email') }}
                {{ Former::text('alamat') }}
                {{ 
                    Former::stacked_radios('divisi')
                    ->radios(
                        array(
                            'Web Developer' => array('value' => 'Web Developer'), 
                            'Desktop Application' => array('value' => 'Desktop Application'),
                        )
                    )
                    ->inline()
                    ->inlineHelp('Ingin masuk pelatihan divisi?') 
                }}
                {{ 
                    Former::stacked_radios('tingkat')
                    ->radios(
                        array(
                            'Rendah' => array('value' => 'Rendah'),
                            'Sedang' => array('value' => 'Sedang'),
                            'Tinggi' => array('value' => 'Tinggi'),
                        )
                    )
                    ->inline()
                    ->inlineHelp('Tingkat kemahiran saat ini.')
                }}
                {{ Former::textarea('motivasi')->rows(5)->columns(20) }}

                <div class="form-group">
                    <label for="recaptcha_challenge_field" class="control-label col-lg-2 col-sm-4">Kode verifikasi</label>

                    <div class="col-lg-10 col-sm-8">
                        {{ Form::captcha() }}

                        @if(isset($errors))
                        <div class="errors text-danger">
                        {{ $errors->first('recaptcha_response_field') }}
                        </div>
                        @endif
                    </div>
                </div>
                

                {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
            {{ Former::close() }}
        </div>
    </div>
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