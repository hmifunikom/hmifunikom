@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.ifgames'))

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron ifgames form {{ $cabang->slug }}">
        <div class="container">
            
        </div>
    </div>
    @endif

    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    @if($cabang->anggota > 1)
                    <h2>Tim {{ $tim->nama_tim }} <small>{{ $tim->cabang->nama_cabang }}</small></h2>
                    @else
                    <h2>{{ $tim->nama_tim }} <small>{{ $tim->cabang->nama_cabang }}</small></h2>
                    @endif
                </div>
            </div>

            @include('includes.alert')

            @if($tim->bayar == 1)
            <div class="row team-member big">
                @if($tim->cabang->manager > 0)
                <div class="col-xs-6">
                    <div class="col-xs-6">
                        <h3>Manager</h3>
                    </div>
                    <div class="col-xs-6 right">
                        @if($tim->sisa_kuota_manager() > 0)
                        {{ Button::primary_link_sm(action('ifgames.anggota.create', array('jabatan' => 'manager')), Helper::fa('plus').' Set') }}
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    @if($manager)
                    <div class="col-xs-12 team-member-container
                    @if(! $manager->lengkap())
                    blm-lengkap
                    @endif ">
                        @if($manager->lengkap())
                        <h4><small>{{Helper::fa('check')}}</small></h4>
                        @else
                        <h4><small>{{Helper::fa('times')}}</small></h4>
                        @endif
                        <div class="team-member-identity">
                            <img src="{{ asset('media/thumbs/'.$manager->foto) }}" width="76" height="114" />
                            {{ 
                                Typography::dl(
                                    array(
                                        'Nama' => $manager->nama,
                                        'NIM' => $manager->nim,
                                        'No. Hp' => $manager->no_hp,
                                    ),
                                    array('class' => 'pull-right big')
                                )
                            }}
                        </div>
                        <div class="clearfix"></div>
                        <div class="row team-member-tool">
                            <div class="col-xs-6 center">
                                {{ Button::primary_link_block(action('ifgames.anggota.edit', array($manager->id_anggota)), Helper::fa('pencil').' Edit') }}
                            </div>
                            <div class="col-xs-6 center">
                                {{ Former::inline_open()->route('ifgames.anggota.destroy', array($manager->id_anggota))->class('confirm-delete')->data_confirm('anggota') }}
                                    {{ Button::danger_submit_block(Helper::fa('trash-o').' Hapus')}}
                                {{ Former::close() }}
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="center">
                            <span class="big-title">Belum ada manager</span>
                        </div>
                    @endif
                </div>
                @endif
                @if($tim->cabang->official > 0)
                <div class="col-xs-6">
                    <div class="col-xs-6">
                        <h3>Official</h3>
                    </div>
                    <div class="col-xs-6 right">
                        @if($tim->sisa_kuota_official() > 0)
                        {{ Button::primary_link_sm(action('ifgames.anggota.create', array('jabatan' => 'official')), Helper::fa('plus').' Set') }}
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    @if($official)
                    <div class="col-xs-12 team-member-container
                    @if(! $official->lengkap())
                    blm-lengkap
                    @endif ">
                        @if($official->lengkap())
                        <h4><small>{{Helper::fa('check')}}</small></h4>
                        @else
                        <h4><small>{{Helper::fa('times')}}</small></h4>
                        @endif
                        <div class="team-member-identity">
                            <img src="{{ asset('media/thumbs/'.$official->foto) }}" width="76" height="114" />
                            {{ 
                                Typography::dl(
                                    array(
                                        'Nama' => $official->nama,
                                        'NIM' => $official->nim,
                                        'No. Hp' => $official->no_hp,
                                    ),
                                    array('class' => 'pull-right big')
                                )
                            }}
                        </div>
                        <div class="clearfix"></div>
                        <div class="row team-member-tool">
                            <div class="col-xs-6 center">
                                {{ Button::primary_link_block(action('ifgames.anggota.edit', array($official->id_anggota)), Helper::fa('pencil').' Edit') }}
                            </div>
                            <div class="col-xs-6 center">
                                {{ Former::inline_open()->route('ifgames.anggota.destroy', array($official->id_anggota))->class('confirm-delete')->data_confirm('anggota') }}
                                    {{ Button::danger_submit_block(Helper::fa('trash-o').' Hapus')}}
                                {{ Former::close() }}
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="center">
                            <span class="big-title">Belum ada official</span>
                        </div>
                    @endif
                </div>
                @endif
            </div>
            @else
                {{ Alert::warning('Silahkan untuk melakukan pembayaran tersebih dahulu ( '.Helper::rp($cabang->biaya).' ) untuk mengaktifkan formulir anggota.') }}
            @endif
        </div>
    </div>
    @if($tim->bayar == 1)
    <div class="divider-layer" style="background-image: url('/assets/images/ifgames-{{ $cabang->slug }}-divider.jpg');">
        <div class="big-container white bg">
            <div class="container">
                <div class="row team-member big">
                    <div class="col-xs-12">
                        <div class="col-xs-8">
                            <h3>Anggota 
                                @if($tim->sisa_kuota_anggota() ==  $tim->cabang->anggota)
                                <small>Dibutuhkan {{ $tim->cabang->anggota - $listanggota->count() }}</small>
                                @elseif ($tim->sisa_kuota_anggota() > 0)
                                <small>Dibutuhkan {{ $tim->cabang->anggota - $listanggota->count() }} lagi</small>
                                @endif
                            </h3>
                        </div>
                        <div class="col-xs-4 right">
                            @if($tim->sisa_kuota_anggota() > 0)
                            {{ Button::primary_link_sm(action('ifgames.anggota.create', array('jabatan' => 'anggota')), Helper::fa('plus').' Tambah') }}
                            @endif
                        </div>
                        <div class="clearfix"></div>
                        @if($listanggota->count())
                            <?php $i = 1; ?>

                            @foreach($listanggota as $anggota)
                                <div class="col-xs-4 team-member-container 
                                @if(! $anggota->lengkap())
                                blm-lengkap
                                @endif ">
                                    <h4><small>#{{$i}}</small></h4>
                                    <div class="team-member-identity">
                                        <img src="{{ asset('media/thumbs/'.$anggota->foto) }}" width="76" height="114" class="pull-left" />
                                        {{ 
                                            Typography::dl(
                                                array(
                                                    'Nama' => $anggota->nama,
                                                    'NIM' => $anggota->nim,
                                                    'No. Hp' => $anggota->no_hp,
                                                ),
                                                array('class' => 'pull-right')
                                            )
                                        }}
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row team-member-tool">
                                        <div class="col-xs-6 center">
                                            {{ Button::primary_link_block(action('ifgames.anggota.edit', array($anggota->id_anggota)), Helper::fa('pencil').' Edit') }}
                                        </div>
                                        <div class="col-xs-6 center">
                                            {{ Former::inline_open()->route('ifgames.anggota.destroy', array($anggota->id_anggota))->class('confirm-delete')->data_confirm('anggota') }}
                                                {{ Button::danger_submit_block(Helper::fa('trash-o').' Hapus')}}
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
            </div>
        </div> 
    </div>   
    @endif

    <div class="big-container white bg">
        <div class="container">
            @if($tim->anggota_lengkap() && $tim->dokumen_lengkap())
            {{
                Button::lg_primary_link_block(URL::route('ifgames.anggota.download'), Helper::fa('download').' Download kuitansi')
            }}
            @else
            {{ Alert::warning('Silahkan lengkapi anggota tim dan melengkapi dokumen persyaratan untuk mendownload kuitansi.') }}
            @endif
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop