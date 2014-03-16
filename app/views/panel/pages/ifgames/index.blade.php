@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Cabang</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.ifgames.create'), Helper::fa('plus').' Tambah cabang') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games', 'Cabang'))
    }}

    @include('includes.alert')

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Nama Cabang', 'Kuota', 'Biaya', 'Terdaftar', '') }}
    <tbody>
    <?php $i = $listcabang->getFrom(); ?>
    @foreach($listcabang as $cabang)
        <tr>
            <td>{{ $i++ }}</td>            
            <td>{{ $cabang->nama_cabang }}</td>
            <td>{{ $cabang->kuota }}</td>
            <td>{{ Helper::rp($cabang->biaya) }}</td>
            <td>{{ $cabang->tim->count() }}</td>

            <td class="right">
                {{ Former::inline_open()->route('panel.ifgames.destroy', $cabang->id_cabang)->class('confirm-delete')->data_confirm('cabang') }}
                    {{ Button::primary_link(action('panel.ifgames.tim.show', $cabang->id_cabang), Helper::fa('eye')) }}
                    {{ Button::link(action('panel.ifgames.edit', $cabang->id_cabang), Helper::fa('pencil')) }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}

    {{ $listcabang->links() }}
@stop