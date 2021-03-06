@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $acara->nama_acara }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.event.peserta.create', $acara->kd_acara), Helper::fa('plus').' Tambah peserta') }}
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('panel.pages.event.tab')
    
    @include('includes.alert')

    <div class="table-tool row">
        <div class="col-lg-8">
            <div class="btn-group">
                <a class="btn btn-default {{ Helper::active_qs('pay', 1, false) }}" href="{{ action('panel.event.peserta.index', array($acara->kd_acara, 'pay' => 1)) }}">Bayar</a>
                <a class="btn btn-default {{ Helper::active_qs('pay', 0, false) }}" href="{{ action('panel.event.peserta.index', array($acara->kd_acara, 'pay' => 0)) }}">Belum</a>
            </div>

            <div class="btn-group">
                <a class="btn btn-default {{ Helper::active_qs('cat', 'unikom', false) }}" href="{{ action('panel.event.peserta.index', array($acara->kd_acara, 'cat' => 'unikom')) }}">Unikom</a>
                <a class="btn btn-default {{ Helper::active_qs('cat', 'luar', false) }}" href="{{ action('panel.event.peserta.index', array($acara->kd_acara, 'cat' => 'luar')) }}">Umum</a>
            </div>
            <a class="btn btn-default" href="{{ action('panel.event.peserta.xls', array($acara->kd_acara)) }}">{{ Helper::fa('download') }} Unduh XLS</a>
            <a class="btn btn-default" href="{{ action('panel.event.peserta.vcf', array($acara->kd_acara)) }}">{{ Helper::fa('phone') }} Unduh Kontak</a>
        </div>
        <div class="col-lg-4">
            {{ 
                Former::open()
                ->route('panel.event.peserta.index', array($acara->kd_acara))
            }}
            <div class="input-group">
                <input type="text" class="form-control" value="{{ Input::get('s') }}" name="s">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">{{ Helper::fa('search') }}</button>
                </span>
            </div><!-- /input-group -->
            {{
                Former::close()
            }}
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->

    @if($listpeserta->count())
        Menampilkan {{ $listpeserta->getFrom() }} - {{ $listpeserta->getTo() }} dari {{ $listpeserta->getTotal() }}
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('Kode', 'Nama', 'NIM', 'Tgl. Daftar', 'No.Hp', '') }}
        <tbody>
        @foreach($listpeserta as $peserta)
            <tr>
                <td>{{ Helper::code($peserta->kode) }}</td>
                <td>{{ $peserta->nama_peserta }}</td>
                <td>
                    @if($peserta->kategori == 'unikom')
                        {{ $peserta->nim }}
                    @else
                        {{ Lang::get('messages.event.'.$peserta->kategori) }}
                    @endif
                </td>
                <td>{{ $peserta->tgl_daftar->formatLocalized('%d-%b-%Y') }}</td>
                <td>{{ $peserta->no_hp }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.event.peserta.destroy', array($acara->kd_acara, $peserta->id_peserta))->class('confirm-delete')->data_confirm('peserta acara') }}
                        @if($peserta->bayar == 0)
                        {{ Button::warning_link(action('panel.event.peserta.pay', array($acara->kd_acara, $peserta->id_peserta)), Helper::fa('money'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah bayar")) }}
                        @else
                        {{ Button::success_link(action('panel.event.peserta.pay', array($acara->kd_acara, $peserta->id_peserta)), Helper::fa('money'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum bayar")) }}
                        @endif
                        
                        {{ Button::link(action('panel.event.peserta.show', array($acara->kd_acara, $peserta->id_peserta)), Helper::fa('eye')) }}
                        {{ Button::primary_link(action('panel.event.peserta.edit', array($acara->kd_acara, $peserta->id_peserta)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        <?php $query = array_except( Input::query(), Paginator::getPageName() ); ?>
        {{ $listpeserta->appends($query)->links() }}
    @else
          <div class="big-title center">Tidak ada peserta</div>
    @endif

    
@stop