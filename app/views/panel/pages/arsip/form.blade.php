@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Dokumen</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Arsip' => action('panel.arsip.index')))
    }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.arsip.update', $dokumen->kd_dokumen)
        :   Former::open()
            ->route('panel.arsip.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $dokumen ) : false}}
        {{ Former::file('file') }}
        {{
            ($method == 'edit')
            ?   Former::text('tgl')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->forceValue($dokumen->tgl->toDateString()) 
            :   Former::text('tgl')->class('form-control datepick')->data_date_format("yyyy-mm-dd") 
        }}
        {{ Former::text('tempat') }}
        {{ Former::textarea('info')->data_provide('markdown')->data_iconlibrary("fa") }}

        {{ Former::text('pj') }}
        
        {{
            ($method == 'edit')
            ?   Former::text('tgl_selesai_LPJ')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->forceValue($dokumen->tgl_selesai_LPJ->toDateString())
            :   NULL
        }}
        {{ Former::text('tema') }}
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop