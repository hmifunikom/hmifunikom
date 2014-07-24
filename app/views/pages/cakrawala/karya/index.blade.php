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
                        <h3>Karya</h3>
                    </div>
                    <div class="col-xs-4 right">
                        @if(! $karya)
                        {{ Button::primary_link_sm(action('cakrawala.karya.create', array()), Helper::fa('upload').' Upload Karya') }}
                        @else
                        {{ Button::primary_link_sm(action('cakrawala.karya.edit', array($tim->karya->id_karya)), Helper::fa('upload').' Ganti Karya') }}
                        @endif
                    </div>
                    
                    <div class="clearfix"></div>
                    @if($karya)
                        <div class="center">
                            <span class="big-title">{{$tim->karya->judul_karya}}</span><br>
                            <span>{{$tim->karya->karya}}</span><br>
                            <span>Size : <strong>{{ Helper::formatBytes(File::size(Helper::pathFile($tim->karya->karya, true))) }}</strong></span>
                            <span>Uploaded : <strong>({{ $tim->karya->updated_at->toDateString() }})</strong></span>
                            <hr>
                        </div>
                        <div class="center">
                            {{ Button::link(action('cakrawala.karya.download', array($tim->karya->id_karya)), Helper::fa('download').' Download') }}
                        </div>

                        <div class="clearfix"></div>

                        @if($lomba=="IT Contest")
                        <div class="col-xs-12">
                            <h3>Video</h3>
                            <?php
                                $options = array(
                                    'minImageWidth' => 640
                                );
                                $info = Embed\Embed::create($tim->karya->link_video_demo, $options);
                            ?>
                            <div class="center">
                                @if($info)
                                {{ $info->code }}
                                @endif
                                <br><a href="{{ $tim->karya->link_video_demo }}">{{ $tim->karya->link_video_demo }}</a>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="center">
                            <span class="big-title">Belum mengirimkan karya</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($tim->bayar == 1)    
    <div class="big-container white bg">
        <div class="container">
            @if($tim->anggota_lengkap() && $tim->karya()->count() && $tim->persyaratan()->count())
            {{
                Button::lg_primary_link_block(URL::route('ifgames.anggota.download'), Helper::fa('download').' Download kuitansi')
            }}
            @else
                @if($tim->anggota_lengkap())
                {{ Alert::warning('Download kuitansi belum aktif. Dokumen persyaratan belum diverifikasi.') }}
                @else
                {{ Alert::warning('Silahkan lengkapi anggota tim dan melengkapi dokumen persyaratan untuk mendownload kuitansi.') }}
                @endif
            @endif
        </div>
    </div>
    @endif
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop