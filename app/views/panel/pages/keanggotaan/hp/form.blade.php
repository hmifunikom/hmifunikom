@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} No. HP</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Anggota' => action('panel.keanggotaan.index'), $anggota->nama => action('panel.keanggotaan.show', $anggota->id_anggota), 'No. Handphone' => action('panel.keanggotaan.hp.index', $anggota->id_anggota)))
    }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.keanggotaan.hp.update', array($anggota->id_anggota, $hp->kd_hp))
        :   Former::open()
            ->route('panel.keanggotaan.hp.store', $anggota->id_anggota)
    }}
    {{ ($method == 'edit') ? Former::populate( $hp ) : false}}
        {{ Former::text('no_hp') }}
        
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop