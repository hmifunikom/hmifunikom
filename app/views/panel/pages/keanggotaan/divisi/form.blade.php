@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Divisi</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Keanggotaan' => action('panel.keanggotaan.index'), 'Divisi' => action('panel.keanggotaan.divisi.index')))
    }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.keanggotaan.divisi.update', $divisi->id_divisi)
        :   Former::open()
            ->route('panel.keanggotaan.divisi.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $divisi ) : false}}
        {{ Former::text('divisi') }}
        
        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop