@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.ifgames'))

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
                    ->action(route('ifgames.sessions.store'))
                    ->method('POST')
            }}
                <center>
                    <img src="{{ asset('assets/images/logo.png') }}" >
                    <h2 class="form-signin-heading">Login Peserta IF Games</h2>
                </center>
                {{
                    ($errors->first('username'))
                    ? Former::text('username')->state('has-error')
                    : Former::text('username')
                }}
                {{
                    ($errors->first('password'))
                    ? Former::password('password')->state('has-error')
                    : Former::password('password')
                }}

                @if(isset($errors))
                <div class="errors text-danger">
                {{ $errors->first('username') }}
                {{ $errors->first('password') }}
                </div>
                @endif

                {{ Button::lg_primary_submit('Masuk')->block() }}

            {{ Former::close() }}
        </div>
    </div>
@stop