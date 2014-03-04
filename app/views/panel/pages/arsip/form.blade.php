@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Acara</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        ($method == 'edit')
        ?   Breadcrumb::create(array('Home' => action('panel.index'), 'Acara' => action('panel.event.index'), $acara->nama_acara => action('panel.event.show', $acara->kd_acara)))
        :   Breadcrumb::create(array('Home' => action('panel.index'), 'Acara' => action('panel.event.index')))
    }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.event.update', $acara->kd_acara)
        :   Former::open()
            ->route('panel.event.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $acara ) : false}}
        {{ Former::text('nama_acara') }}
        {{
            ($method == 'edit')
            ?   Former::text('tgl')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->forceValue($acara->tgl->toDateString()) 
            :   Former::text('tgl')->class('form-control datepick')->data_date_format("yyyy-mm-dd") 
        }}
        {{ Former::text('tempat') }}
        {{ Former::textarea('info')->data_provide('markdown')->data_iconlibrary("fa") }}

        {{ Former::text('pj') }}
        
        {{
            ($method == 'edit')
            ?   Former::text('tgl_selesai_LPJ')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->forceValue($acara->tgl_selesai_LPJ->toDateString())
            :   NULL
        }}
        {{ Former::text('tema') }}
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop