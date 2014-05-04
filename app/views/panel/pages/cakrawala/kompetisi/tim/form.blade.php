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
            ->route('panel.cakrawala.kompetisi.tim.update', array($lomba, $tim->id_tim))
        :   Former::open()
            ->route('panel.cakrawala.kompetisi.tim.store', $lomba)
    }}
    {{ ($method == 'edit') ? Former::populate( $tim ) : false}}

        {{ Former::legend('Identitas Tim') }}  

        {{ Former::text('nama_tim') }}
        <?php
            $kategori = array(
                'SMA' => 'SMA/SMK Sederajat',
                'Mahasiswa'   => 'Mahasiswa',
            );
        ?>
        @if($lomba != 'LKTI')
        {{ 
            Former::select('kategori')->options($kategori)->label('Kategori')
        }}
        {{ Former::text('asal')->inlineHelp('Asal sekolah atau perguruan tinggi') }}
        {{ Former::text('alamat')->inlineHelp('Alamat sekolah atau perguruan tinggi') }}
        @else
        {{ Former::text('asal')->inlineHelp('Asal sekolah') }}
        {{ Former::text('alamat')->inlineHelp('Alamat sekolah') }}
        @endif
        
        {{ Former::text('nama_pembimbing') }}

        {{ Former::legend('Login Tim') }}

        {{ Former::text('username') }}
        {{ Former::password('password') }}
        {{ Former::password('password_confirmation') }}
        {{ Former::text('email')->inlineHelp('Email aktif untuk registrasi akun') }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop