@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.ifgames-big'))

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron ifgames">
        <div class="container">
            <iframe width="100%" height="380" src="http://www.youtube.com/embed/yo1Z8Fn7g9k?&rel=0&theme=light&showinfo=0&disablekb=1&modestbranding=1&controls=0&autohide=1" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
    @endif

    <div class="big-container">
        <div class="container">
            <h2>Ketentuan Pendaftaran</h2>
            <div class="well well-lg">
                <ol>
                    <li>Pertama</li>
                    <li>Pertama</li>
                    <li>Pertama</li>
            </div>
        </div>
    </div>

    <div class="big-container grey">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    {{
                        Button::primary_lg_link_block(URL::route('event.index', array('month' => 1, 'year' => 2012)).'#event', Helper::fa('clipboard').' Daftar')
                    }}
                </div>
                <div class="col-md-6">
                    {{
                        Button::success_lg_link_block(URL::route('event.index', array('month' => 1, 'year' => 2012)).'#event', Helper::fa('sign-in').' Masuk')
                    }}
                </div>
            </div>
        </div>
    </div>

   
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop