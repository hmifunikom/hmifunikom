<html>
<head>
    
    <link href="{{ asset('assets/css/ticket.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="ticket">
        <table border="1" width="100%" cellpadding="10" cellspacing="0">
            <tr>
                <td width="200px">
                    <img src="{{ asset('media/qr/'.$ticket->ticket.'.jpg') }}" width="200px" />
                    <div class="center"><strong>{{ Helper::code($ticket->kode) }}</strong></div>
                </td>
                <td>
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
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>