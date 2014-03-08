<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>[TIKET] {{ $acara->nama_acara }} - HMIF Unikom</title>

        <!-- Bootstrap core CSS -->
        <link href="http://event.hmifunikom.org/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="http://event.hmifunikom.org/assets/fonts/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link rel="stylesheet" type="text/css" href="http://event.hmifunikom.org/assets/css/main.min.css" />
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="http://event.hmifunikom.org"><img src="http://event.hmifunikom.org/assets/images/logo.png" />HMIF Unikom</a>
                </div>
            </div>
        </div>
    </body>
    <div class="big-container">
        <div class="container">
            <span class="big-title">Unduh tiket</span>
            <div>Anda baru saja berhasil memesan tiket acara {{ $acara->nama_acara }}. Silahkan tekan tombol di bawah untuk mengunduh tiket. Harap cetak dan bawa ketika melakukan pembayaran.</div>

            <br><br>
            <center><a class="btn btn-primary btn-lg" href="{{URL::route('event.book.download', array($acara->slug, $ticket->ticket))}}" role="button"><span class="fa fa-download"></span> Unduh tiket</a></center>
            <br><br>

            <small>Jika tombol di atas tidak berhasil silahkan copy alamat berikut ke browser. {{URL::route('event.book.download', array($acara->slug, $ticket->ticket))}}</small>
        </div>
    </div>
</html>