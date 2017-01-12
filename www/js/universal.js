
//      ALL     |       Transport     |   Commuters
$(document).ready( function () {
    $('div#ad_types.ad_types').hide();
    
    $('div#view_all_wanted_ads').hide();
    $('div#view_all_offered_ads').hide();
    $('div#view_all_ads').hide();
    
    $('div#index_all_ads').css("background-color", "#36F287");
});

//      ALL
$('div#index_all_ads').on('click', function () {
    $('div#index_all_ads').css("background-color", "#36F287");
    $('div#index_wanted_ads').css("background-color", "#189F87");
    $('div#index_offered_ads').css("background-color", "#189F87");
    
    $('div#view_all_ads').show();
    $('div#view_all_wanted_ads').hide();
    $('div#view_all_offered_ads').hide();
});
//      |   Transport    |
$('div#index_wanted_ads').on('click', function () {
    $('div#index_all_ads').css("background-color", "#189F87");
    $('div#index_wanted_ads').css("background-color", "#36F287");
    $('div#index_offered_ads').css("background-color", "#189F87");
    
    $('div#view_all_ads').hide();
    $('div#view_all_wanted_ads').show();
    $('div#view_all_offered_ads').hide();
});
//      |   Commuters   
$('div#index_offered_ads').on('click', function () {
    $('div#index_all_ads').css("background-color", "#189F87");
    $('div#index_wanted_ads').css("background-color", "#189F87");
    $('div#index_offered_ads').css("background-color", "#36F287");
    
    $('div#view_all_ads').hide();
    $('div#view_all_wanted_ads').hide();
    $('div#view_all_offered_ads').show();
});

//      Footer
$('li#contact_us.footer_items').on('click', function () {
    
    $('div#contact_us_form').toggle();
    
    $('html,body').animate({
        scrollTop: $("div#contact_us_form").offset().top},
        'slow');
});
