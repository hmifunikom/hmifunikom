@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} 
                @if($cabang->anggota > 1)
                Tim 
                @else
                Peserta
                @endif
                {{ $cabang->nama_cabang }}</h2>
        </div>
    </div>

    {{ Breadcrumbs::render() }}


    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.ifgames.tim.update', array($cabang->id_cabang, $tim->id_tim))
        :   Former::open()
            ->route('panel.ifgames.tim.store', $cabang->id_cabang)
    }}
    {{ ($method == 'edit') ? Former::populate( $tim ) : false}}

        @if($cabang->anggota > 1)
        {{ Former::legend('Identitas Tim') }}  
        @else
        {{ Former::legend('Identitas Peserta') }}  
        @endif

        @if($cabang->anggota > 1)
        {{ Former::text('nama_tim') }}
        @else
        {{ Former::text('nama_peserta') }}
        @endif

        @if($cabang->anggota > 1)
        {{ Former::legend('Login Tim') }}
        @else
        {{ Former::legend('Login Peserta') }}
        @endif        

        {{ Former::text('username') }}
        {{ Former::password('password') }}
        {{ Former::password('password_confirmation') }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop