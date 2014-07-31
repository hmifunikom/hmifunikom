@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Anggota</h2>
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open_for_files()
            ->route('panel.cakrawala.kompetisi.tim.anggota.update', array($tim->lomba, $tim->id_tim, $anggota->id_anggota))
        :   Former::open_for_files()
            ->route('panel.cakrawala.kompetisi.tim.anggota.store', array($tim->lomba, $tim->id_tim))
    }}
    {{ ($method == 'edit') ? Former::populate( $anggota ) : false}}
        
        {{ Former::text('nama_anggota') }}
        {{ Former::text('tempat_lahir') }}
        {{
            ($method == 'edit')
            ?   Former::text('tanggal_lahir')->class('form-control datepick')->data_date_format("yyyy-mm-dd")->forceValue($anggota->tanggal_lahir->toDateString())
            :   Former::text('tanggal_lahir')->class('form-control datepick')->data_date_format("yyyy-mm-dd")
        }}
        {{ Former::text('alamat') }}
        {{ Former::text('no_telp') }}
        {{ Former::file('foto_anggota')->accept('image')->inlineHelp('Maksimal 2MB. Foto close up 2x3 cm') }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop