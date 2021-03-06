@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Peserta Acara</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">      
        </div>
    </div>

    {{ Breadcrumbs::render() }}


    @if(($acara->sisa_kuota_unikom() > 0 OR $acara->sisa_kuota_umum() > 0) OR $method == 'edit')
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
                $kategori = array(
                    'unikom' => 'Unikom (sisa '. $acara->sisa_kuota_unikom().')',
                    'luar'   => 'Umum (sisa '. $acara->sisa_kuota_umum() .')',
                )
            ?>
            {{ 
                Former::select('kategori')->options($kategori)
            }}
            {{
                ($method == 'edit')
                ?   Former::text('tgl_daftar')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->forceValue($peserta->tgl_daftar->toDateString()) 
                :   Former::text('tgl_daftar')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->value(Carbon::now()->toDateString())
            }}
            {{ Former::text('nim')->inlineHelp('Kosongkan jika kategori umum') }}
            {{ Former::text('no_hp')}}
            {{ Former::text('email')}}
            {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
        {{ Former::close() }}
    @else
        <div class="big-title center">Maaf, tiket sudah habis.</div>
    @endif
@stop