@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.custom'))

@section('title')
HMIF Unikom
@stop

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
                    ->rules(['email' => 'required', 'password' => 'required', 'password_confirmation' => 'required'])
                    ->action(route('sessions.password.set'))
                    ->method('POST')
            }}

                <center>
                    <img src="{{ asset('assets/images/logo.png') }}" >
                    <h2 class="form-signin-heading">Atur Ulang Password</h2>
                </center>

                @include('includes.alert')

                {{
                    ($errors->first('email'))
                    ? Former::text('email')->placeholder('email')->state('has-error')
                    : Former::text('email')->placeholder('email')
                }}

                {{
                    ($errors->first('password'))
                    ? Former::password('password')->placeholder('password')->state('has-error')
                    : Former::password('password')->placeholder('password')->class('form-control middle')
                }}

                {{
                    ($errors->first('password_confirmation'))
                    ? Former::password('password_confirmation')->placeholder('password_confirmation')->state('has-error')
                    : Former::password('password_confirmation')->placeholder('password_confirmation')
                }}

                <input type="hidden" name="token" value="{{ $token }}">

                {{ Button::lg_primary_submit('Atur Ulang')->block() }}

            {{ Former::close() }}
        </div>
    </div>
@stop