@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Anggota</h2>
        </div>
    </div>

    {{ Breadcrumbs::render() }}


    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.kbm.anggota.update', array($anggota->id_anggota))
        :   Former::open()
            ->route('panel.kbm.anggota.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $anggota ) : false}}
            {{ Former::text('nama') }}
            {{ Former::text('nim') }}
            {{ Former::text('angkatan') }}
            {{ Former::text('no_hp') }}
            {{ 
                Former::select('matkul')
                ->label('Mata kuliah')
                ->options(
                    array(
                        'Algoritma dan Pemrograman' => array('value' => 'Algoritma dan Pemrograman'),
                        'Aplikasi IT' => array('value' => 'Aplikasi IT'),
                        'Kalkulus' => array('value' => 'Kalkulus'),
                    )
                )
                ->inlineHelp('Mata kuliah yang ingin dipelajari?')
            }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop