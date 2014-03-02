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
            {{
                Button::lg_link(URL::route('event.index', array('month' => $acara->tgl->month, 'year' => $acara->tgl->year)).'#event', '&laquo Kembali')
            }}
            <div class="event-view">
                <div class="event-item-container">
                    <div class="event-container">
                        <div class="info-container pull-left">
                            <div class="row"><div class="date">
                                <div class="day">{{ $acara->tgl->day }}</div>
                                <div class="month-year">
                                    <div class="month">{{ $acara->tgl->formatLocalized('%b') }}</div>
                                    <div class="year">{{ $acara->tgl->year }}</div>
                                </div>
                            </div></div>
                            <div class="row"><div class="time"><span class="fa fa-clock-o"></span>
                                <span class="text">{{ Helper::implode($acara->waktu, 'waktu') }}</span>
                            </div></div>
                            <div class="row"><div class="place"><span class="fa fa-map-marker"></span><span class="text">{{ $acara->tempat }}</span></div></div>
                        </div>
                        <div class="detail-container pull-left">
                            <div class="name-description">
                                <div class="name">
                                    <span>{{ $acara->nama_acara }}</span>
                                </div>
                                <div class="description">
                                    {{ Helper::parsedown($acara->info) }}
                                </div>

                                
                                <a class="btn btn-default btn-lg book-btn" href="{{ action('event.book.create', $acara->slug) }}" role="button">{{ Helper::fa('ticket') }} Pesan Tiket</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('tagline')
    @include('includes.tagline', array('invert' => true))
@stop