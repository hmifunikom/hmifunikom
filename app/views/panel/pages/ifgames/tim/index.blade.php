@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $cabang->nama_cabang }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            @if($cabang->anggota > 1)
            {{ Button::primary_link(action('panel.ifgames.tim.create', $cabang->id_cabang), Helper::fa('plus').' Tambah tim') }}
            @else
            {{ Button::primary_link(action('panel.ifgames.tim.create', $cabang->id_cabang), Helper::fa('plus').' Tambah peserta') }}
            @endif
        </div>
    </div>

    @if($cabang->anggota > 1)
    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), $cabang->nama_cabang, 'Tim'))
    }}
    @else
    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), $cabang->nama_cabang, 'Peserta'))
    }}
    @endif

    @include('panel.pages.ifgames.tab')

    @include('includes.alert')

    @if($listtim->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        @if($cabang->anggota > 1)
        {{ Table::headers('#', 'Nama tim', 'Anggota', 'Dokumen', '') }}
        @else
        {{ Table::headers('#', 'Nama peserta', 'Anggota', 'Dokumen', '') }}
        @endif
        <tbody>
        <?php $i = $listtim->getFrom(); ?>
        @foreach($listtim as $tim)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $tim->nama_tim }}</td>
                
                <td>
                    @if($tim->anggota_lengkap())
                    {{ Helper::fa('check') }} Lengkap
                    @else
                    {{ Helper::fa('times') }} Belum
                    @endif
                </td>

                <td>
                    @if($tim->dokumen_lengkap())
                    {{ Helper::fa('check') }} Lengkap
                    @else
                    {{ Helper::fa('times') }} Belum
                    @endif
                </td>
                
                <td class="right">
                    {{ Former::inline_open()->route('panel.ifgames.tim.destroy', array($cabang->id_cabang, $tim->id_tim))->class('confirm-delete')->data_confirm('tim cabang') }}
                        @if($tim->bayar == 0)
                        {{ Button::warning_link(action('panel.ifgames.tim.pay', array($cabang->id_cabang, $tim->id_tim)), Helper::fa('money'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah bayar")) }}
                        @else
                        {{ Button::success_link(action('panel.ifgames.tim.pay', array($cabang->id_cabang, $tim->id_tim)), Helper::fa('money'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum bayar")) }}
                        @endif
                        {{ Button::primary_link(action('panel.ifgames.tim.anggota.index', array($cabang->id_cabang, $tim->id_tim)), Helper::fa('group')) }}
                        {{ Button::link(action('panel.ifgames.tim.edit', array($cabang->id_cabang, $tim->id_tim)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $listtim->links() }}
    @else
          <div class="big-title center">
            @if($cabang->anggota > 1)
            Tidak ada tim
            @else
            Tidak ada peserta
            @endif
        </div>
    @endif

    
@stop