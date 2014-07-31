@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $acara->nama_acara }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.event.waktu.create', $acara->kd_acara), Helper::fa('plus').' Tambah waktu') }}
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('panel.pages.event.tab')

    @include('includes.alert')

    @if($listwaktu->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Waktu', '') }}
        <tbody>
        <?php $i = $listwaktu->getFrom(); ?>
        @foreach($listwaktu as $waktu)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $waktu->waktu }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.event.waktu.destroy', array($acara->kd_acara, $waktu->id_waktu))->class('confirm-delete')->data_confirm('waktu acara') }}
                        {{ Button::primary_link(action('panel.event.waktu.edit', array($acara->kd_acara, $waktu->id_waktu)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $listwaktu->links() }}
    @else
          <div class="big-title center">Tidak ada waktu acara</div>
    @endif

    
@stop