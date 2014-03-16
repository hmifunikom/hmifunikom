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
                    <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} {{ Input::get('jabatan', 'Anggota') }}</h2>
                </div>
            </div>

            {{
                Button::lg_link(URL::route('ifgames.anggota.index'), '&laquo Kembali')
            }}

            @include('includes.alert')

            {{
                ($method == 'edit')
                ?   Former::open_for_files()
                    ->route('ifgames.anggota.update', array($anggota->id_anggota))
                :   Former::open_for_files()
                    ->route('ifgames.anggota.store')
            }}
            {{ ($method == 'edit') ? Former::populate( $anggota ) : false}}
                
                {{ Former::text('nama') }}
                {{ Former::text('nim') }}
                {{ Former::text('no_hp') }}
                {{ Former::file('foto_anggota')->accept('image')->inlineHelp('Maksimal 2MB. Foto close up 2x3 cm') }}
                {{ Former::hidden('jabatan')}}

                {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
            {{ Former::close() }}
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop