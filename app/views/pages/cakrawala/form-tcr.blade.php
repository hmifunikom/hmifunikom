@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Form Pendaftaran Peserta The Color Run</h2>
                </div>
            </div>

            {{
                Button::lg_link(URL::route('cakrawala.lomba'), '&laquo Kembali')
            }}

            @include('includes.alert')

            {{ Former::open()->route('cakrawala.store', $lomba) }}
                
                {{ Former::legend('Identitas Peserta') }}  

                {{ Former::text('nama_peserta') }}
                {{ Former::text('alamat') }}
                {{ Former::text('no_telp')->inlineHelp('Nomor telepon yang bisa dihubungi') }}
            
                {{ Former::legend('Login Peserta') }}

                {{ Former::text('username')->name('username') }}

                {{ Former::password('password') }}
                {{ Former::password('password_confirmation') }}

                {{ Former::text('email')->name('email')->inlineHelp('Email aktif untuk registrasi akun') }}
                
                {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
                
            {{ Former::close() }}
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop