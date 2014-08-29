<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ asset('assets/css/ticket.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="ticket">
        <table width="100%" cellpadding="10" cellspacing="0">
            <tr>
                <td colspan="2">
                    <table class="noborder">
                        <tr>
                            <td width="100px">
                                <img src="{{ asset('assets/images/logo.png') }}" />
                            </td>
                            <td>
                                <div class="big-title">HMIF UNIKOM</div>
                                <div>Jl. Dipatiukur No.112 Bandung Gedung 4 Lantai 4 Ruang 16 (R.4416)
                                </div>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="big-title">The Color Run</div>

                    {{ 
                        Typography::horizontal_dl(
                            array(
                                'Kode' => $kode,
                                'Nama Peserta' => $peserta->nama_peserta,
                                
                            )
                        )
                    }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ 
                        Typography::horizontal_dl(
                            array(
                                'Pembayaran' => Helper::rp(40000),
                                'Status' => 'Lunas',
                                'Dibuat' => $peserta->pembayaran->updated_at->toCOOKIEString(),
                            )
                        )
                    }}
                </td>
                <td width="80px">
                    <img src="{{ asset('media/qr/'.$kode.'.jpg') }}" width="90" />
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>