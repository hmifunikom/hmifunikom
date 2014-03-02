@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Anggota</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        ($method == 'edit')
        ?   Breadcrumb::create(array('Home' => action('panel.index'), 'Keanggotaan' => action('panel.keanggotaan.index'), 'Anggota' => action('panel.keanggotaan.index'), $anggota->nama => action('panel.keanggotaan.show', $anggota->id_anggota)))
        :   Breadcrumb::create(array('Home' => action('panel.index'), 'Keanggotaan' => action('panel.keanggotaan.index')))
    }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.keanggotaan.update', $anggota->id_anggota)
        :   Former::open()
            ->route('panel.keanggotaan.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $anggota ) : false}}
        {{ Former::text('nim') }}
        {{ Former::text('nama') }}
        {{ Former::text('alamat') }}
        {{ Former::text('asal') }}
        {{ 
            Former::select('id_divisi')->fromQuery(Divisi::all(), 'divisi', 'id_divisi')->label('Divisi')
        }}
        
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop