@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Peserta Acara</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">      
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Acara' => action('panel.event.index'), $acara->nama_acara => action('panel.event.show', $acara->kd_acara), 'Peserta' => action('panel.event.peserta.show', $acara->kd_acara)))
    }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.event.peserta.update', array($acara->kd_acara, $peserta->id_peserta))
        :   Former::open()
            ->route('panel.event.peserta.store', $acara->kd_acara)
    }}
    {{ ($method == 'edit') ? Former::populate( $peserta ) : false}}
        {{ Former::text('nama_peserta') }}
        {{ Former::text('alamat') }}
        <?php
            $clients = array(
                'unikom' => 'Unikom',
                'luar'   => 'Umum',
            )
        ?>
        {{ 
            Former::select('kategori')->options($clients)
        }}
        {{
            ($method == 'edit')
            ?   Former::text('tgl_daftar')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->forceValue($acara->tgl->toDateString()) 
            :   Former::text('tgl_daftar')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->value(Carbon::now()->toDateString())
        }}
        {{ Former::text('nim')}}
        {{ Former::text('no_hp')}}
        {{ Former::text('email')}}
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop