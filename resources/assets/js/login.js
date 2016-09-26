$(document).ready(function () {
    $(".effect").each(function () {
        var src = $(this).data("src");
        if (src) {
            var img = new Image();
            img.onload = function () {
                $(this).addClass('active');
            };
            $(this).append(img);
            img.src = src;
            img.alt = 'Capa do Filme';
        }
    });
    $('.ui.modal').modal({
        blurring: true,
        closable: false
    }).modal('show');
});