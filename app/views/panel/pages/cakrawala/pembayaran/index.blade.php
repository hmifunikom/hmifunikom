@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Pembayaran</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Cakrawala' => action('panel.cakrawala.index'), 'Pembayaran'))
    }}

    @include('includes.alert')

    <div class="table-tool row">
        <div class="col-lg-8">
        </div>
        <div class="col-lg-4">
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->

    @if($pembayaran->count())
        {{ Table::striped_open(array('class' => 'table-hover')) }}
        {{ Table::headers('#', 'Nama', 'Lomba', 'Status', '') }}
        <tbody>
        <?php $i = $pembayaran->getFrom(); ?>
        @foreach($pembayaran as $p)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $p->payment->nama_tim }}</td>

                <td>{{ $p->payment->lomba }}</td>

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
                    @if($p->getPaymentStatus() > $p::PAYMENT_NULL)
                    {{ Button::primary_link(action('panel.cakrawala.pembayaran.show', array($p->id_pembayaran)), Helper::fa('eye'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Lihat bukti transfer")) }}

                    {{ Button::success_link('#', Helper::fa('check'), array('class' => 'js-tooltip confirm-action', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set terverifikasi", 'data-confirm' => 'set terverifikasi', 'data-href' => action('panel.cakrawala.pembayaran.verified', array($p->id_pembayaran)))) }}

                    {{ Button::danger_link('#', Helper::fa('times'), array('class' => 'js-tooltip confirm-action', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set tidak valid", 'data-confirm' => 'set tidak valid', 'data-href' => action('panel.cakrawala.pembayaran.invalid', array($p->id_pembayaran)))) }}
                    @else
                    {{ Button::disabled_primary_link(action('panel.cakrawala.pembayaran.show', array($p->id_pembayaran)), Helper::fa('eye'), array('target' => '_blank', 'class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Lihat bukti transfer")) }}

                    {{ Button::disabled_success_link(action('panel.cakrawala.pembayaran.show', array($p->id_pembayaran)), Helper::fa('check'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set terverifikasi")) }}

                    {{ Button::disabled_danger_link(action('panel.cakrawala.pembayaran.show', array($p->id_pembayaran)), Helper::fa('times'), array('class' => 'js-tooltip', 'data-toggle' => "tooltip", 'data-placement' => "top", 'title' => "Set tidak valid")) }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        {{ Table::close() }}
        {{ $pembayaran->links() }}
    @else
          <div class="big-title center">
            Tidak ada pembayaran
        </div>
    @endif

    
@stop