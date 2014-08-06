@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Acara</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.event.create'), Helper::fa('plus').' Tambah acara') }}
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    {{ Table::striped_open(array('class' => 'table-hover')) }}
    {{ Table::headers('#', 'Nama Acara', 'Tanggal', 'Tempat', '') }}
    <tbody>
    <?php $i = $listacara->getFrom(); ?>
    @foreach($listacara as $acara)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $acara->nama_acara }}</td>
            <td>{{ $acara->tgl->formatLocalized('%d-%b-%Y') }}</td>
            <td>{{ $acara->tempat }}</td>
            <td class="right">
                {{ Former::inline_open()->route('panel.event.destroy', $acara->kd_acara)->class('confirm-delete')->data_confirm('acara') }}
                    {{ Button::link(action('event.show', $acara->slug), Helper::fa('eye'), array('target' => '_blank')) }}
                    {{ Button::primary_link(action('panel.event.show', $acara->kd_acara), Helper::fa('pencil')) }}
                    {{ Button::danger_submit(Helper::fa('trash-o'))}}
                {{ Former::close() }}
            </td>
        </tr>
    @endforeach
    </tbody>
    {{ Table::close() }}

    {{ $listacara->links() }}
@stop