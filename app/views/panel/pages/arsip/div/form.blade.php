@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Divisi Acara</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">      
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Acara' => action('panel.event.index'), $acara->nama_acara => action('panel.event.show', $acara->kd_acara), 'Divisi' => action('panel.event.div.show', $acara->kd_acara)))
    }}

    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.event.div.update', array($acara->kd_acara, $div->id_div))
        :   Former::open()
            ->route('panel.event.div.store', $acara->kd_acara)
    }}
    {{ ($method == 'edit') ? Former::populate( $div ) : false}}
        {{ Former::text('nama_div') }}
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop