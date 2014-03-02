@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $anggota->nama }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.keanggotaan.hp.create', $anggota->id_anggota), Helper::fa('plus').' Tambah No. Hp') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Anggota' => action('panel.keanggotaan.index'), $anggota->nama))
    }}
    
    @include('panel.pages.keanggotaan.tabanggota', array('anggota' => $anggota))

    @include('includes.alert')

    @if($listhp->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'No. Handphone', '') }}
        <tbody>
        <?php $i = 1; ?>
        @foreach($listhp as $hp)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $hp->no_hp }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.keanggotaan.hp.destroy', array($anggota->id_anggota, $hp->kd_hp))->class('confirm-delete')->data_confirm('hp') }}
                        {{ Button::primary_link(action('panel.keanggotaan.hp.edit', array($anggota->id_anggota, $hp->kd_hp)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
    @else
          <div class="big-title center">Tidak ada no. handphone</div>
    @endif
@stop