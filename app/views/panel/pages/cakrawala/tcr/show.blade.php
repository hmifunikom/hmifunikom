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
                        'Nama Peserta' => $peserta->nama_peserta,
                        'Alamat' => $peserta->alamat,
                        'No. Telp' => $peserta->no_telp,
                        'Email' => $peserta->user->email,
                    )
                )
            }}
        </div>
    </div>
@stop