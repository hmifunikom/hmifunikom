@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $anggota->nama }}</h2>
        </div>

        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.keanggotaan.kas.create', $anggota->id_anggota), Helper::fa('plus').' Tambah Kas') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Anggota' => action('panel.keanggotaan.index'), $anggota->nama))
    }}
    
    @include('panel.pages.keanggotaan.tabanggota', array('anggota' => $anggota))

    @include('includes.alert')

    @if($listkas->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Bulan', '') }}
        <tbody>
        <?php $i = 1; ?>
        @foreach($listkas as $kas)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $kas->bulan->format('M/Y') }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.keanggotaan.kas.destroy', array($anggota->id_anggota, $kas->kd_kas))->class('confirm-delete')->data_confirm('kas') }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}

        {{ $listkas->links() }}
    @else
          <div class="big-title center">Tidak ada kas</div>
    @endif
@stop