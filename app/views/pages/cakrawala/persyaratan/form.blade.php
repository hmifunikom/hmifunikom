@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>{{ ($method == 'edit') ? 'Ganti' : 'Upload' }} Dokumen Persyaratan</h2>
                </div>
            </div>

            {{
                Button::lg_link(URL::route('cakrawala.anggota.index'), '&laquo Kembali')
            }}

            @include('includes.alert')

            {{
                ($method == 'edit')
                ?   Former::open_for_files()
                    ->route('cakrawala.persyaratan.update', array($persyaratan->id_dokumen))
                :   Former::open_for_files()
                    ->route('cakrawala.persyaratan.store')
            }}
            {{ ($method == 'edit') ? Former::populate( $persyaratan ) : false}}
                
                {{ Former::file('dokumen')->accept('application/zip')->inlineHelp('Maksimal 2MB. Format file berupa zip.') }}

                {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
            {{ Former::close() }}
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop