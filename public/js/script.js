$(function () {

    //----------Active burger menu-----------
    $(".burger").on('click', function () {
        $(".slide-menu").animate({
                width: "250px",
            }, 100),
            $(".list-one").css('transform', 'translateX(0px)'),
            $(".list-two").css('transform', 'translateX(0px)'),
            $(".list-three").css('transform', 'translateX(0px)'),
            $(".list-four").css('transform', 'translateX(0px)'),
            $(".list-five").css('transform', 'translateX(0px)'),
            $(".list-six").css('transform', 'translateX(0px)');

    });
    $(".btn-close").on('click', function () {
        $(".list-one").css('transform', 'translateX(200px)'),
            $(".list-two").css('transform', 'translateX(200px)'),
            $(".list-three").css('transform', 'translateX(200px)'),
            $(".list-four").css('transform', 'translateX(200px)'),
            $(".list-five").css('transform', 'translateX(200px)'),
            $(".list-six").css('transform', 'translateX(200px)'),
            $(".slide-menu").animate({
                width: "0px",
            }, 800);
    });
    //---------------------------------------

    //----------Active move buttons-----------

    $(".float-down").on('click', function () {
        $("html,body").animate({
            scrollTop: $(".our-product").offset().top
        }, 500)
    });

    $(".small-dot").on('click', function () {
        $(this).addClass("active-dot").siblings().removeClass("active-dot")
    });

    $(".b-one").on('click', function () {
        $("html,body").animate({
            scrollTop: $(".header").offset().top
        }, 500)
    });

    $(".b-two").on('click', function () {
        $("html,body").animate({
            scrollTop: $(".our-product").offset().top
        }, 500)
    });

    $(".b-three").on('click', function () {
        $("html,body").animate({
            scrollTop: $(".sensors").offset().top
        }, 500)
    });

    $(".b-four").on('click', function () {
        $("html,body").animate({
            scrollTop: $(".voice").offset().top
        }, 500)
    });

    $(".b-five").on('click', function () {
        $("html,body").animate({
            scrollTop: $(".page-footer").offset().top
        }, 500)
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() <= 200) {
            $(".b-one").addClass("active-dot").siblings().removeClass("active-dot")
        }
        if ($(window).scrollTop() >= 600) {

            $(".b-two").addClass("active-dot").siblings().removeClass("active-dot")
        }

        if ($(window).scrollTop() >= 1200) {

            $(".b-three").addClass("active-dot").siblings().removeClass("active-dot")
        }

        if ($(window).scrollTop() >= 2200) {

            $(".b-four").addClass("active-dot").siblings().removeClass("active-dot")
        }

        if ($(window).scrollTop() >= 2800) {

            $(".b-five").addClass("active-dot").siblings().removeClass("active-dot")
        }

    });

    //----------------------------------------

    //----------Active Nice Scroll-----------
    $("html,body").niceScroll({
        cursorwidth: '10px',
        autohidemode: false,
        zindex: 0,
        cursorcolor: '#FF6600',
        cursorborder: 'none',
        scrollspeed: '60',
        hidecursordelay: 400,
        cursorfixedheight: false,
        cursorminheight: 20,
        enablekeyboard: true,
        horizrailenabled: true,
        bouncescroll: false,
        smoothscroll: true,
        iframeautoresize: true,
        touchbehavior: false,
    });
    //----------------------------------------

    //---------- Resize text------------
    jQuery(".resize").fitText(1.7, {
        maxFontSize: '40px'
    });
    //---------------------------------

    //---------- Loading Screen------------
    /*$(window).on('load', function () {
        console.log("herelo")
        $(".loading").fadeOut();
    });*/
    //---------------------------------
    $('.dropdown-toggle').dropdown();


});