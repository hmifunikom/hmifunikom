@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Keanggotaan</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.keanggotaan.divisi.create'), Helper::fa('plus').' Tambah divisi') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Keanggotaan'))
    }}

    @include('panel.pages.keanggotaan.tab')

    @include('includes.alert')

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Nama Divisi', '') }}
    <tbody>
    <?php $i = 1; ?>
    @foreach($listdivisi as $divisi)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $divisi->divisi }}</td>
            <td class="right">
                {{ Former::inline_open()->route('panel.keanggotaan.divisi.destroy', $divisi->id_divisi)->class('confirm-delete')->data_confirm('divisi') }}
                    {{ Button::primary_link(action('panel.keanggotaan.divisi.edit', $divisi->id_divisi), Helper::fa('pencil')) }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}
@stop