@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Peserta Acara</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">      
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    <div class="peserta">
        <div class="row">
            <div class="col-md-3 qr-col">
                <img src="{{ asset('media/qr/'.$peserta->ticket.'.jpg') }}" width="100%" />
                <div class="center">{{ Helper::code($peserta->kode) }}</div>
            </div>
            <div class="col-md-9">
                <div class="big-title">{{ $acara->nama_acara }}</div>
                {{ 
                    Typography::horizontal_dl(
                        array(
                            'Tempat'          => $acara->tempat,
                            'Tanggal & Waktu' => $acara->tgl->toDateString().' @ '.Helper::implode($acara->waktu, 'waktu'),
                        )
                    )
                }}

                {{ 
                    Typography::horizontal_dl(
                        array(
                            'Nama Peserta'  => $peserta->nama_peserta,
                            'Alamat'        => $peserta->alamat,
                            'Kategori'      => Lang::get('messages.event.'.$peserta->kategori),
                            'NIM'           =>  $peserta->nim.'&nbsp;',
                            'No. Handphone' =>  $peserta->no_hp,
                            'E-Mail'        =>  $peserta->email,
                        )
                    )
                }}

            </div>
        </div>
        <div class="center">
        {{
            Button::primary_link(URL::route('event.book.download', array($acara->slug, $peserta->ticket)), Helper::fa('download').' Download Tiket')
        }}
        </div>
    </div>
@stop