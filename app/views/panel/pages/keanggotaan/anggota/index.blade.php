@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Keanggotaan</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.keanggotaan.create'), Helper::fa('plus').' Tambah anggota') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Keanggotaan'))
    }}

    @include('panel.pages.keanggotaan.tab')

    @include('includes.alert')

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Nama Anggota', 'NIM', 'Divisi', '') }}
    <tbody>
    <?php $i = $listanggota->getFrom(); ?>
    @foreach($listanggota as $anggota)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $anggota->nama }}</td>
            <td>{{ $anggota->nim }}</td>
            <td>{{ $anggota->divisi->first()->divisi }}</td>
            <td class="right">
                {{ Former::inline_open()->route('panel.keanggotaan.destroy', $anggota->id_anggota)->class('confirm-delete')->data_confirm('anggota') }}
                    {{ Button::link(action('panel.keanggotaan.show', $anggota->id_anggota), Helper::fa('eye')) }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}

    {{ $listanggota->links() }}
@stop