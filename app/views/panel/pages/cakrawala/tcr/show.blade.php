@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ $peserta->nama_peserta }}</h2>
        </div>
    </div>
    
    {{ Breadcrumbs::render() }}

    @include('includes.alert')
    
    <div class="row">
        <div class="col-xs-12">
            {{ 
                Typography::horizontal_dl(
                    array(
                        'Kode' => Helper::code($peserta->kode, 'TCR-', 3),
                        'Nama Peserta' => $peserta->nama_peserta,
                        'Alamat' => $peserta->alamat,
                        'No. Telp' => $peserta->no_telp,
                        'Email' => $peserta->user->email,
                    )
                )
            }}
            <div class="center">
            {{
                Button::primary_link(URL::route('panel.cakrawala.pembayaran.kuitansi', array($peserta->id_peserta)), Helper::fa('download').' Download Kuitansi')
            }}
            </div>
        </div>
    </div>
@stop