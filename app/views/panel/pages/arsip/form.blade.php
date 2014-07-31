@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Dokumen</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{ Breadcrumbs::render() }}


    @include('includes.alert')
    
    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.arsip.update', $dokumen->kd_dokumen)
        :   Former::open()
            ->route('panel.arsip.store')
    }}
    {{ ($method == 'edit') ? Former::populate( $dokumen ) : false}}
        {{ Former::file('file') }}
        
        <?php
            $kategori = array(
                'lpj' => 'surat',
                'luar'   => 'Umum',
            )
        ?>
        {{ 
            Former::select('kategori')->options($kategori)
        }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop