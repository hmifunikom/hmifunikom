<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{action('panel.index')}}"><img src="{{asset('assets/images/logo.png')}}" />HMIF Panel</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li {{ Helper::active('event.index') }} >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{Gravatar::src(Auth::panel()->user()->email, 30)}}" height="30" /> {{ Auth::panel()->user()->username }} {{Helper::fa('angle-down')}}<div class="clearfix"></div></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">{{Helper::fa('user')}} Profile</a></li>
                        <li><a href="#">{{Helper::fa('gear')}} Setting</a></li>
                        <li><a href="/panel/log" target="blank">{{Helper::fa('list-alt')}} Application Log</a></li>
                        <li class="divider"></li>
                        <li><a href="{{action('sessions.destroy')}}">{{Helper::fa('sign-out')}} Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.navbar-collapse -->
    </div>
</div>