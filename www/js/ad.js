$(document).ready(function () {
    document.getElementById('post_ad').disabled = true;
    document.getElementById("validate-status").style.display = "none";
});

function fillinginfields() {
    var description = document.getElementById('autocomplete').value;
    var departure = document.getElementById('autocomplete2').value;
    var destination = document.getElementById('description_input').value;
    var amount = document.getElementById('amount_input').value;
    
    if ((description =='') || (departure =='') || (destination =='') || (amount =='') ) {
        document.getElementById('post_ad').disabled = true;
        document.getElementById('post_ad').style.color = "black";
        document.getElementById('post_ad').style.backgroundColor = "grey";
        document.getElementById('post_ad').style.border = "2px solid black";
        
        document.getElementById("validate-status").innerHTML="Please fill in ALL fields";
        document.getElementById("validate-status").style.display = "block";
    }
    else{
        document.getElementById("validate-status").style.display = "none";
            document.getElementById('post_ad').disabled = false;
            document.getElementById('post_ad').style.color = "white";
            document.getElementById('post_ad').style.backgroundColor = "green";
            document.getElementById('post_ad').style.border = "2px solid green";
    }
}