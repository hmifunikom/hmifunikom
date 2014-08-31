@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Pembayaran</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{ Breadcrumbs::render() }}

    @include('includes.alert')

    <div class="table-tool row">
        <div class="col-lg-8">
            <div class="btn-group">
                @if(Input::has('bayar'))
                <a class="btn btn-default" href="{{ action('panel.cakrawala.pembayaran.index') }}">Semua</a>
                @else
                <a class="btn btn-default active }}" href="{{ action('panel.cakrawala.pembayaran.index') }}">Semua</a>
                @endif
                <a class="btn btn-default {{ Helper::active_qs('bayar', 1, false) }}" href="{{ action('panel.cakrawala.pembayaran.index', array('bayar' => 1)) }}">Bayar</a>
                <a class="btn btn-default {{ Helper::active_qs('bayar', 0, false) }}" href="{{ action('panel.cakrawala.pembayaran.index', array('bayar' => 0)) }}">Belum</a>
            </div>
        </div>
        <div class="col-lg-4">
            {{ 
                Former::open()
                ->route('panel.cakrawala.pembayaran.index')
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

    @if($pembayaran->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Nama', 'Lomba', 'Status', '') }}
        <tbody>
        <?php $i = $pembayaran->getFrom(); ?>
        @foreach($pembayaran as $p)
            <tr>
                @if($p->payment instanceof HMIF\Model\Cakrawala\Tim)
                <td>{{ $p->payment->id_tim }}</td>
                <td>{{ $p->payment->nama_tim }}</td>
                <td>{{ $p->payment->lomba }}</td>
                @else
                <td>{{ Helper::code($p->payment->kode, 'TCR-', 3) }}</td>
                <td>{{ $p->payment->nama_peserta }}</td>
                <td>The Color Run</td>
                @endif

                <td>
                <?php
                    switch($p->getPaymentStatus())
                    {
                        case $p::PAYMENT_NULL : 
                            echo Label::normal('Belum mentransfer');
                            break;
                        case $p::PAYMENT_WAITING :
                            echo Label::warning('Menunggu verifikasi');
                            break;
                        case $p::PAYMENT_VERIFIED :
                            echo Label::success('Terverifikasi');
                            break;
                        case $p::PAYMENT_INVALID :
                            echo Label::danger('Tidak valid');
                            break;
                    }
                ?>
                </td>
                
                <td class="right">
                    @if($p->bukti_bayar)
                    {{ Button::primary_link(action('panel.cakrawala.pembayaran.show', array($p->id_pembayaran)), Helper::fa('eye'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Lihat bukti transfer")) }}
                    @else
                    {{ Button::disabled_primary_link(action('panel.cakrawala.pembayaran.show', array($p->id_pembayaran)), Helper::fa('eye'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Lihat bukti transfer")) }}
                    @endif

                    {{ Button::success_link('#', Helper::fa('check'), array('class' => 'js-tooltip confirm-action', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set terverifikasi", 'data-confirm' => 'set terverifikasi', 'data-href' => action('panel.cakrawala.pembayaran.verified', array($p->id_pembayaran)))) }}

                    {{ Button::danger_link('#', Helper::fa('times'), array('class' => 'js-tooltip confirm-action', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set tidak valid", 'data-confirm' => 'set tidak valid', 'data-href' => action('panel.cakrawala.pembayaran.invalid', array($p->id_pembayaran)))) }}
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        <?php $query = array_except( Input::query(), Paginator::getPageName() ); ?>
        {{ $pembayaran->appends($query)->links() }}
    @else
          <div class="big-title center">
            Tidak ada data
        </div>
    @endif

    
@stop