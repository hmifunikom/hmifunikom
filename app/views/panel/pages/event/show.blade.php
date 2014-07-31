@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $acara->nama_acara }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{ Breadcrumbs::render() }}
    
    @include('panel.pages.event.tab')

    @include('includes.alert')
    
    <div class="row">
        <div class="col-xs-7">
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
                        'Kuota Unikom' => $acara->kuota_unikom,
                        'Kuota Umum' => $acara->kuota_umum,
                    )
                )
            }}
        </div>
        <div class="col-xs-5">
            <strong>Poster Acara</strong>

            @if($acara->poster)
            <div class="img-container">
                <img src="{{ asset('media/images/'.$acara->poster) }}" alt="{{ $acara->nama_acara }} Poster" class="img-thumbnail"> 

                {{ Former::inline_open()->route('panel.event.poster.destroy', $acara->kd_acara)->class('confirm-delete')->data_confirm('poster acara') }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </div>
            @endif

            {{ Former::vertical_open_for_files()
                ->route('panel.event.poster.store', $acara->kd_acara)
            }}
                {{ Former::file('posterupload')->label(false)->accept('image')->inlineHelp('Maksimal 2MB') }}
                {{ Former::actions( Button::primary_submit(Helper::fa('upload').' Upload') ) }}
            {{ Former::close() }}
        </div>
    </div>

    {{ Button::primary_link(action('panel.event.edit', $acara->kd_acara), Helper::fa('pencil').' Edit acara') }}
@stop