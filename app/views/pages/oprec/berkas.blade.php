@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.custom-big'))

@section('title')
Open Recruitment
@stop

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron lkmm">

    </div>
    @endif

    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="center">Formulir<br>Open Recruitment</h2>
                </div>
            </div>

            @include('includes.alert')

            <div class="well well-lg">
                <p>Sebelum mengisi form, diharapkan agar telah mempersiapkan persyaratan dokumen: </p>
                <ol>
                    <li>Foto 3x4 terbaru</li>
                    <li>Fotokopi KTM</li>
                    <li>Surat keterangan aktif</li>
                    <li>Fotokopi sertifikat kulber</li>
                </ol>
                Semua berkas discan/foto dan di satukan dalam file zip dengan maksimal ukuran file 2MB.
            </div>

            {{
                Former::open_for_files()->route('oprec.berkas_store')
            }}
                {{ Former::file('dokumen')->accept('application/zip')->inlineHelp('Maksimal 2MB. Format file berupa zip.') }}

                {{ Former::actions( Button::primary_submit('Submit') ) }}
            {{ Former::close() }}
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop

@section('javascript')
    <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
    <script type="text/javascript">
    $(function(){
        $('.countdown').countdown("2014/11/03 09:00:00", function(event) {
            $(this).find('.hari').text(event.strftime('%D'));
            $(this).find('.jam').text(event.strftime('%H'));
            $(this).find('.menit').text(event.strftime('%M'));
            $(this).find('.detik').text(event.strftime('%S'));
        });
    });
    </script>
@stop