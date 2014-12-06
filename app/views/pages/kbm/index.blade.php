@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.custom'))

@section('title')
HMIF Unikom
@stop

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="center">Form Pendaftaran KBM</h2>
                </div>
            </div>

            @include('includes.alert')
            
            {{
                Former::open()->route('kbm.store')
            }}
                {{ Former::text('nama') }}
                {{ Former::text('nim') }}
                {{ Former::text('angkatan') }}
                {{ Former::text('no_hp') }}
                {{ 
                    Former::select('matkul')
                    ->label('Mata kuliah')
                    ->options(
                        array(
                            'Algoritma dan Pemrograman' => array('value' => 'Algoritma dan Pemrograman'),
                            'Aplikasi IT' => array('value' => 'Aplikasi IT'),
                            'Kalkulus' => array('value' => 'Kalkulus'),
                        )
                    )
                    ->inlineHelp('Mata kuliah yang ingin dipelajari?')
                }}

                <div class="form-group">
                    <label for="recaptcha_challenge_field" class="control-label col-lg-2 col-sm-4">Kode verifikasi</label>

                    <div class="col-lg-10 col-sm-8">
                        {{ ReCaptcha::getScript(); }}
                        {{ ReCaptcha::getWidget(); }}
                        {{--{{ Form::captcha() }}--}}

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
