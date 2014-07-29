@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Tim {{ $tim->nama_tim }} <small>{{ $lomba }}</small></h2>
                </div>
            </div>

            @include('includes.alert')

            @include('pages.cakrawala.tab')

            @if($tim->bayar != 1)
                {{ Alert::warning('Silahkan untuk melakukan pembayaran tersebih dahulu ( ) untuk mengaktifkan formulir.') }}
            @else
            <div class="row team-member big">
                <div class="col-xs-12">
                    <div class="col-xs-8">
                        <h3>Persyaratan</h3>
                    </div>
                    <div class="col-xs-4 right">

                        @if(! $persyaratan)
                        {{ Button::primary_link_sm(action('cakrawala.persyaratan.create'), Helper::fa('upload').' Upload Persyaratan') }}
                        @else
                        {{ Button::primary_link_sm(action('cakrawala.persyaratan.edit', array($persyaratan->id_dokumen)), Helper::fa('upload').' Ganti Dokumen Persyaratan') }}
                        @endif
                    </div>
                    
                    <div class="clearfix"></div>
                    @if($persyaratan)
                        <div class="center">
                            <span class="big-title">{{$persyaratan->persyaratan}}</span><br>
                            <span>Size : <strong>{{ Helper::formatBytes(File::size(Helper::pathFile($persyaratan->persyaratan, true))) }}</strong></span>
                            <span>Uploaded : <strong>({{ $persyaratan->updated_at->toDateString() }})</strong></span>
                            <hr>
                        </div>
                        <div class="center">
                            {{ Button::link(action('cakrawala.persyaratan.download', array($persyaratan->id_dokumen)), Helper::fa('download').' Download') }}
                        </div>
                    @else
                        <div class="center">
                            <span class="big-title">Belum mengirimkan dokumen persyaratan</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop