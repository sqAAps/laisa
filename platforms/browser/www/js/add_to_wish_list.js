function add_to_wishlist(id){
    var ad_id = id;
    $.post('index.php', {ad_id: ad_id});
}