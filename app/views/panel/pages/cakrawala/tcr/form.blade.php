@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Peserta</h2>
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.cakrawala.tcr.update', array($peserta->id_peserta, 'type' => Input::get('type')))
        :   Former::open()
            ->route('panel.cakrawala.tcr.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $peserta ) : false}}

        {{ Former::legend('Identitas Peserta') }}  

        {{ Former::text('nama_peserta') }}
        {{ Former::text('alamat') }}
        {{ Former::text('no_telp')->inlineHelp('Nomor telepon yang bisa dihubungi') }}
    
        {{ Former::legend('Login Peserta') }}

        {{ Former::text('user.username')->name('username') }}

        @if($method == 'edit')
        {{ Former::password('password')->inlineHelp('Kosongkan jika tidak ingin merubah password') }}
        {{ Former::password('password_confirmation')->inlineHelp('Kosongkan jika tidak ingin merubah password') }}
        @else
        {{ Former::password('password') }}
        {{ Former::password('password_confirmation') }}
        @endif

        {{ Former::text('user.email')->name('email')->inlineHelp('Email aktif untuk registrasi akun') }}
        
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop