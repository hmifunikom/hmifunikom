@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Waktu Acara</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">      
        </div>
    </div>

    {{ Breadcrumbs::render() }}


    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.event.waktu.update', array($acara->kd_acara, $waktu->id_waktu))
        :   Former::open()
            ->route('panel.event.waktu.store', $acara->kd_acara)
    }}
    {{ ($method == 'edit') ? Former::populate( $waktu ) : false}}
        {{ Former::text('waktu') }}
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop