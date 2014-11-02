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

<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

<!-- Bootstrap core CSS -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap.full.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap-markdown.min.css') }}" rel="stylesheet">

@if(App::environment('production'))
<link href="//cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//cdn.jsdelivr.net/fullcalendar/1.6.4/fullcalendar.css" rel="stylesheet">
@else
<link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet">
<link href="{{ asset('assets/fonts/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/fullcalendar.css') }}" rel="stylesheet">
@endif
<link href='http://fonts.googleapis.com/css?family=Bitter:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="{{ asset(Helper::version('assets/css/main.min.css')) }}" />
<link rel="stylesheet" href="{{ asset(Helper::version('assets/css/panel.min.css')) }}" />

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv-printshiv.min.js"></script>
<script src="//cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
<![endif]-->