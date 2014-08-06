@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $cabang->nama_cabang }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{ Breadcrumbs::render() }}
    
    @include('panel.pages.ifgames.tab')

    @include('includes.alert')
    
    {{ 
        Typography::horizontal_dl(
            array(
                'Nama Acara' => $cabang->nama_cabang,
                
                'Tempat' => $cabang->tempat,
                'Deskripsi Acara' => Helper::parsedown($cabang->info, true),
                'Program Kerja' => $cabang->pj,
                
                'Tema' => $cabang->tema,
            )
        )
    }}

    {{ Button::primary_link(action('panel.event.edit', $cabang->kd_cabang), Helper::fa('pencil').' Edit cabang') }}
    {{ Former::inline_open()->route('panel.ifgames.destroy', $cabang->id_cabang)->class('confirm-delete')->data_confirm('cabang') }}
        {{ Button::danger_submit(Helper::fa('trash-o'))}}
    {{ Former::close() }}
@stop