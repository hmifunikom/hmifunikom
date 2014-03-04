@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $acara->nama_acara }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.event.div.create', $acara->kd_acara), Helper::fa('plus').' Tambah divisi') }}
        </div>
    </div>

    {{
      Breadcrumb::create(array('Home' => action('panel.index'), 'Acara' => action('panel.event.index'), $acara->nama_acara => action('panel.event.show', $acara->kd_acara), 'Divisi'))
    }}

    @include('panel.pages.event.tab')
    
    @include('includes.alert')

    @if($listdiv->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Divisi', 'Jumlah Anggota', '') }}
        <tbody>
        <?php $i = $listdiv->getFrom(); ?>
        @foreach($listdiv as $div)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $div->nama_div }}</td>
                <td>{{ $div->panitia()->count() }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.event.div.destroy', array($acara->kd_acara, $div->id_div))->class('confirm-delete')->data_confirm('divisi acara')->data_confirm_message('Seluruh anggota panitia di dalamnya akan ikut terhapus!') }}
                        {{ Button::primary_link(action('panel.event.div.edit', array($acara->kd_acara, $div->id_div)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $listdiv->links() }}
    @else
          <div class="big-title center">Tidak ada divisi</div>
    @endif

    
@stop