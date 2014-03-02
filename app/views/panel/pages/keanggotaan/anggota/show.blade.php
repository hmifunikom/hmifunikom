@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $anggota->nama }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Anggota' => action('panel.keanggotaan.index'), $anggota->nama))
    }}
    
    @include('panel.pages.keanggotaan.tabanggota', array('anggota' => $anggota))

    @include('includes.alert')
    
    {{ 
        Typography::horizontal_dl(
            array(
                'Nama' => $anggota->nama,
                'NIM' => $anggota->nim,
                'Alamat' => $anggota->alamat,
                'Asal' => $anggota->asal,
                'Divisi' => $anggota->divisi->divisi,
            )
        )
    }}

    {{ Button::primary_link(action('panel.keanggotaan.edit', $anggota->id_anggota), Helper::fa('pencil').' Edit anggota') }}
@stop