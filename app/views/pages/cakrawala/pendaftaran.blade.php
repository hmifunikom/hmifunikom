@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <h2 class="center">Panduan Pendaftaran</h2>
            {{-- Alert::info('Pendaftaran sudah berakhir.') --}}
            <div class="well well-lg">
                <ol>
                    <li>Peserta tim mendaftar akun pada situs Cakrawala.</li>
                    <li>Setelah mendaftar akun, peserta akan mendapatkan prosedur pembayaran melalui email yang telah didaftarkan pada saat pembuatan akun.</li>
                    <li>Peserta melakukan pembayaran biaya pendaftaran. <strong>Harap simpan bukti transfer.</strong></li>
                    <li>Setelah melakukan pembayaran, peserta login pada situs Cakrawala untuk mengupload bukti tranfer.</li>
                    <li>Peserta akan mendapatkan pemberitahuan akun telah aktif melalui email setelah verifikasi pembayaran.</li>
                    <li>Setelah aktif, Peserta melengkapi formulir anggota, hasil karya dan persyaratan.</li>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    @if(! Auth::cakrawala()->check())
    <div class="big-container grey">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    {{
                        Button::primary_lg_link_block(URL::route('cakrawala.lomba'), Helper::fa('clipboard').' Daftar')
                    }}
                </div>
                <div class="col-md-6">
                    {{
                        Button::success_lg_link_block(URL::route('cakrawala.sessions.create'), Helper::fa('sign-in').' Masuk')
                    }}
                </div>
            </div>
        </div>
    </div>
    @endif

   
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop