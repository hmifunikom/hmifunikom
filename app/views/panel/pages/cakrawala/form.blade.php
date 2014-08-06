@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Cabang</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{ Breadcrumbs::render() }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.ifgames.update', $cabang->id_cabang)
        :   Former::open()
            ->route('panel.ifgames.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $cabang ) : false}}

        {{ Former::legend('Identitas Cabang') }}

        {{ Former::text('nama_cabang') }}
        {{ Former::number('kuota') }}
        {{ Former::number('biaya')->prepend('Rp') }}

        {{ Former::legend('Jumlah jabatan') }}
        {{ Former::number('manager') }}
        {{ Former::number('official') }}
        {{ Former::number('anggota') }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop