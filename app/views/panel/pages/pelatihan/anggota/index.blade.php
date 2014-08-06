@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Daftar Anggota Pelatihan</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.pelatihan.anggota.create'), Helper::fa('plus').' Tambah anggota') }}
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Nama', 'NIM', 'Divisi', 'Tingkat', '') }}
    <tbody>
    <?php $i = $listanggota->getFrom(); ?>
    @foreach($listanggota as $anggota)
        <tr>
            <td>{{ $i++ }}</td>            
            <td>{{ $anggota->nama }}</td>
            <td>{{ $anggota->nim }}</td>
            <td>{{ $anggota->divisi }}</td>
            <td>{{ $anggota->tingkat }}</td>

            <td class="right">
                {{ Former::inline_open()->route('panel.pelatihan.anggota.destroy', $anggota->id_anggota)->class('confirm-delete')->data_confirm('anggota') }}
                    {{ Button::primary_link(action('panel.pelatihan.anggota.show', $anggota->id_anggota), Helper::fa('eye')) }}
                    {{ Button::link(action('panel.pelatihan.anggota.edit', $anggota->id_anggota), Helper::fa('pencil')) }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}

    {{ $listanggota->links() }}
@stop