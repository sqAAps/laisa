$('div#recurring').on('click', function () {
    $('div#recurring').css("color", "orange");
    $('div#recurring').css("border-color", "black");
    $('div#recurring').css("border-style", "solid");
    $('div#recurring').css("border-width", "1px 0px 1px 0px");
    $('form#recurring_form').show();
    
    $('div#one-time').css("color", "gray");
    $('div#one-time').css("border-style", "none");
    $('form#post_form').hide();
});

$('div#one-time').on('click', function () {
    $('div#one-time').css("color", "orange");
    $('div#one-time').css("border-style", "solid");
    $('form#post_form').show();
    
    $('div#recurring').css("color", "gray");
    $('div#recurring').css("border-style", "none");
    $('form#recurring_form').hide();
});  