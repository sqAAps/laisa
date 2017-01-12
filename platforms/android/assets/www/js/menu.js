$("img#profile_menu").on('click', function(){
	$('img#profile_menu').hide();
    $('img#search_menu').hide();    
    $('img#close_menu1').show();
    $('div#profile_menu_button').toggle();
});
$("img#close_menu1").on('click', function(){
    $('div#profile_menu_button').hide();
    
    $('img#search_menu').show();    
    $('img#close_menu1').hide();
    $('img#profile_menu').show();
});


$("img#search_menu").on('click',  function(){
    $('div#search_menu_button').toggle();
    
    $('img#profile_menu').hide();
    $('img#search_menu').hide();
    $('img#close_menu2').show();
});
$("img#close_menu2").on('click', function(){
    $('div#search_menu_button').hide();
    
    $('img#search_menu').show();    
    $('img#close_menu2').hide();
    $('img#profile_menu').show();
});


$("img#nav_image").on('click', function(){
    $('div#profile_menu_button').toggle();
});
$("img#more").on('click', function(){
    $('div#profile_menu_button').toggle();
});