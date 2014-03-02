@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $acara->nama_acara }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Acara' => action('panel.event.index'), $acara->nama_acara))
    }}
    
    @include('panel.pages.event.tab')

    @include('includes.alert')
    
    {{ 
        Typography::horizontal_dl(
            array(
                'Nama Acara' => $acara->nama_acara,
                'Tanggal Acara' => $acara->tgl->formatLocalized('%d-%B-%Y'),
                'Tempat' => $acara->tempat,
                'Deskripsi Acara' => Helper::parsedown($acara->info, true),
                'Program Kerja' => $acara->pj,
                'Tanggal Selesai LPJ' => $acara->tgl_selesai_LPJ->formatLocalized('%d-%B-%Y'),
                'Tema' => $acara->tema,
            )
        )
    }}

    {{ Button::primary_link(action('panel.event.edit', $acara->kd_acara), Helper::fa('pencil').' Edit acara') }}
@stop