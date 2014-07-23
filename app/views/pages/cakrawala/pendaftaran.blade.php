@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <h2 class="center">Panduan Pendaftaran</h2>
            {{ Alert::info('Pendaftaran sudah berakhir.') }}
            <div class="well well-lg">
                <ol>
                    <li>Setiap peserta atau perwakilan (jika grup), mendaftarkan diri di bit.ly/IFGames2014</li>
                    <li>Setelah mendaftarkan diri, penuhi administrasi ke Hima IF dengan membawa perlengkapan berikut:
                        <ul>
                            <li>Username ketika mendaftar di web</li>
                            <li>Uang administrasi</li>
                            <li>Surat Aktif (seluruh anggota jika grup)</li>
                            <li>Fotocopy KTM (seluruh anggota jika grup)</li>
                        </ul>
                    </li>
                    <li>Jika perlengkapan sudah terpenuhi, maka peserta mengisikan seluruh data anggotanya sesuai dengan surat aktif dan fotocopy KTM yang diberikan ke pihak panitia IF GAMES 2014 di bit.ly/IFGames2014 (berupa Foto, NIM, Nama, dan Nomor HP) Dengan melakukan login terlebih dahulu sesuai dengan username dan password yang telah didaftarkan sebelumnya.</li>
                    <li>Setelah pengisian data anggota sudah lengkap, lalu save dan download kwitansi sebagai bukti.</li>
                    <li>Uang Administrasi :
                        <ol type="a">
                            <li>Futsal ( Rp.200.000,- )</li>
                            <li>Basket 3 on 3 ( Rp.60.000,- )</li>
                            <li>Catur ( Rp.40.000,- )</li>
                            <li>Bulu Tangkis Single ( Rp.50.000,- )</li>
                            <li>Bulu Tangkis Ganda Campuran ( Rp.75.000,- )</li>
                        </ol>
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