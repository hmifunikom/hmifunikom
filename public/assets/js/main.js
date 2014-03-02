$(function(){
    var navbar_offset = $('.jumbotron').offset().top + $('.jumbotron').height();
    $(window).scroll(function(){
        if ($(document).scrollTop() > navbar_offset) {
            $('.navbar').removeClass("big");
        } else {
            $('.navbar').addClass("big");
        }
    });

     var jcarousel = $('.jcarousel');


    $('.jcarousel').on('jcarousel:reload jcarousel:create', function () {
        var width = jcarousel.width();

        if (width >= 768) {
            width = width / 3;
        } else if (width >= 600) {
            width = width / 2;
        } else if (width >= 350) {
            width = width;
        }

        jcarousel.jcarousel('items').css('width', width + 'px');
    }).jcarousel({
        wrap: 'circular'
    });

    $('.jcarousel-pagination').on('jcarouselpagination:active', 'a', function() {
        $(this).addClass('active');
    }).on('jcarouselpagination:inactive', 'a', function() {
        $(this).removeClass('active');
    }).on('click', function(e) {
        e.preventDefault();
    }).jcarouselPagination({
        perPage: 1,
        item: function(page) {
            return '<a href="#' + page + '">' + page + '</a>';
        }
    });

    makeCalendar();

    $('.js-event-toggle-type .btn').on('click', function(){
        var active_class = $(this).find('input').val();
        
        var e_active = $('.event-view').find('.' + active_class);
        e_active.fadeIn();
        e_active.siblings().hide();

    });
});