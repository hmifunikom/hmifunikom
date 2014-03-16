<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="{{ asset('favicon.ico?v1.0') }}">

@if(isset($pagetitle))
<title>{{ $pagetitle }} - HMIF Unikom</title>
@else
<title>HMIF Unikom</title>
@endif

<!-- Bootstrap core CSS -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/fonts/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/fullcalendar.css') }}" rel="stylesheet">

@if(App::environment('production'))
<link href='http://fonts.googleapis.com/css?family=Bitter:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
@endif

<link rel="stylesheet" href="{{ asset('assets/css/main.min.css?v1.2') }}" />

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->