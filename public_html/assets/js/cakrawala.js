$(document).ready(function() {
    $('#fullpage').fullpage({
        resize: false,
        verticalCentered: false,
        anchors: ['DebatIT', 'ITContest', 'LKTI', 'Contact'],
        slidesColor: ['#333', '#fff', '#008cd6', '#fff'],
        autoScrolling: true,
        paddingTop: '50px',
        css3:true,
        scrollingSpeed:100,

        afterLoad: function(anchorLink, index){
            $('.cakrawala-logo.green').toggleClass('active', (anchorLink == 'ITContest'));
            $('.cakrawala-logo.red').toggleClass('active', (anchorLink == 'DebatIT'));
            // $('.cakrawala-logo.blue').toggleClass('active', (anchorLink == 'ITContest' ));
            $('.cakrawala-logo.black').toggleClass('active', (anchorLink == 'LKTI'));

            $('.nav .debat').toggleClass('active', (anchorLink == 'DebatIT'));
            $('.nav .itcontest').toggleClass('active', (anchorLink == 'ITContest'));
            $('.nav .lkti').toggleClass('active', (anchorLink == 'LKTI'));
            $('.nav .contact').toggleClass('active', (anchorLink == 'Contact'));
        },

        onLeave: function(index, nextIndex, direction){
            
        },

        afterSlideLoad: function( anchorLink, index, slideAnchor, slideIndex) {

            if(anchorLink == 'DebatIT') {
                switch(slideIndex) {
                    case 0:
                        if(! $('#persyaratan').hasClass('in')) {
                            $('.coll-persyaratan').click();
                        }
                    break;

                    case 1:
                        if(! $('#teknis').hasClass('in')) {
                            $('.coll-teknis').click();
                        }
                    break;

                    case 2:
                        if(! $('#tanggal').hasClass('in')) {
                            $('.coll-tanggal').click();
                        }
                    break;

                    case 3:
                        if(! $('#hadiah').hasClass('in')) {
                            $('.coll-hadiah').click();
                        }
                    break;
                }
            }

            if(anchorLink == 'ITContest') {
                $('.info-title.persyaratan').toggleClass('active', (slideAnchor == 'persyaratan'));
                $('.info-title.tanggal').toggleClass('active', (slideAnchor == 'tanggal'));
                $('.info-title.teknis').toggleClass('active', (slideAnchor == 'teknis'));
                $('.info-title.hadiah').toggleClass('active', (slideAnchor == 'hadiah'));
            }

            if(anchorLink == 'LKTI') {
                switch(slideIndex) {
                    case 0:
                        $('.panel-v.persyaratan .panel-title a').click();
                    break;

                    case 1:
                        $('.panel-v.teknis .panel-title a').click();
                    break;

                    case 2:
                        $('.panel-v.waktu .panel-title a').click();
                    break;

                    case 3:
                        $('.panel-v.hadiah .panel-title a').click();
                    break;
                }
            }
        },

        onSlideLeave: function( anchorLink, index, slideIndex, direction){

        }

    });

    activePanel = $("#accordion2 div.panel-v:first");
    $(activePanel).addClass('active');

    $('.panel-v .panel-title a').on('click', function(e){
        var target = $(this).data('anchor');
        target =  $('.panel-v.' + target);

        if( ! target.is('.active') ){
            $(activePanel).animate({width: "40px"}, 300);
            target.animate({width: "852px"}, 300);
            $('#accordion2 .panel-v').removeClass('active');
            target.addClass('active');
            activePanel = target;
        }
    });

    $('.arrow').on('click', function() {
        if ($(this).hasClass('arrowLeft')) {
            $.fn.fullpage.moveSlideLeft();
        } else {
            $.fn.fullpage.moveSlideRight();
        }
    });
});