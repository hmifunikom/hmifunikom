@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $acara->nama_acara }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.event.panitia.create', $acara->kd_acara), Helper::fa('plus').' Tambah panitia') }}
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('panel.pages.event.tab')
    
    @include('includes.alert')

    @if($listpanitia->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Panitia', 'Jumlah Anggota', '') }}
        <tbody>
        <?php $i = $listpanitia->getFrom(); ?>
        @foreach($listpanitia as $panitia)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $panitia->nama_panitia }}</td>
                <td>{{ $panitia->panitia()->count() }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.event.panitia.destroy', array($acara->kd_acara, $panitia->id_panitia))->class('confirm-delete')->data_confirm('panitia acara')->data_confirm_message('Seluruh anggota panitia di dalamnya akan ikut terhapus!') }}
                        {{ Button::primary_link(action('panel.event.panitia.edit', array($acara->kd_acara, $panitia->id_panitia)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $listpanitia->links() }}
    @else
          <div class="big-title center">Tidak ada panitia</div>
    @endif

    
@stop