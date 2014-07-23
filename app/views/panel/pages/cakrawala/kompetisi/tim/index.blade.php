@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>{{ $lomba }}</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.cakrawala.kompetisi.tim.create', $lomba), Helper::fa('plus').' Tambah tim') }}
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Cakrawala' => action('panel.cakrawala.index'), 'Kompetisi' => action('panel.cakrawala.kompetisi.index'), $lomba, 'Tim'))
    }}

    @include('includes.alert')

    @if($listtim->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Nama tim', 'Anggota', 'Dokumen', 'Karya', '') }}
        <tbody>
        <?php $i = $listtim->getFrom(); ?>
        @foreach($listtim as $tim)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $tim->nama_tim }}</td>
                
                <td>
                    @if($tim->anggota_lengkap())
                    {{ Helper::fa('check') }} Lengkap
                    @else
                    {{ Helper::fa('times') }} Belum
                    @endif
                </td>

                <td>
                    @if($tim->persyaratan()->count())
                    {{ Helper::fa('check') }} Lengkap
                    @else
                    {{ Helper::fa('times') }} Belum
                    @endif
                </td>

                <td>
                    @if($tim->karya()->count())
                    {{ Helper::fa('check') }} Lengkap
                    @else
                    {{ Helper::fa('times') }} Belum
                    @endif
                </td>
                
                <td class="right">
                    {{ Former::inline_open()->route('panel.cakrawala.kompetisi.tim.destroy', array($lomba, $tim->id_tim))->class('confirm-delete')->data_confirm('tim lomba') }}
                        @if($tim->bayar == 0)
                        {{ Button::warning_link(action('panel.cakrawala.kompetisi.tim.pay', array($lomba, $tim->id_tim)), Helper::fa('money'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set sudah bayar")) }}
                        @else
                        {{ Button::success_link(action('panel.cakrawala.kompetisi.tim.pay', array($lomba, $tim->id_tim)), Helper::fa('money'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set belum bayar")) }}
                        @endif
                        {{ Button::primary_link(action('panel.cakrawala.kompetisi.tim.show', array($lomba, $tim->id_tim)), Helper::fa('paste'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Data tim")) }}

                        {{ Button::link(action('panel.cakrawala.kompetisi.tim.edit', array($lomba, $tim->id_tim)), Helper::fa('pencil'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Edit tim")) }}

                        {{ Button::danger_submit(Helper::fa('trash-o'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Hapus tim"))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $listtim->links() }}
    @else
          <div class="big-title center">
            Tidak ada tim
        </div>
    @endif

    
@stop