@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Pembayaran</h2>
                </div>
            </div>

            @include('includes.alert')

            <div class="well well-lg">
                <ol>
                    <li>Silahkan mentransfer biaya pendaftaran (Rp 40.000) ke Rekening <strong>BNI 0268421843 a.n. Melindah.</strong>
                    </li><li>Foto atau scan hasil bukti transfer.
                    </li><li>Login kembali ke situs Cakrawala.
                    <li>Upload foto bukti transfer untuk verifikasi pembayaran.
                    </li>
                </ol>
            </div>

            {{
                Former::open_for_files()
                    ->route('cakrawala.pembayaran.update')
            }}
                
                <div class="form-group">
                    <label for="status" class="control-label col-lg-2 col-sm-4">Status Pembayaran</label>
                    <div class="col-lg-10 col-sm-8">
                        <?php
                            $p = $peserta->pembayaran;
                            switch($p->getPaymentStatus())
                            {
                                case $p::PAYMENT_NULL : 
                                    echo Label::normal('Belum mentransfer');
                                    break;
                                case $p::PAYMENT_WAITING :
                                    echo Label::warning('Menunggu verifikasi');
                                    break;
                                case $p::PAYMENT_VERIFIED :
                                    echo Label::success('Terverifikasi');
                                    break;
                                case $p::PAYMENT_INVALID :
                                    echo Label::danger('Tidak valid');
                                    break;
                            }
                        ?>

                        @if($p->getPaymentStatus() == $p::PAYMENT_VERIFIED)
                        {{ Button::link(action('cakrawala.pembayaran.kuitansi'), 'Download bukti pembayaran') }}
                        @endif
                    </div>
                </div>

                @if($p->getPaymentStatus() != $p::PAYMENT_VERIFIED)
                {{ Former::file('file_bukti_pembayaran')->accept('application/zip, image/*')->inlineHelp('Maksimal 2MB. Format file berupa gambar atau zip.') }}

                {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
                @endif
            {{ Former::close() }}
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop