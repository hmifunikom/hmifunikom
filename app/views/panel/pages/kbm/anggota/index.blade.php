@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Daftar Anggota KBM</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.kbm.anggota.create'), Helper::fa('plus').' Tambah anggota') }}
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    <div class="table-tool row">
        <div class="col-lg-8">
            <a class="btn btn-default" href="{{ action('panel.kbm.anggota.xls') }}">{{ Helper::fa('download') }} Unduh List Peserta</a>
            <a class="btn btn-default" href="{{ action('panel.kbm.anggota.vcf') }}">{{ Helper::fa('phone') }} Unduh Kontak (VCF)</a>
        </div>
        <div class="col-lg-4">
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Nama', 'NIM', 'Angatan', 'No. HP', 'Mata Kuliah', '') }}
    <tbody>
    <?php $i = $listanggota->getFrom(); ?>
    @foreach($listanggota as $anggota)
        <tr>
            <td>{{ $i++ }}</td>            
            <td>{{ $anggota->nama }}</td>
            <td>{{ $anggota->nim }}</td>
            <td>{{ $anggota->angkatan }}</td>
            <td>{{ $anggota->no_hp }}</td>
            <td>{{ $anggota->matkul }}</td>


            <td class="right">
                {{ Former::inline_open()->route('panel.kbm.anggota.destroy', $anggota->id_anggota)->class('confirm-delete')->data_confirm('anggota') }}
                    {{ Button::link(action('panel.kbm.anggota.edit', $anggota->id_anggota), Helper::fa('pencil')) }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}

    {{ $listanggota->links() }}
@stop