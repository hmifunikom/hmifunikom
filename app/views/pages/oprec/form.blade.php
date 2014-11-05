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
                Former::open()->route('oprec.store')
            }}
                {{ Former::text('nim') }}
                {{ Former::text('nama')->label('Nama lengkap') }}
                {{ Former::text('panggilan')->label('Nama panggilan') }}

                {{
                    Former::stacked_radios('jenis_kelamin')
                    ->radios(
                        array(
                            'Laki-laki' => array('value' => 'Laki-laki'),
                            'Perempuan' => array('value' => 'Perempuan'),
                        )
                    )
                    ->inline()
                }}


                {{ Former::text('tempat_lahir') }}
                {{ Former::text('tanggal_lahir')->inlineHelp('YYYY/MM/DD') }}

                {{
                    Former::select('agama')
                    ->options(
                        array(
                            'Islam' => array('value' => 'Islam'),
                            'Kristen Protestan' => array('value' => 'Kristen Protestan'),
                            'Kristen Katolik' => array('value' => 'Kristen Katolik'),
                            'Budha' => array('value' => 'Budha'),
                            'Hindu' => array('value' => 'Hindu'),
                            'Konghucu' => array('value' => 'Konghucu'),
                        )
                    )
                }}

                {{ Former::text('alamat') }}
                {{ Former::text('alamat_ortu')->label('Alamat orang tua') }}
                {{ Former::text('no_hp') }}
                {{ Former::text('email') }}

                <?php
                    $dataselect = [];
                    for($i = 1; $i <= 19; $i++) {
                        $dataselect["IF-".$i] = array('value' => $i);
                    }
                ?>
                {{
                    Former::select('kelas')
                    ->options(
                        $dataselect
                    )
                }}

                {{ Former::text('angkatan')->label('Tahun masuk') }}
                {{ Former::textarea('tujuan')->rows(5)->columns(20)->inlineHelp('Tujuan mengikuti kegiatan') }}

                <div class="form-group">
                    <label for="alamat" class="control-label col-lg-2 col-sm-4">Pengalaman berorganisasi</label>
                    <div class="col-lg-10 col-sm-8">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Organisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ Former::text('organisasi_tahun[0]')->label(null) }}</td>
                                    <td>{{ Former::text('organisasi_field[0]')->label(null) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Former::text('organisasi_tahun[1]')->label(null) }}</td>
                                    <td>{{ Former::text('organisasi_field[1]')->label(null) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Former::text('organisasi_tahun[2]')->label(null) }}</td>
                                    <td>{{ Former::text('organisasi_field[2]')->label(null) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <span class="help-block">Isi jika ada</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat" class="control-label col-lg-2 col-sm-4">Riwayat penyakit</label>
                    <div class="col-lg-10 col-sm-8">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Penyakit yang diderita</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ Former::text('penyakit_tahun[0]')->label(null) }}</td>
                                    <td>{{ Former::text('penyakit_field[0]')->label(null) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Former::text('penyakit_tahun[1]')->label(null) }}</td>
                                    <td>{{ Former::text('penyakit_field[1]')->label(null) }}</td>
                                </tr>
                                <tr>
                                    <td>{{ Former::text('penyakit_tahun[2]')->label(null) }}</td>
                                    <td>{{ Former::text('penyakit_field[2]')->label(null) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <span class="help-block">Isi jika ada</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recaptcha_challenge_field" class="control-label col-lg-2 col-sm-4">Kode verifikasi</label>

                    <div class="col-lg-10 col-sm-8">
                        {{ Form::captcha() }}

                        @if(isset($errors))
                        <div class="errors text-danger">
                        {{ $errors->first('recaptcha_response_field') }}
                        </div>
                        @endif
                    </div>
                </div>


                {{ Former::actions( Button::primary_submit('Lanjut'), Button::reset('Reset') ) }}
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