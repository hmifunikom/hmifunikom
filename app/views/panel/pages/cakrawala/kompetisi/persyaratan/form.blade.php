@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Ganti' : 'Upload' }} Dokumen Persyaratan</h2>
        </div>
    </div>

     {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Cakrawala' => action('panel.cakrawala.index'), 'Kompetisi' => action('panel.cakrawala.kompetisi.index'), $lomba => action('panel.cakrawala.kompetisi.tim.index', $lomba), 'Tim' => action('panel.cakrawala.kompetisi.tim.index', $lomba), $tim->nama_tim, 'Persyaratan'))
    }}

    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open_for_files()
            ->route('panel.cakrawala.kompetisi.tim.persyaratan.update', array($tim->lomba, $tim->id_tim, $persyaratan->id_dokumen))
        :   Former::open_for_files()
            ->route('panel.cakrawala.kompetisi.tim.persyaratan.store', array($tim->lomba, $tim->id_tim))
    }}
    {{ ($method == 'edit') ? Former::populate( $persyaratan ) : false}}
        
        {{ Former::file('dokumen')->accept('application/zip')->inlineHelp('Maksimal 2MB. Format file berupa zip.') }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop