$(document).ready(function() {
    /*
    * Filter Portfolio
    * */
    var $filterGroup = $('.js-group-filter'),
        tags = [],
        eventsContainer = $('section.events'),
        instagramElement = eventsContainer.find('a.event.event_instagramm'),
        feedbackContainer = $('section.feedback'),
        offset = eventsContainer.find('.event__item').length,
        limit = 10,
        isDone = false,
        city = $('#current-city').data('id'),
        inProgress = false,
        $filterGroupBtn = $('.filter-item__tag');

    $filterGroup.isotope({
        itemSelector: '.event'
    });

    $filterGroupBtn.on('click', function() {
        if(!$(this).hasClass('is-active')) {
            offset = 0;
            isDone = false;
            tags = [];

            $filterGroupBtn.removeClass('is-active');
            $(this).addClass('is-active');

            if ($(this).data('id')) {
                tags.push($(this).data('id'));
            }

            eventsContainer.find('.event__item').fadeOut(500, function () {
                $(this).remove();
            });

            loadLazyItems();
        }

        return false;
    });

    if(eventsContainer.length > 0) {
        $(window).scroll(function() {
            if ((($(window).scrollTop() + $(window).height()) + 600) >= feedbackContainer.offset().top && inProgress === false && isDone === false) {
                loadLazyItems();
            }
        });
    }

    function loadLazyItems() {
        inProgress = true;

        $.ajax({
            dataType: 'json',
            method: 'GET',
            url: '/api/event/list/',
            data: {
                'offset': offset,
                'limit': limit,
                'city': city,
                'tags': tags
            },
            success: function(response) {
                isDone = response.is_done;
                offset = offset + limit;

                if(response.events.length > 0) {
                    instagramElement.fadeIn(100, function () { $(this).before($(response.events))});
                }

                inProgress = false;
            }
        })
    }

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