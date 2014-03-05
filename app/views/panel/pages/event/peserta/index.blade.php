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

    {{
      Breadcrumb::create(array('Home' => action('panel.index'), 'Acara' => action('panel.event.index'), $acara->nama_acara => action('panel.event.show', $acara->kd_acara), 'Peserta'))
    }}

    @include('panel.pages.event.tab')
    
    @include('includes.alert')

    {{ $acara->sisa_kuota_unikom() }}
                {{ $acara->sisa_kuota_umum() }}

    @if($listpeserta->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('Kode', 'Nama', 'NIM', 'Tgl. Daftar', 'No.Hp', '') }}
        <tbody>
        @foreach($listpeserta as $peserta)
            <tr>
                <td>{{ Helper::code($peserta->kode) }}</td>
                <td>{{ $peserta->nama_peserta }}</td>
                <td>{{ Lang::get('messages.event.'.$peserta->kategori) }}</td>
                <td>{{ $peserta->tgl_daftar->formatLocalized('%d-%b-%Y') }}</td>
                <td>{{ $peserta->no_hp }}</td>
                <td class="right">
                    {{ Former::inline_open()->route('panel.event.peserta.destroy', array($acara->kd_acara, $peserta->id_peserta))->class('confirm-delete')->data_confirm('peserta acara') }}
                        {{ Button::link(action('panel.event.peserta.show', array($acara->kd_acara, $peserta->id_peserta)), Helper::fa('eye')) }}
                        {{ Button::primary_link(action('panel.event.peserta.edit', array($acara->kd_acara, $peserta->id_peserta)), Helper::fa('pencil')) }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $listpeserta->links() }}
    @else
          <div class="big-title center">Tidak ada peserta</div>
    @endif

    
@stop