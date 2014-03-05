@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Arsip</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.arsip.create'), Helper::fa('plus').' Tambah dokumen') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Arsip'))
    }}

    @include('includes.alert')

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Nama File', 'Jenis', 'Tanggal Upload', '') }}
    <tbody>
    <?php $i = $listdokumen->getFrom(); ?>
    @foreach($listdokumen as $dokumen)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $dokumen->file }}</td>
            <td>{{ $dokumen->jenis }}</td>
            <td>{{ $dokumen->tgl_upload->formatLocalized('%d-%b-%Y') }}</td>
            <td class="right">
                {{ Former::inline_open()->route('panel.arsip.destroy', $dokumen->kd_dokumen)->class('confirm-delete')->data_confirm('dokumen') }}
                    {{ Button::link(action('panel.arsip.show', $dokumen->slug), Helper::fa('download')) }}
                    {{ Button::primary_link(action('panel.arsip.show', $dokumen->kd_dokumen), Helper::fa('pencil')) }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}

    {{ $listdokumen->links() }}
@stop