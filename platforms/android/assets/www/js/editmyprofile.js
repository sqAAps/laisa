$(document).ready(function () {
    document.getElementById('edit_ad').disabled = true;
    document.getElementById("validate-status").style.display = "none";
});

function fillinginfields() {
    var firstName = document.getElementById('firstName').value;
    var surname = document.getElementById('surname').value;
    var phone_number = document.getElementById('phone_number').value;
    var password = document.getElementById('password').value;
    
    if ((firstName =='') || (surname =='') || (phone_number =='') || (password =='') ) {
        document.getElementById('edit_ad').disabled = true;
        document.getElementById('edit_ad').style.color = "black";
        document.getElementById('edit_ad').style.backgroundColor = "grey";
        document.getElementById('edit_ad').style.border = "2px solid black";
        
        document.getElementById("validate-status").innerHTML="Please fill in ALL fields";
        document.getElementById("validate-status").style.display = "block";
    }
    else{
        document.getElementById("validate-status").style.display = "none";
            document.getElementById('edit_ad').disabled = false;
            document.getElementById('edit_ad').style.color = "white";
            document.getElementById('edit_ad').style.backgroundColor = "green";
            document.getElementById('edit_ad').style.border = "2px solid green";
    }
}