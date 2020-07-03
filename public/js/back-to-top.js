$(window).scroll(function() {
    var ancora = $('#back-to-top');
    if ($(window).scrollTop() > 300) {
        ancora.fadeIn();
    } else {
        ancora.fadeOut();
    }
});

$('#back-to-top').on('click', function() {
    $('html, body').animate({
        scrollTop: 0
    }, 600);

    return false;
});
