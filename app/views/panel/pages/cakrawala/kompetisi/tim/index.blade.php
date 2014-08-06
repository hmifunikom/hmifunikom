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

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    <div class="table-tool row">
        <div class="col-lg-8">
            <a class="btn btn-default" href="{{ action('panel.cakrawala.kompetisi.xls', array($lomba)) }}">{{ Helper::fa('download') }} Unduh List Tim</a>
            <a class="btn btn-default" href="{{ action('panel.cakrawala.kompetisi.zip', array($lomba)) }}">{{ Helper::fa('clipboard') }} Unduh Persyaratan & Karya</a>
            <a class="btn btn-default" href="{{ action('panel.cakrawala.kompetisi.vcf', array($lomba)) }}">{{ Helper::fa('phone') }} Unduh Kontak (VCF)</a>
        </div>
        <div class="col-lg-4">
            {{ 
                Former::open()
                ->route('panel.cakrawala.kompetisi.tim.index', array($lomba))
            }}
            <div class="input-group">
                <input type="text" class="form-control" value="{{ Input::get('s') }}" name="s">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">{{ Helper::fa('search') }}</button>
                </span>
            </div><!-- /input-group -->
            {{
                Former::close()
            }}
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->

    @if($listtim->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Nama tim', 'Anggota', 'Dokumen', 'Karya', 'Pembayaran', '') }}
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

                <td>
                    @if($tim->bayar)
                    {{ Helper::fa('check') }} Sudah
                    @else
                    {{ Helper::fa('times') }} Belum
                    @endif
                </td>
                
                <td class="right">
                    {{ Former::inline_open()->route('panel.cakrawala.kompetisi.tim.destroy', array($lomba, $tim->id_tim))->class('confirm-delete')->data_confirm('tim lomba') }}
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