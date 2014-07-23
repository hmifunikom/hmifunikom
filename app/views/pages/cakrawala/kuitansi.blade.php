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
                    <img src="{{ asset('media/qr/'.$tim->id_tim.$tim->username.$tim->nama_tim.'.jpg') }}" width="200px" />
                    <div class="center"><strong>{{ Helper::code($tim->id_tim) }}</strong></div>
                </td>
                <td>
                    <div class="big-title">{{ $tim->nama_tim }}</div>
                    {{ 
                        Typography::horizontal_dl(
                            array(
                                'Cabang'            => $cabang->nama_cabang,
                                'Akun'              => $tim->username,
                                'Biaya Pendaftaran' => Helper::rp($cabang->biaya),
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