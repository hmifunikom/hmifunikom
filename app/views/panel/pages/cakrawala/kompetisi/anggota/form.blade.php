@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} {{ Input::get('jabatan', 'Anggota') }}</h2>
        </div>
    </div>

    @if($cabang->anggota > 1)
    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), $tim->cabang->nama_cabang => action('panel.ifgames.tim.index', $tim->cabang->id_cabang), 'Tim' => action('panel.ifgames.tim.index', $tim->cabang->id_cabang), $tim->nama_tim => action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim))))
    }}
    @else
    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), $tim->cabang->nama_cabang => action('panel.ifgames.tim.index', $tim->cabang->id_cabang), 'Peserta' => action('panel.ifgames.tim.index', $tim->cabang->id_cabang), $tim->nama_tim => action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim))))
    }}
    @endif


    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open_for_files()
            ->route('panel.ifgames.tim.anggota.update', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota))
        :   Former::open_for_files()
            ->route('panel.ifgames.tim.anggota.store', array($tim->cabang->id_cabang, $tim->id_tim))
    }}
    {{ ($method == 'edit') ? Former::populate( $anggota ) : false}}
        
        {{ Former::text('nama') }}
        {{ Former::text('nim') }}
        {{ Former::text('no_hp') }}
        {{ Former::file('foto_anggota')->accept('image')->inlineHelp('Maksimal 2MB. Foto close up 2x3 cm') }}
        {{ Former::hidden('jabatan')}}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop