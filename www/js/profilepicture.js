$(function(){    
    
    //PROFILE_picture
    $('img#profile_image').click(function(){
        $("form#form").toggle();
        $('img#profile_image').css({ opacity: 0.3 });
    });
    
    $('#form').ajaxForm({
        complete:function(response){
            $(".upload_image").html("<img src='"+response.responseText+"' width='100%' height='100%' />");
            window.location.reload();
        }
    });
    
    //BAckground Picture
    $('img#profile_background').on('click', function(){
        $('form#background_form').show();
        $('img#profile_background').css({ opacity: 0.3 });
    });
    $('#background_form').ajaxForm({
        complete:function(response){
            $(".upload_image").html("<img src='"+response.responseText+"' width='100%' height='100%' />");
            window.location.reload();
        }
    });
    
});

//$('#file_submut').on('click', function(){
//    $("#user_profile").load("../View_my_profile/view_my_profile.php");
//})