@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.ifgames-big'))

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron ifgames">
        <div class="container">
            <iframe width="100%" height="380" src="http://www.youtube.com/embed/kZsJrr1_1wU?&rel=0&theme=light&showinfo=0&disablekb=1&modestbranding=1&controls=0&autohide=1" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
    @endif

    <div class="big-container">
        <div class="container">
            <img src="{{ asset('assets/images/ifgames-banner.jpg') }}" width="100%" alt="IF Games 2014" />
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop
