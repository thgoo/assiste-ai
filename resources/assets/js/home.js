if (window.location.hash && window.location.hash == '#_=_') {
    window.location.hash = '';
}

var threads = new Array();
var item_height;

$.ajax({
    type: 'get',
    url: 'threads/',
    dataType: 'json',
    beforeSend: function () {
        $('.loader').addClass('active');
    },
    success: function (data) {
        var template = $('#thread-template').html();
        Mustache.parse(template);
        for (var i = 0; i < data.length; i++) {
            if (data[i].movie.category === 'movie') {
                data[i].category = 'Filme';
            } else {
                data[i].category = 'Série';
            }
            var rendered = Mustache.render(template, data[i]);
            $('.outer-threads .segment .threads .gap').first().before(rendered);
        }

        item_height = $('.thread').first().height()

        $('.loader').removeClass('active');
        $('.outer-threads .segment, .new').css({
            'opacity': 1,
        });

        // -- FILTER
        $('.threads').mixItUp({
            load: {
                filter: '.thread'
            },
            animation: {
                effects: 'fade',
                duration: 400
            },
            callbacks: {
                onMixLoad: function () {
                    //Grid.addItems($('.threads .thread'));
                },
                onMixEnd: function () {
                    //Grid.init();
                    //Grid.addItems($('.threads .thread'));
                }
            },
            controls: {
                live: true,
                activeClass: 'active'
            }
        });
        // -- END FILTER
    },
});

var timeout, val, exp;
$('#search').on('keyup', function () {
    var $matching = $();
    var that = $(this);
    clearTimeout(timeout);
    timeout = setTimeout(function () {
        val = that.val();
        exp = new RegExp(val, 'i');
        $('.thread').each(function () {
            var isMatch = exp.test($(this).data('title'));
            var isMatch2 = exp.test($(this).data('title-ptbr'));
            if (isMatch || isMatch2) {
                $matching = $matching.add($(this));
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
        $('.threads').mixItUp('filter', $matching);
    }, 500);
});

// Coloca o foco na busca, no topo da home
$('#search').focus();

// Efeitos na lista de indicações na home
$(document).on('mouseenter', '.overlay', function () {
    $(this).addClass('active');
    $(this).parents('figure').find('img').first().addClass('active');
});
$(document).on('mouseleave', '.overlay', function () {
    $(this).removeClass('active');
    $(this).parents('figure').find('img').first().removeClass('active');
});

var active_threads = [],
    load_thread_info;

$(document).on('click', '.see-more', function (e) {
    e.preventDefault();
    var $thread = $(this).closest('.thread');
    var $info = $thread.find('.more-info');

    if (!$info.hasClass('expanded')) {
        closeAll();
        open($thread);
    } else {
        closeAll();
    }
});

$(document).on('click', '.no-action', function (e) {
    e.preventDefault();
});

$(document).on('click', '.close', function () {
    closeAll();
});

function open($thread) {
    var hash = $thread.find('.see-more').attr('href');
    var i = hash.indexOf('-');
    var split = [hash.slice(1, i), hash.slice(i + 1)];
    var id = split[0];
    var slug = split[1];
    var $info = $thread.find('.more-info');
    var $wrapper = $thread.find('.inner-wrapper');

    load_thread_info = $.ajax({
        type: 'get',
        url: 'threads/' + id + '/' + slug,
        dataType: 'json',
        beforeSend: function () {
            $thread.addClass('expanded');

            $info.append($('<div/>', {
                class: 'ui inverted large loader active'
            }));

            // Loader
            var height = item_height + 200;

            $info.css({height: 120})
            $thread.css({height: height});

            active_threads.push($thread);
        },
        success: function (data) {
            var template = $('#more-info-template').html();
            Mustache.parse(template);
            data.thread.movie.genre = data.thread.movie.genre.split(',');
            var rendered = Mustache.render(template, data.thread);
            $wrapper.append(rendered);


            $wrapper.find('img').on('load', function () {
                var height = item_height + $info[0].scrollHeight + 21;

                $info.css({height: $info.prop('scrollHeight')})
                $thread.css({height: height});

                $info.addClass('expanded');
                $info.find('.loader').remove();

                $('.pop-permlink').popup({
                    popup: $('.permlink.' + data.thread.id),
                    variation: 'inverted wide',
                    position: 'bottom right',
                    hoverable: 'true',
                    on: 'click'
                });
            });
        },
    });
}

// Usa o "Esc" para fechar threads abertas.
$(document).keyup(function (e) {
    if (e.which == 27) {
        closeAll();
    }
});

// jshint -W083
// Fecha todas as threads abertas;
function closeAll() {
    var $thread, $info;
    for (var i = 0; i < active_threads.length; i++) {
        $thread = active_threads.pop();
        $info = $thread.find('.more-info');

        $info.removeClass('expanded');
        $info.css({height: 0})
        $thread.css({height: item_height});
        load_thread_info.abort();
        setTimeout(function () {
            $info.find('.inner-wrapper').empty();
        }, 310);
    }
}

// Ao colocar o focus no link da thread, o link inteiro será selecionado.
$(document).on('focus', '.permlink', function (e) {
    $(this).one('mouseup', function () {
        $(this).select();
        return false;
    }).select();
});
