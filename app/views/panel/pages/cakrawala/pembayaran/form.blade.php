@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} 
                Tim 
                {{ $lomba }}</h2>
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Cakrawala' => action('panel.cakrawala.index'), 'Kompetisi' => action('panel.cakrawala.kompetisi.index'), 'Tim' => action('panel.cakrawala.kompetisi.tim.index', $lomba)))
    }}

    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.cakrawala.kompetisi.tim.update', array($lomba, $tim->id_tim, 'type' => Input::get('type')))
        :   Former::open()
            ->route('panel.cakrawala.kompetisi.tim.store', $lomba)
    }}
    {{ ($method == 'edit') ? Former::populate( $tim ) : false}}

        {{ Former::legend('Identitas Tim') }}  

        {{ Former::text('nama_tim') }}
        
        {{ Former::text('asal')->inlineHelp('Asal sekolah') }}
        {{ Former::text('alamat')->inlineHelp('Alamat sekolah') }}
        
        {{ Former::text('no_telp')->inlineHelp('Nomor telepon yang bisa dihubungi') }}
        {{ Former::text('nama_pembimbing') }}

    
        {{ Former::legend('Login Tim') }}

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