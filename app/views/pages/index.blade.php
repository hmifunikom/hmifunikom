@extends('layouts.default')

@section('content')
    <div class="jumbotron home">
    </div>

    <div class="big-container">
        <div class="container">
            <h2>Siapa Kita?</h2>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
        </div>
    </div>

    <div class="photo-layer" style="background-image: url('/assets/images/leader-banner.jpg');">
        <div class="big-container blue bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-4 right">
                        <h2>The Leader</h2>
                        <h3>Muhammad Iqbal Muhyiddin</h3>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum</p>
                        <p><span class="subtext-big">VISI</span>
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip.</p>

                        <p><span class="subtext-big">MISI</span>
                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="big-container">
        <div class="container">
            <h2>Event Akan Datang</h2>
            @if($acara)
            <div class="event-list-container">
                <div class="event-container navy">
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
            </div>
            @else
            <div class="center">
                    <span class="big-title">Tidak ada event</span>
            </div>
            @endif
            <a class="pull-right" href="{{ action('event.index') }}" role="button">Lihat Event Lainnya &raquo;</a></p>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="big-container orange">
        <div class="container">
            <div class="right">
                <h2>Perpustakaan</h2>
            </div>

            <div class="row book-list jcarousel">
                <div class="book-rail">
                    <div class="col-md-4 book-container">
                        <div class="cover">
                            <img src="1336370068.pdf.jpg">
                        </div>
                        <div class="name">
                            Fisika Jilid 1
                        </div>
                    </div>
                    <div class="col-md-4 book-container">
                        <div class="cover">
                            <img src="1336370068.pdf.jpg">
                        </div>
                        <div class="name">
                            Fisika Jilid 2
                        </div>
                    </div>
                    <div class="col-md-4 book-container">
                        <div class="cover">
                            <img src="1336370068.pdf.jpg">
                        </div>
                        <div class="name">
                            Fisika Jilid 3
                        </div>
                    </div>
                    <div class="col-md-4 book-container">
                        <div class="cover">
                            <img src="1336370068.pdf.jpg">
                        </div>
                        <div class="name">
                            Fisika Jilid 4
                        </div>
                    </div>
                    <div class="col-md-4 book-container">
                        <div class="cover">
                            <img src="1336370068.pdf.jpg">
                        </div>
                        <div class="name">
                            Fisika Jilid 5
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <p class="jcarousel-pagination"></p>

            <a href="#" role="button">Lihat Buku Lainnya &raquo;</a></p>
        </div>
    </div>

@stop

@section('tagline')
    @include('includes.tagline', array('invert' => false))
@stop