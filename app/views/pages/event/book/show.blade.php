@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.default'))

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron event">
        <div class="container">
            <h2>Event HMIF</h2>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
        </div>
    </div>
    @endif

    <div id="event" class="big-container">
        <div class="container">
            @include('includes.alert')

            {{
                Button::lg_link(URL::route('event.show', $acara->slug), '&laquo Kembali')
            }}

            <div class="ticket">
                <div class="row">
                    <div class="col-md-3 qr-col">
                        <img src="{{ asset('media/qr/'.$ticket->ticket.'.jpg') }}" width="100%" />
                        <div class="center">{{ Helper::code($ticket->kode) }}</div>
                    </div>
                    <div class="col-md-9">
                        <div class="big-title">{{ $acara->nama_acara }}</div>
                        {{ 
                            Typography::horizontal_dl(
                                array(
                                    'Tempat'          => $acara->tempat,
                                    'Tanggal & Waktu' => $acara->tgl->toDateString().' @ '.Helper::implode($acara->waktu, 'waktu'),
                                )
                            )
                        }}

                        {{ 
                            Typography::horizontal_dl(
                                array(
                                    'Nama Peserta' => $ticket->nama_peserta,
                                    'Kategori'     => Lang::get('messages.event.'.$ticket->kategori),
                                    'NIM'          =>  $ticket->nim,
                                )
                            )
                        }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop