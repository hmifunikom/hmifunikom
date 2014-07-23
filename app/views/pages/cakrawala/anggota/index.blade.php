@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.cakrawala.page'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Tim {{ $tim->nama_tim }} <small>{{ $lomba }}</small></h2>
                </div>
            </div>

            @include('includes.alert')

            @include('pages.cakrawala.tab')

            @if($tim->bayar != 1)
                {{ Alert::warning('Silahkan untuk melakukan pembayaran tersebih dahulu ( ) untuk mengaktifkan formulir.') }}
            @else
            <div class="row team-member big">
                <div class="col-xs-12">
                    <div class="col-xs-8">
                        <h3>Anggota 
                            @if($tim->sisa_kuota_anggota() ==  3)
                            <small>Dibutuhkan {{ 3 - $listanggota->count() }}</small>
                            @elseif ($tim->sisa_kuota_anggota() > 0)
                            <small>Dibutuhkan {{ 3 - $listanggota->count() }} lagi</small>
                            @endif
                        </h3>
                    </div>
                    <div class="col-xs-4 right">
                        @if($tim->sisa_kuota_anggota() > 0)
                        {{ Button::primary_link_sm(action('cakrawala.anggota.create'), Helper::fa('plus').' Tambah') }}
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    @if($listanggota->count())
                        <?php $i = 1; ?>

                        @foreach($listanggota as $anggota)
                            <div class="col-xs-4 team-member-container">
                                <h4><small>#{{$i}}</small></h4>
                                <div class="team-member-identity">
                                    <img src="{{ asset('media/thumbs/'.$anggota->foto_anggota) }}" width="76" height="114" class="pull-left" />
                                    {{ 
                                        Typography::dl(
                                            array(
                                                'Nama' => $anggota->nama_anggota,
                                                'TTL' => $anggota->tempat_lahir.', '.$anggota->tanggal_lahir->toDateString(),
                                                'Alamat' => $anggota->alamat,
                                                'No. Hp' => $anggota->no_telp,
                                            ),
                                            array('class' => 'pull-right')
                                        )
                                    }}
                                </div>
                                <div class="clearfix"></div>
                                <div class="row team-member-tool">
                                    <div class="col-xs-6 center">
                                        {{ Button::primary_link_block(action('cakrawala.anggota.edit', array($anggota->id_anggota)), Helper::fa('pencil').' Edit') }}
                                    </div>
                                    <div class="col-xs-6 center">
                                        {{ Former::inline_open()->route('cakrawala.anggota.destroy', array($anggota->id_anggota))->class('confirm-delete')->data_confirm('anggota') }}
                                        {{ Button::danger_submit_block(Helper::fa('trash-o'). ' Hapus')}}
                                    {{ Former::close() }}
                                    </div>
                                </div>
                            </div>

                            @if(!($i % 3))
                                <div class="clearfix"></div>
                            @endif
                        <?php $i++; ?>
                        @endforeach
                    @else
                        <div class="center">
                            <span class="big-title">Belum ada anggota</span>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($tim->bayar == 1)    
    <div class="big-container white bg">
        <div class="container">
            @if($tim->anggota_lengkap() && $tim->karya()->count() && $tim->persyaratan()->count())
            {{
                Button::lg_primary_link_block(URL::route('ifgames.anggota.download'), Helper::fa('download').' Download kuitansi')
            }}
            @else
                @if($tim->anggota_lengkap())
                {{ Alert::warning('Download kuitansi belum aktif. Dokumen persyaratan belum diverifikasi.') }}
                @else
                {{ Alert::warning('Silahkan lengkapi anggota tim dan melengkapi dokumen persyaratan untuk mendownload kuitansi.') }}
                @endif
            @endif
        </div>
    </div>
    @endif
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop