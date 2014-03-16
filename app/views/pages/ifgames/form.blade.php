@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.ifgames'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Form Pendaftaran
                    @if($cabang->anggota > 1)
                    Tim 
                    @else
                    Peserta
                    @endif
                    {{ $cabang->nama_cabang }}</h2>
                </div>
            </div>

            {{
                Button::lg_link(URL::route('ifgames.cabang'), '&laquo Kembali')
            }}

            @include('includes.alert')

            {{
                Former::open()
                    ->route('ifgames.store', $cabang->slug)
            }}
                
                @if($cabang->anggota > 1)
                {{ Former::legend('Identitas Tim') }}  
                @else
                {{ Former::legend('Identitas Peserta') }}  
                @endif

                @if($cabang->anggota > 1)
                {{ Former::text('nama_tim') }}
                @else
                {{ Former::text('nama_peserta') }}
                @endif

                @if($cabang->anggota > 1)
                {{ Former::legend('Login Tim') }}
                @else
                {{ Former::legend('Login Peserta') }}
                @endif        

                {{ Former::text('username') }}
                {{ Former::password('password') }}
                {{ Former::password('password_confirmation') }}

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