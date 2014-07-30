@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>{{ ($method == 'edit') ? 'Ganti' : 'Upload' }} Karya</h2>
                </div>
            </div>

            {{
                Button::lg_link(URL::route('cakrawala.anggota.index'), '&laquo Kembali')
            }}

            @include('includes.alert')

            {{
                ($method == 'edit')
                ?   Former::open_for_files()
                    ->route('cakrawala.karya.update', array($tim->lomba, $tim->id_tim, $karya->id_karya))
                :   Former::open_for_files()
                    ->route('cakrawala.karya.store', array($tim->lomba, $tim->id_tim))
            }}
                
                {{ Former::text('judul_karya') }}
                {{ Former::file('file_karya')->accept('application/zip')->inlineHelp('Maksimal 2MB. Format file berupa zip.') }}

                @if($lomba == "IT Contest")
                {{ Former::text('link_video_demo') }}
                @endif

                {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
            {{ Former::close() }}
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop