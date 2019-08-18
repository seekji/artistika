$(document).ready(function() {
    /*
    * Filter Portfolio
    * */
    var tags = [],
        eventsContainer = $('section.events'),
        isArchive = eventsContainer.data('archive'),
        instagramElement = eventsContainer.find('a.event.event_instagramm'),
        feedbackContainer = $('section.feedback'),
        offset = eventsContainer.find('.event__item').length,
        limit = 10,
        isDone = false,
        city = $('#current-city').data('id'),
        inProgress = false,
        $filterGroupBtn = $('.filter-item__tag');

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

            eventsContainer.find('.event__item').fadeOut(80, function () {
                $(this).remove();
            });

            loadLazyItems();
        }

        return false;
    });

    checkoutElementsInGridRow();

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
                'tags': tags,
                'isArchive': isArchive,
            },
            success: function(response) {
                isDone = response.is_done;
                offset = offset + limit;

                if(response.events.length > 0) {
                    instagramElement.fadeIn(150, function () {$(this).before($(response.events)); checkoutElementsInGridRow();});
                }

                inProgress = false;
            }
        });
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
        $('.event-detail_ticket').attr('href', $(this).data('tickets'));
        $('#google-calendar').attr('href', $(this).data('add-google'));
        $('#apple-calendar, #outlook-calendar').attr('href', $(this).data('add-ics'));
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
    $('.js-open-search, .search__button').on('click', function(e) {
        e.preventDefault();

        $('.search__form')[0].reset();
        $('html').toggleClass('is-show-search');
        $('div.search__list').toggleClass('is-show').html('');
    });

    $('.search__form').on('submit', function (event) {
       event.preventDefault();
    });

    $('#search-input').on('change paste keyup', function (event) {
        event.preventDefault();

        var searchInProgress = false,
            formContainer = $(this).parents('form'),
            query = $(this).val().replace((/[^а-яёА-ЯЁA-Za-z0-9\s]/g), ''),
            searchContainerResult = formContainer.find('div.search__list');

        if(searchInProgress === false && query.length > 2) {
            searchInProgress = true;

            $.ajax({
                method: 'GET',
                url: formContainer.attr('action'),
                data: {
                    'query': query
                },
                dataType: 'json',
                statusCode: {
                    200: function (data) {
                        searchContainerResult.addClass('is-show');
                        searchContainerResult.html(data.result);
                    },
                }
            }).done(function () {
                searchInProgress = false;
            });
        }
    });

    /*
    *
    * Feedback form
     */
    $('.feedback__form, .contact-form').on('submit', function (event) {
        event.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            dateType: 'json',
            data: form.serialize(),
            statusCode: {
                201: function (data) {
                    $(form)[0].reset();
                    $('div.notification_success').addClass('is-opened');
                },
                400: function (data) {
                    $('div.notification_error').addClass('is-opened');
                    $('div.notification_error div.notification__title').html('');

                    if(data.responseJSON.errors.length > 0) {
                        data.responseJSON.errors.forEach(item => {
                            $('div.notification_error div.notification__title').prepend('<p>' + item + '</p>')
                        });
                    }
                }
            }
        });
    });

    function checkoutElementsInGridRow() {
        var elementsPerRow = 0,
            screenWidth = $(window).width(),
            spaces = 0,
            eventsItems = $('section.events').find('.event__item');

        if(screenWidth > 1670 ) {
            elementsPerRow = 4
        } else if(screenWidth > 1199) {
            elementsPerRow = 3
        } else if(screenWidth > 1023) {
            elementsPerRow = 2
        } else {
            return false;
        }

        eventsItems.each(function(index, element) {
            if($(element).hasClass('event_size_md')) {
                spaces += 2;
            }

            if($(element).hasClass('event_size_xs')) {
                spaces += 1;
            }

            if(spaces >= elementsPerRow) {
                if($(element).hasClass('event_size_md') && spaces > elementsPerRow) {
                    $(element).removeClass('event_size_md').addClass('event_size_xs');
                }

                spaces = 0;
            }
        });
    }
    
    $(window).resize(function () {
       checkoutElementsInGridRow();
    });
});