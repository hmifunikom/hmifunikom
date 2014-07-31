@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Ganti' : 'Upload' }} Karya</h2>
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open_for_files()
            ->route('panel.cakrawala.kompetisi.tim.karya.update', array($tim->lomba, $tim->id_tim, $karya->id_karya))
        :   Former::open_for_files()
            ->route('panel.cakrawala.kompetisi.tim.karya.store', array($tim->lomba, $tim->id_tim))
    }}
        
        {{ Former::text('judul_karya') }}
        {{ Former::file('file_karya')->accept('application/zip')->inlineHelp('Maksimal 2MB. Format file berupa zip.') }}

        @if($lomba == "IT Contest")
        {{ Former::text('link_video_demo') }}
        @endif

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop