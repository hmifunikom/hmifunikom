@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ $tim->nama_tim }} <small>{{ $tim->lomba }}</small></h2>
        </div>
    </div>
    
    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Cakrawala' => action('panel.cakrawala.index'), 'Kompetisi' => action('panel.cakrawala.kompetisi.index'), $lomba => action('panel.cakrawala.kompetisi.tim.index', $lomba), 'Tim' => action('panel.cakrawala.kompetisi.tim.index', $lomba), $tim->nama_tim, 'Karya'))
    }}

    @include('panel.pages.cakrawala.kompetisi.tab')

    @include('includes.alert')

    <div class="row team-member">
        <div class="col-xs-12">
            <div class="col-xs-8">
                <h3>Karya</h3>
            </div>
            <div class="col-xs-4 right">
                @if(! $karya->count())
                {{ Button::primary_link_sm(action('panel.cakrawala.kompetisi.tim.karya.create', array($tim->lomba, $tim->id_tim)), Helper::fa('upload').' Upload Karya') }}
                @else
                {{ Button::primary_link_sm(action('panel.cakrawala.kompetisi.tim.karya.edit', array($tim->lomba, $tim->id_tim, $tim->karya->id_karya)), Helper::fa('upload').' Ganti Karya') }}
                @endif
            </div>
            
            <div class="clearfix"></div>
            @if($karya->count())
                <div class="center">
                    <span class="big-title">{{$tim->karya->judul_karya}}</span><br>
                    <span>{{$tim->karya->karya}}</span><br>
                    <span>Size : <strong>{{ Helper::formatBytes(File::size(Helper::pathFile($tim->karya->karya, true))) }}</strong></span>
                    <span>Uploaded : <strong>({{ $tim->karya->updated_at->toDateString() }})</strong></span>
                    <hr>
                </div>
                <div class="center">
                    {{ Button::link(action('panel.cakrawala.kompetisi.tim.karya.download', array($tim->lomba, $tim->id_tim, $tim->karya->id_karya)), Helper::fa('download').' Download') }}
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
                        {{ $info->code }}
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
@stop