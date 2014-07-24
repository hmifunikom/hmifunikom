@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content') 
    <div class="big-container">
        <div class="container">
            <?php
                Helper::FormerConfig('fetch_errors', false);
                Helper::FormerConfig('automatic_label', false);
            ?>
            {{
                Former::vertical_open()
                    ->class('form-signin')
                    ->role('form')
                    ->rules(['username' => 'required', 'password' => 'required'])
                    ->action(route('cakrawala.sessions.store'))
                    ->method('POST')
            }}
                <center>
                    <img src="{{ asset('assets/images/logo.png') }}" >
                    <h2 class="form-signin-heading">Login Peserta Cakrawala</h2>
                </center>

                @include('includes.alert')

                {{
                    Former::text('username')->placeholder('Username')
                }}
                {{
                    Former::password('password')->placeholder('Password')
                }}

                {{ Form::captcha() }}

                @if(isset($errors))
                <div class="errors text-danger">
                {{ $errors->first('username') }}
                {{ $errors->first('password') }}
                {{ $errors->first('recaptcha_response_field') }}
                </div>
                @endif

                {{ Button::lg_primary_submit('Masuk')->block() }}
                
                <a href="{{ URL::route('cakrawala.lomba') }}">Belum mendaftar? Daftar disini.</a>

            {{ Former::close() }}
        </div>
    </div>
@stop