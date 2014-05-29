@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Anggota</h2>
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Pelatihan', 'Anggota'))
    }}


    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.pelatihan.anggota.update', array($anggota->id_anggota))
        :   Former::open()
            ->route('panel.pelatihan.anggota.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $anggota ) : false}}
            {{ Former::text('nama') }}
            {{ Former::text('nim') }}
            {{ Former::text('tahun_masuk') }}
            {{ Former::text('no_hp') }}
            {{ Former::text('email') }}
            {{ Former::text('alamat') }}
            {{ 
                Former::stacked_radios('divisi')
                ->radios(
                    array(
                        'Web Developer' => array('value' => 'Web Developer'), 
                        'Desktop Application' => array('value' => 'Desktop Application'),
                    )
                )
                ->inline()
                ->inlineHelp('Ingin masuk pelatihan divisi?') 
            }}
            {{ 
                Former::stacked_radios('tingkat')
                ->radios(
                    array(
                        'Rendah' => array('value' => 'Rendah'),
                        'Sedang' => array('value' => 'Sedang'),
                        'Tinggi' => array('value' => 'Tinggi'),
                    )
                )
                ->inline()
                ->inlineHelp('Tingkat kemahiran saat ini.')
            }}
            {{ Former::textarea('motivasi')->rows(5)->columns(20) }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop