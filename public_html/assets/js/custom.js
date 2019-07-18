$(document).ready(function() {
    /*
    *
    * Filter Portfolio
    * */

    var $filterGroup = $('.js-group-filter'),
        $filterGroupBtn = $('[data-filter]');

    $filterGroup.isotope({
        itemSelector: '.event'
    });

    $filterGroupBtn.on('click', function(){
        var href = $(this).attr('href').replace( /^#/, '' ),
            option = $.deparam( href, true );

        $.bbq.pushState( option );
        return false;
    });

    $(window).bind( 'hashchange', function( event ) {

        var hashOptions = $.deparam.fragment();

        $filterGroup.isotope( hashOptions );

        $filterGroupBtn.removeClass('is-active');
        $('[data-filter="'+hashOptions.filter+'"]').addClass('is-active');

    }).trigger('hashchange');

    /*
    *
    * Btn time
    * */
    $timeBtn = $('.js-btn-time');

    $timeBtn.on('click', function(e) {
        e.preventDefault();

        var time = $(this).text();

        $timeBtn.removeClass('is-active');
        $(this).addClass('is-active');

        $('[data-time]').text(time).attr('data-time', time);
    });
});