@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ $tim->nama_tim }} <small>{{ $tim->lomba }}</small></h2>
        </div>
    </div>
    
    {{ Breadcrumbs::render() }}

    @include('panel.pages.cakrawala.kompetisi.tab')

    @include('includes.alert')
    
    <div class="row">
        <div class="col-xs-12">
            {{ 
                Typography::horizontal_dl(
                    array(
                        'Nama tim' => $tim->nama_tim,
                        'Kategori' => $tim->kategori,
                        'Asal' => $tim->asal,
                        'Alamat' => $tim->alamat,
                        'No. Telp' => $tim->no_telp,
                        'Nama Pembimbing' => $tim->nama_pembimbing,
                        'Email' => $tim->user->email,
                    )
                )
            }}
        </div>
    </div>
@stop