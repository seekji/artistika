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

    /*
    *
    * Select Variants
    * */
    var $contactsForm = $('.js-contacts-form');
    var $selectVariant = $('.js-variant-select');

    $selectVariant.niceSelect();

    $selectVariant.on('change', function() {
        var value = $(this).val();

        $contactsForm.find('fieldset').prop('disabled', true);
        $contactsForm.find('fieldset[data-type="' + value + '"]').prop('disabled', false);
    });

    $('input[type="tel"]').inputmask({
        'mask': '+7 (999) 999-9999'
    });

    /*
    *
    * Event Calendar
    * */
    $('.js-event-calendar').on('click', function(e) {
        e.preventDefault();

        $(this).parent().toggleClass('is-opened');
    });

    /*
    *
    * Notification close
    * */
    $('.js-close-notification').on('click', function(e) {
        e.preventDefault();

        $(this).parent().removeClass('is-opened');
    });

    /*
    *
    * Search open
    * */
    $('.js-open-search').on('click', function(e) {
        e.preventDefault();

        $('html').addClass('is-show-search');
    });
});