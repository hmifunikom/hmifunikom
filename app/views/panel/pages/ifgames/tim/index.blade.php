@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $cabang->nama_cabang }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.ifgames.tim.create', $cabang->id_cabang), Helper::fa('plus').' Tambah tim') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), $cabang->nama_cabang, 'Tim'))
    }}

    @include('panel.pages.ifgames.tab')

    @include('includes.alert')

    @if($listtim->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Angkatan', 'Kelas', '') }}
        <tbody>
        <?php $i = $listtim->getFrom(); ?>
        @foreach($listtim as $tim)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $tim->angkatan }}</td>
                <td>{{ $tim->kelas }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.ifgames.tim.destroy', array($cabang->id_cabang, $tim->id_tim))->class('confirm-delete')->data_confirm('tim cabang') }}
                        {{ Button::primary_link(action('panel.ifgames.tim.edit', array($cabang->id_cabang, $tim->id_tim)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $listtim->links() }}
    @else
          <div class="big-title center">Tidak ada tim</div>
    @endif

    
@stop