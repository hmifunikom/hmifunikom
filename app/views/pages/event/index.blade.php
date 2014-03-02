@extends(((Request::ajax()) ? 'layouts.ajax' : 'layouts.default'))

@section('content')
    @if(!Request::ajax())
    <div class="jumbotron event">
        <div class="container">
            <h2>Event HMIF</h2>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
        </div>
    </div>
    @endif

    <div id="event" class="big-container">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-4">
                    <?php $date->subMonth(); ?>
                    <a href="{{ URL::route('event.index', array('month' => $date->month, 'year' => $date->year)) }}#event">
                        &laquo {{ $date->formatLocalized('%B') }}
                    </a>
                </div>
                <div class="col-sm-4 center">
                    <b>{{ $date->addMonth()->formatLocalized('%B') }}</b>
                </div>
                <div class="col-sm-4 right">
                    <?php $date->addMonth(); ?>
                    <a href="{{ URL::route('event.index', array('month' => $date->month, 'year' => $date->year)) }}#event">
                        {{ $date->formatLocalized('%B') }} &raquo
                    </a>
                    <?php $date->subMonth(); ?>
                </div>
                
            </div>
            <hr>

            <div class="event-tool">
                <div class="pull-left">
                    {{ Lang::get('messages.event.showing', array('current' => $listacara->count(), 'total' => $total , 'year' => $date->year)) }}
                </div>
                <div class="pull-right">
                    {{ Button::link(URL::route('event.index').'#event', 'Now') }}
                    {{
                        ButtonGroup::radio(array(
                            array(ButtonGroup::NORMAL . ' active', Helper::fa('calendar'), array('value' => 'calendar')),
                            array(ButtonGroup::NORMAL, Helper::fa('list-ul'), array('value' => 'event-list-container')),
                        ), array('class' => 'js-event-toggle-type'))
                    }}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="event-view">
                <div id='calendar' class="calendar"></div>
                <script>
                    function makeCalendar() {
                        $('#calendar').fullCalendar({
                            header : false,
                            month : {{{ $date->month-1 }}},                        
                            events: [
                                @foreach($listacara as $acara)
                                {
                                    title: '{{{$acara->nama_acara}}}',
                                    start: new Date({{{$acara->tgl->year}}}, {{{$acara->tgl->month-1}}}, {{{$acara->tgl->day}}}),
                                    url  : '{{ route('event.show', $acara->slug) }}'
                                },
                                @endforeach
                            ]
                        });
                    }
                </script>

                <div class="event-list-container unvisible">
                @foreach($listacara as $acara)
                    <div class="event-container">
                        <div class="date-container pull-left">
                            <div class="date">{{ $acara->tgl->day }}</div>
                            <div class="month-year">
                                <div class="month">{{ $acara->tgl->formatLocalized('%b') }}</div>
                                <div class="year">{{ $acara->tgl->year }}</div>
                            </div>
                        </div>
                        <div class="name-place pull-left">
                            <div class="name">
                                {{ $acara->nama_acara }}
                            </div>
                            <div class="place-time pull-left">
                                <div class="place"><span class="fa fa-map-marker"></span>{{ $acara->tempat }}</div>
                                <div class="time"><span class="fa fa-clock-o"></span>
                                    {{ Helper::implode($acara->waktu, 'waktu') }}
                                </div>
                            </div>
                            <a class="btn btn-default btn-lg pull-right book-btn" href="{{ route('event.show', $acara->slug) }}" role="button"><span class="fa fa-info-circle"></span> Detail Event</a>
                            <div class="clearfix"></div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                @endforeach
                @unless ($listacara->count())
                <div class="center">
                        <span class="big-title">Tidak ada event</span>
                </div>
                @endunless
                </div>
            </div>
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop