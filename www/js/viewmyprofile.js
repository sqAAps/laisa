//  more
$('span#more_account').on('click', function () {
    $('span#more_account').show();
    $('span#recommendations').show();
    $('span#account_personal_details').show();
    $('p#account_description').show();
    $('span#more_account').hide();
});



//  Posts   span
$('span#all_posts').on('click', function () {
    $('div#ad_types.ad_types').toggle();
    $('div#view_all_ads').toggle();

   /*
   if($('li#index_all_posts.nav_items').css('background-color','rgba(0,0,0,0.0)')
         $('li#index_all_posts.nav_items').css('background-color', 'rgba(0,0,0,0.3)');
   else {
         $('li#index_all_posts.nav_items').css('background-color', 'rgba(0,0,0,0)');
   }
    
    $('li#index_all_posts.nav_items').toggle(
        function(){
            $(this).css('background-color','rgba(0,0,0,0.3)');
        },
        function(){
            $(this).css('background-color','rgba(0,0,0,0)');
        }
    );
    */
});



//      REVIEWS
$(document).ready(function () {
    $('h1#reviews').css("background-color", "#ffffff");
    $('h1#reviews').css("border-style", "solid");
    $('h1#reviews').css("border-color", "#ffffff");
    
    $('span#reviews_span').show();
    $('img#review_img').css("height", "60px");
});

$('h1#reviews').on('click', function () {
    $('h1#reviews').css("background-color", "#ffffff");
    $('h1#reviews').css("border-style", "solid");
    $('h1#reviews').css("border-color", "#ffffff");
    $('span#reviews_span').show();
    $('img#review_img').css("height", "60px");
    
    $('h1#posts').css("border-style", "none");
    $('h1#posts').css("background-color", "transparent");
    $('span#posts_span').hide();
    $('img#posts_img').css("height", "50px");
    
    $('h1#recurring_posts').css("border-style", "none");
    $('h1#recurring_posts').css("background-color", "transparent");
    $('span#recurring_span').hide();
    $('img#recurring_posts_img').css("height", "50px");
    
    
    
    $("div#ad_types.ad_types").hide();
    $("div#view_all_ads").hide();
    $("div#view_all_wanted_ads").hide();
    $("div#view_all_offered_ads").hide();
    
    $('div#reviews').show();
    
    $('div#reccuring_ad_types').hide();
    $('div#recurring-posts').hide();
});


//      ONCE-OFF
$('h1#posts').on('click', function () {
    $('h1#posts').css("border-style", "solid");
    $('h1#posts').css("background-color", "#ffffff");
    $('h1#posts').css("border-color", "#ffffff");
    $('span#posts_span').show();
    $('img#posts_img').css("height", "60px");
    $('div#index_all_ads').css("background-color", "#36F287");
    $('div#index_wanted_ads').css("background-color", "#189F87");
    $('div#index_offered_ads').css("background-color", "#189F87");
    $("div#view_all_ads.view_all_ads").show();
    
    $('h1#reviews').css("border-style", "none");
    $('h1#reviews').css("background-color", "transparent");
    $('span#reviews_span').hide();
    $('img#review_img').css("height", "50px");
    
    $('h1#recurring_posts').css("border-style", "none");
    $('h1#recurring_posts').css("background-color", "transparent");
    $('span#recurring_span').hide();
    $('img#recurring_posts_img').css("height", "50px");
    
    
    
    $('div#ad_types.ad_types').show();
    $('div#index_all_ads').css("background-color", "#36F287");
    $('div#view_all_ads').show();
    
    $('div#reviews').hide();
    
    $('div#reccuring_ad_types').hide();
    $('div#recurring-posts').hide();
});


//      RECURRING
$('h1#recurring_posts').on('click', function () {
    $('h1#recurring_posts').css("border-style", "solid");
    $('h1#recurring_posts').css("border-color", "#ffffff");
    $('h1#recurring_posts').css("background-color", "#ffffff");
    $('span#recurring_span ').show();
    $('img#recurring_posts_img ').css("height", "60px");
    
    $('h1#reviews').css("border-style", "none");
    $('h1#reviews').css("background-color", "transparent");
    $('span#reviews_span').hide();
    $('img#review_img').css("height", "50px");
    
    $('h1#posts').css("border-style", "none");
    $('h1#posts').css("background-color", "transparent");
    $('span#posts_span').hide();
    $('img#posts_img').css("height", "50px");
    

    $('div#reccuring_ad_types').show();
    $('div#recurring-posts').show();
    $('div#view_commuting_recurring_ads').show();
    
    $('div#reviews').hide();
    
    $('div#ad_types.ad_types').hide();
    $('div#view_all_ads').hide();
    $("div#view_all_wanted_ads").hide();
    $("div#view_all_offered_ads").hide();
});

$(document).ready(function () {
    $('div#reccuring_commuting').css("background-color", "#36F287");
});
$('div#reccuring_commuting').on('click', function () {
    $('div#reccuring_commuting').css("background-color", "#36F287");
    $('div#reccuring_driving').css("background-color", "#189F87");
    
    $('div#view_commuting_recurring_ads').show;
    $('div#view_driving_recurring_ads').hide;
});
$('div#reccuring_driving').on('click', function () {
    $('div#reccuring_driving').css("background-color", "#36F287");
    $('div#reccuring_commuting').css("background-color", "#189F87");
    
    $('div#view_commuting_recurring_ads').hide;
    $('div#view_driving_recurring_ads').show;
});


//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

//          FOLLOW      |   UNFOLLOW


//When user clicks follow button
$('#e_follow').click(function () {
    //GET user_id and ad_user_id
    var user_id = $('#user_id').val();
    var ad_user_id = $('#ad_user_id').val();
    
    //Show loading text
    $('#follow_text').text('Following......');
    
    //perfotm http request
    $.post("../follow/follow.php", {user_id: user_id, ad_user_id: ad_user_id}, function (data) {
        $('#follow_text').text(data);
    });
    
    //Hide button once pressed
    $('#first_follow').hide();
    $('#second_unfollow').show();
});

/* HOVER*/
$('#e_unfollow').mouseenter(function () {
    var ad_user_id_name = $('#ad_user_id_name').val();
    
    $('#e_unfollow').css("background-color", "red");
    $('#e_unfollow').css("border-color", "red");
    $('#e_unfollow').val("Unendorse " + ad_user_id_name + "?");
});
$('#e_unfollow').mouseleave(function () {
    var ad_user_id_name = $('#ad_user_id_name').val();
    
    $('#e_unfollow').css("background-color", "greenyellow");
    $('#e_unfollow').css("border-color", "greenyellow");
    $('#e_unfollow').val("You recommended " + ad_user_id_name);
});
//When user clicks unfollow button
$('#e_unfollow').click(function () {
    //GET user_id and ad_user_id
    var user_id = $('#user_id').val();
    var ad_user_id = $('#ad_user_id').val();
    
    //Show loading text
    $('#unfollow_text').text('Unfollowing......');
    
    //perfotm http request
    $.post("../follow/unfollow.php", {user_id: user_id, ad_user_id: ad_user_id}, function (data) {
        $('#unfollow_text').text(data);
    });
    
    //Hide button once pressed
    $('#first_follow').show();
    $('#second_unfollow').hide();
});




//When user clicks UNFOLLOW button
$('#u_unfollow').mouseenter(function () {
    var ad_user_id_name = $('#ad_user_id_name').val();
    
    $('#u_unfollow').css("background-color", "red");
    $('#u_unfollow').css("border-color", "red");
    $('#u_unfollow').val("Unendorse " + ad_user_id_name + "?");
});
$('#u_unfollow').mouseleave(function () {
    var ad_user_id_name = $('#ad_user_id_name').val();
    
    $('#u_unfollow').css("background-color", "greenyellow");
    $('#u_unfollow').css("border-color", "greenyellow");
    $('#u_unfollow').val("You recommended " + ad_user_id_name);
});

//When user clicks unfollow button
$('#u_unfollow').click(function () {
    //GET user_id and ad_user_id
    var user_id = $('#user_id').val();
    var ad_user_id = $('#ad_user_id').val();
    
    //Show loading text
    $('#unfollow_text').text('Unfollowing......');
    
    //perfotm http request
    $.post("../follow/unfollow.php", {user_id: user_id, ad_user_id: ad_user_id}, function (data) {
        $('#unfollow_text').text(data);
    });
    
    //Hide button once pressed
    $('#first_unfollow').hide();
    $('#second_follow').show();
});

//When user clicks follow button
$('#u_follow').click(function () {
    //GET user_id and ad_user_id
    var user_id = $('#user_id').val();
    var ad_user_id = $('#ad_user_id').val();
    
    //Show loading text
    $('#follow_text').text('Following......');
    
    //perfotm http request
    $.post("../follow/follow.php", {user_id: user_id, ad_user_id: ad_user_id}, function (data) {
        $('#follow_text').text(data);
    });
    
    //Hide button once pressed
    $('#second_follow').hide();
    $('#first_unfollow').show();
});


//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||