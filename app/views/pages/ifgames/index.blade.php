@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.ifgames-big'))

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron ifgames">
        <div class="container">
            <!--iframe width="100%" height="380" src="http://www.youtube.com/embed/yo1Z8Fn7g9k?&rel=0&theme=light&showinfo=0&disablekb=1&modestbranding=1&controls=0&autohide=1" frameborder="0" allowfullscreen></iframe-->
        </div>
    </div>
    @endif

    <div class="big-container">
        <div class="container">
            
            <div class="well well-lg">
                
            </div>
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop