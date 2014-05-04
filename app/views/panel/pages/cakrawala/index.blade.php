@extends(((Request::ajax()) ? 'panel.layouts.ajax' : 'panel.layouts.default'))

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <h2>Cakrawala</h2>
        </div>
        <div class="col-xs-4 header-toolbar right">
            
        </div>
    </div>

    {{
        Breadcrumb::create(array('Home' => action('panel.index'), 'Cakrawala'))
    }}

    <div class="row placeholders">
        <div class="col-md-6 col-sm-3 placeholder center">
            <a href="{{action('panel.cakrawala.kompetisi.index')}}">
                <img src="{{asset('assets/images/cakrawala-kompetisi.jpg')}}" class="img-responsive" alt="Generic placeholder thumbnail">
            </a>
        </div>
        <div class="col-md-6 col-sm-3 placeholder center">
            <a href="#{{action('panel.cakrawala.kompetisi.index')}}">
                <img src="{{asset('assets/images/cakrawala-festival.jpg')}}" class="img-responsive" alt="Generic placeholder thumbnail">
            </a>
        </div>
        
    </div>
@stop