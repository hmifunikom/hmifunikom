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
                    ->rules(['email' => 'required'])
                    ->action(route('sessions.password.send'))
                    ->method('POST')
            }}

                <center>
                    <img src="{{ asset('assets/images/logo.png') }}" >
                    <h2 class="form-signin-heading">Lupa Password</h2>
                </center>

                @include('includes.alert')

                {{
                    ($errors->first('email'))
                    ? Former::text('email')->placeholder('email')->state('has-error')
                    : Former::text('email')->placeholder('email')
                }}

                @if(isset($errors))
                <div class="errors text-danger">
                {{ $errors->first('username') }}
                {{ $errors->first('password') }}
                </div>
                @endif

                {{ Button::lg_primary_submit('Kirim')->block() }}

            {{ Former::close() }}
        </div>
    </div>
@stop