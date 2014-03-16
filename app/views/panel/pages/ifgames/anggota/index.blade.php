@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @if($cabang->anggota > 1)
            <h2>Tim {{ $tim->nama_tim }} <small>{{ $tim->cabang->nama_cabang }}</small></h2>
            @else
            <h2>{{ $tim->nama_tim }} <small>{{ $tim->cabang->nama_cabang }}</small></h2>
            @endif
        </div>
    </div>

    
    @if($cabang->anggota > 1)
    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), $tim->cabang->nama_cabang => action('panel.ifgames.tim.index', $tim->cabang->id_cabang), 'Tim' => action('panel.ifgames.tim.index', $tim->cabang->id_cabang), $tim->nama_tim))
    }}
    @else
    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), $tim->cabang->nama_cabang => action('panel.ifgames.tim.index', $tim->cabang->id_cabang), 'Peserta' => action('panel.ifgames.tim.index', $tim->cabang->id_cabang), $tim->nama_tim))
    }}
    @endif

    @include('includes.alert')

    <div class="row team-member">
        @if($tim->cabang->manager > 0)
        <div class="col-xs-6">
            <div class="col-xs-6">
                <h3>Manager</h3>
            </div>
            <div class="col-xs-6 right">
                @if($tim->sisa_kuota_manager() > 0)
                {{ Button::primary_link_sm(action('panel.ifgames.tim.anggota.create', array($tim->cabang->id_cabang, $tim->id_tim, 'jabatan' => 'manager')), Helper::fa('plus').' Set') }}
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

                    {{ Former::inline_open()->route('panel.ifgames.tim.anggota.destroy', array($manager->cabang->id_cabang, $manager->tim->id_tim, $manager->id_anggota))->class('confirm-delete')->data_confirm('anggota') }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </div>
                <div class="clearfix"></div>
                <div class="row team-member-tool">
                    <div class="col-xs-4 center">
                        @if($manager->ska == 0)
                        {{ Button::warning_link_block(action('panel.ifgames.tim.anggota.ska', array($tim->cabang->id_cabang, $tim->id_tim, $manager->id_anggota)), Helper::fa('file-text').' SKA', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah menyerahkan SKA")) }}
                        @else
                        {{ Button::success_link_block(action('panel.ifgames.tim.anggota.ska', array($tim->cabang->id_cabang, $tim->id_tim, $manager->id_anggota)), Helper::fa('file-text').' SKA', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum menyerahkan SKA")) }}
                        @endif
                    </div>
                    <div class="col-xs-4 center">
                        @if($manager->ktm == 0)
                        {{ Button::warning_link_block(action('panel.ifgames.tim.anggota.ktm', array($tim->cabang->id_cabang, $tim->id_tim, $manager->id_anggota)), Helper::fa('credit-card').' KTM', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah menyerahkan KTM")) }}
                        @else
                        {{ Button::success_link_block(action('panel.ifgames.tim.anggota.ktm', array($tim->cabang->id_cabang, $tim->id_tim, $manager->id_anggota)), Helper::fa('credit-card').' KTM', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum menyerahkan KTM")) }}
                        @endif
                    </div>
                    <div class="col-xs-4 center">
                         {{ Button::primary_link_block(action('panel.ifgames.tim.anggota.edit', array($tim->cabang->id_cabang, $tim->id_tim, $manager->id_anggota)), Helper::fa('pencil').' Edit') }}
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
                {{ Button::primary_link_sm(action('panel.ifgames.tim.anggota.create', array($tim->cabang->id_cabang, $tim->id_tim, 'jabatan' => 'official')), Helper::fa('plus').' Set') }}
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

                    {{ Former::inline_open()->route('panel.ifgames.tim.anggota.destroy', array($official->cabang->id_cabang, $official->tim->id_tim, $official->id_anggota))->class('confirm-delete')->data_confirm('anggota') }}
                        {{ Button::danger_submit(Helper::fa('trash-o'))}}
                    {{ Former::close() }}
                </div>
                <div class="clearfix"></div>
                <div class="row team-member-tool">
                    <div class="col-xs-4 center">
                        @if($official->ska == 0)
                        {{ Button::warning_link_block(action('panel.ifgames.tim.anggota.ska', array($tim->cabang->id_cabang, $tim->id_tim, $official->id_anggota)), Helper::fa('file-text').' SKA', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah menyerahkan SKA")) }}
                        @else
                        {{ Button::success_link_block(action('panel.ifgames.tim.anggota.ska', array($tim->cabang->id_cabang, $tim->id_tim, $official->id_anggota)), Helper::fa('file-text').' SKA', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum menyerahkan SKA")) }}
                        @endif
                    </div>
                    <div class="col-xs-4 center">
                        @if($official->ktm == 0)
                        {{ Button::warning_link_block(action('panel.ifgames.tim.anggota.ktm', array($tim->cabang->id_cabang, $tim->id_tim, $official->id_anggota)), Helper::fa('credit-card').' KTM', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah menyerahkan KTM")) }}
                        @else
                        {{ Button::success_link_block(action('panel.ifgames.tim.anggota.ktm', array($tim->cabang->id_cabang, $tim->id_tim, $official->id_anggota)), Helper::fa('credit-card').' KTM', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum menyerahkan KTM")) }}
                        @endif
                    </div>
                    <div class="col-xs-4 center">
                         {{ Button::primary_link_block(action('panel.ifgames.tim.anggota.edit', array($tim->cabang->id_cabang, $tim->id_tim, $official->id_anggota)), Helper::fa('pencil').' Edit') }}
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

    <div class="row team-member">
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
                {{ Button::primary_link_sm(action('panel.ifgames.tim.anggota.create', array($tim->cabang->id_cabang, $tim->id_tim, 'jabatan' => 'anggota')), Helper::fa('plus').' Tambah') }}
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

                            {{ Former::inline_open()->route('panel.ifgames.tim.anggota.destroy', array($anggota->cabang->id_cabang, $anggota->tim->id_tim, $anggota->id_anggota))->class('confirm-delete')->data_confirm('anggota') }}
                                {{ Button::danger_submit(Helper::fa('trash-o'))}}
                            {{ Former::close() }}
                        </div>
                        <div class="clearfix"></div>
                        <div class="row team-member-tool">
                            <div class="col-xs-4 center">
                                @if($anggota->ska == 0)
                                {{ Button::warning_link_block(action('panel.ifgames.tim.anggota.ska', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota)), Helper::fa('file-text').' SKA', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah menyerahkan SKA")) }}
                                @else
                                {{ Button::success_link_block(action('panel.ifgames.tim.anggota.ska', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota)), Helper::fa('file-text').' SKA', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum menyerahkan SKA")) }}
                                @endif
                            </div>
                            <div class="col-xs-4 center">
                                @if($anggota->ktm == 0)
                                {{ Button::warning_link_block(action('panel.ifgames.tim.anggota.ktm', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota)), Helper::fa('credit-card').' KTM', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah menyerahkan KTM")) }}
                                @else
                                {{ Button::success_link_block(action('panel.ifgames.tim.anggota.ktm', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota)), Helper::fa('credit-card').' KTM', array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum menyerahkan KTM")) }}
                                @endif
                            </div>
                            <div class="col-xs-4 center">
                                 {{ Button::primary_link_block(action('panel.ifgames.tim.anggota.edit', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota)), Helper::fa('pencil').' Edit') }}
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

    
@stop