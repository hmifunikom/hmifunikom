@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ ($method == 'edit') ? 'Edit' : 'Tambah' }} Tim {{ $cabang->nama_cabang }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">      
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'IF Games' => action('panel.ifgames.index'), $cabang->nama_cabang => action('panel.ifgames.tim.index', $cabang->id_cabang), 'Tim' => action('panel.ifgames.tim.index', $cabang->id_cabang)))
    }}


    @include('includes.alert')

    {{
        ($method == 'edit')
        ?   Former::open()
            ->route('panel.ifgames.tim.update', array($cabang->id_cabang, $tim->id_tim))
        :   Former::open()
            ->route('panel.ifgames.tim.store', $cabang->id_cabang)
    }}
    {{ ($method == 'edit') ? Former::populate( $tim ) : false}}
        {{ Former::legend('Identitas Tim') }}  

        <?php 
            for($i = 2006; $i <= date('Y') - 1; $i++)
            {
                $angkatan[$i] = $i;
            }
        ?>
        {{ Former::select('angkatan')->options($angkatan) }}

        <?php 
            for($i = 1; $i <= 17; $i++)
            {
                $kelas[$i] = $i;
            }
        ?>
        {{ Former::select('kelas')->options($kelas) }}

        {{ Former::legend('Login Tim') }}

        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-4">Username</label>
            <div class="col-lg-10 col-sm-8">
                <p class="form-control-static" id="username">-</p>
            </div>
        </div>
        {{ Former::password('password') }}
        {{ Former::password('password_confirmation') }}

        {{ Former::actions( Button::primary_submit('Submit'), Button::reset('Reset') ) }}
    {{ Former::close() }}
@stop