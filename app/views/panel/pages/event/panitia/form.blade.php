@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Panitia Acara</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">      
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.event.panitia.update', array($acara->kd_acara, $panitia->id_panitia))
        :   Former::open()
            ->route('panel.event.panitia.store', $acara->kd_acara)
    }}
    {{ ($method == 'edit') ? Former::populate( $panitia ) : false}}
        {{ Former::text('nama_panitia') }}
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop