@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.ifgames'))

@section('content')
    <div class="big-container">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Formulir Pendaftaran</h2>
                </div>
            </div>

            {{
                Button::lg_link(URL::route('ifgames.anggota.index'), '&laquo Kembali')
            }}

            @include('includes.alert')

            {{
                Former::open()
                    ->route('ifgames.store')
            }}
                
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