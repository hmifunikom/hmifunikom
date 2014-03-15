@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Cabang</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), 'Cabang' => action('panel.ifgames.index')))
    }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.ifgames.update', $cabang->id_cabang)
        :   Former::open()
            ->route('panel.ifgames.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $cabang ) : false}}
        {{ Former::text('nama_cabang') }}
        {{ Former::text('kuota') }}
        {{ Former::text('biaya')->prepend('Rp') }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop