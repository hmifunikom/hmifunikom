@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Peserta The Color Run</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            {{ Button::primary_link(action('panel.cakrawala.tcr.create'), Helper::fa('plus').' Tambah peserta') }}
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    <div class="table-tool row">
        <div class="col-lg-8">
            <a class="btn btn-default" href="{{ action('panel.cakrawala.tcr.xls') }}">{{ Helper::fa('download') }} Unduh List Peserta</a>
            <a class="btn btn-default" href="{{ action('panel.cakrawala.tcr.vcf') }}">{{ Helper::fa('phone') }} Unduh Kontak (VCF)</a>
        </div>
        <div class="col-lg-4">
            {{ 
                Former::open()
                ->route('panel.cakrawala.tcr.index')
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

    @if($listpeserta->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('Kode', 'Nama peserta', 'No. Telp', 'Pembayaran', '') }}
        <tbody>
        <?php $i = $listpeserta->getFrom(); ?>
        @foreach($listpeserta as $peserta)
            <tr>
                <td>{{ Helper::code($peserta->kode, 'TCR-', 3) }}</td>
                <td>{{ $peserta->nama_peserta }}</td>
                <td>{{ $peserta->no_telp }}</td>
                
                <td>
                    @if($peserta->bayar)
                    {{ Helper::fa('check') }} Sudah
                    @else
                    {{ Helper::fa('times') }} Belum
                    @endif
                </td>
                
                <td class="right">
                    {{ Former::inline_open()->route('panel.cakrawala.tcr.destroy', array($peserta->id_peserta))->class('confirm-delete')->data_confirm('peserta lomba') }}
                        {{ Button::primary_link(action('panel.cakrawala.tcr.show', array($peserta->id_peserta)), Helper::fa('paste'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Data peserta")) }}

                        {{ Button::link(action('panel.cakrawala.tcr.edit', array($peserta->id_peserta)), Helper::fa('pencil'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Edit peserta")) }}

                        {{ Button::danger_submit(Helper::fa('trash-o'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Hapus peserta"))}}
                    {{ Former::close() }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $listpeserta->links() }}
    @else
          <div class="big-title center">
            Tidak ada peserta
        </div>
    @endif

    
@stop