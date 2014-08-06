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

    <div class="row team-member">
        <div class="col-xs-12">
            <div class="col-xs-8">
                <h3>Persyaratan</h3>
            </div>
            <div class="col-xs-4 right">
                @if(! $persyaratan->count())
                {{ Button::primary_link_sm(action('panel.cakrawala.kompetisi.tim.persyaratan.create', array($tim->lomba, $tim->id_tim)), Helper::fa('upload').' Upload Persyaratan') }}
                @else
                {{ Button::primary_link_sm(action('panel.cakrawala.kompetisi.tim.persyaratan.edit', array($tim->lomba, $tim->id_tim, $persyaratan[0]->id_dokumen)), Helper::fa('upload').' Ganti Dokumen Persyaratan') }}
                @endif
            </div>
            
            <div class="clearfix"></div>
            @if($persyaratan->count())
                <div class="center">
                    <span class="big-title">{{$persyaratan[0]->persyaratan}}</span><br>
                    <span>Size : <strong>{{ Helper::formatBytes(File::size(Helper::pathFile($persyaratan[0]->persyaratan, true))) }}</strong></span>
                    <span>Uploaded : <strong>({{ $persyaratan[0]->updated_at->toDateString() }})</strong></span>
                    <hr>
                </div>
                <div class="center">
                    {{ Button::link(action('panel.cakrawala.kompetisi.tim.persyaratan.download', array($tim->lomba, $tim->id_tim, $persyaratan[0]->id_dokumen)), Helper::fa('download').' Download') }}
                </div>
            @else
                <div class="center">
                    <span class="big-title">Belum mengirimkan dokumen persyaratan</span>
                </div>
            @endif
        </div>
    </div>
@stop