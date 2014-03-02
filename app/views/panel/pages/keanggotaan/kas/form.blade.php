@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Kas</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Anggota' => action('panel.keanggotaan.index'), $anggota->nama => action('panel.keanggotaan.show', $anggota->id_anggota), 'Kas' => action('panel.keanggotaan.kas.index', $anggota->id_anggota)))
    }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.keanggotaan.kas.update', array($anggota->id_anggota, $kas->kd_kas))
        :   Former::open()
            ->route('panel.keanggotaan.kas.store', $anggota->id_anggota)
    }}
    {{ ($method == 'edit') ? Former::populate( $kas ) : false}}
        {{
            ($method == 'edit')
            ?   Former::text('bulan')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->forceValue($kas->bulan->toDateString()) 
            :   Former::text('bulan')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->help('Pilih bulan, kemudian pilih tanggal 1')
        }}
        
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop