$(document).ready(function () {
    document.getElementById('submit').disabled = true;
    document.getElementById('submit').style.color = "black";
    document.getElementById('submit').style.backgroundColor = "grey";
    document.getElementById('submit').style.border = "2px solid black";
});

function fillinginfields() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    
    var firstName = document.getElementById('firstName').value;
    var surname = document.getElementById('surname').value;
    var phoneNumber = document.getElementById('phoneNumber').value;
    
    var email = document.getElementById('email').value;
    
    
    if ((firstName =='') || (surname =='') || (phoneNumber =='') || (email =='') ) {
        document.getElementById('submit').disabled = true;
        document.getElementById('submit').style.color = "black";
        document.getElementById('submit').style.backgroundColor = "grey";
        document.getElementById('submit').style.border = "2px solid black";
        
        document.getElementById("validate-status").innerHTML="Please fill in ALL fields";
        document.getElementById("validate-status").style.display = "block";
    }
                        
    else if (password == '') {
        document.getElementById('submit').disabled = true;
        document.getElementById('submit').style.color = "black";
        document.getElementById('submit').style.backgroundColor = "grey";
        document.getElementById('submit').style.border = "2px solid black";
        document.getElementById("validate-status").innerHTML="Please fill in the Password field";
        document.getElementById("validate-status").style.display = "block";
    }
    
    else if (password === confirmPassword) {
        
        if ((firstName =='') || (surname =='') || (phoneNumber =='') || (email =='') ) {
            document.getElementById("validate-status").innerHTML="Passwords MATCH. <br>Ensure ALL OTHER fields are matched";
            document.getElementById("validate-status").style.display = "block";   
        }
        else{
            document.getElementById("validate-status").style.display = "none";
            document.getElementById('submit').disabled = false;
            document.getElementById('submit').style.color = "white";
            document.getElementById('submit').style.backgroundColor = "green";
            document.getElementById('submit').style.border = "2px solid green";
        }
    } 
    
    else if (password !== confirmPassword) {
        document.getElementById('submit').disabled = true;
        document.getElementById("validate-status").style.display = "block";
        document.getElementById("validate-status").innerHTML="Passwords do not match";
        document.getElementById('submit').style.color = "black";
        document.getElementById('submit').style.backgroundColor = "grey";
        document.getElementById('submit').style.border = "2px solid black";
    }
    
    else{
        document.getElementById("validate-status").style.display = "none";
            document.getElementById('submit').disabled = false;
            document.getElementById('submit').style.color = "white";
            document.getElementById('submit').style.backgroundColor = "green";
            document.getElementById('submit').style.border = "2px solid green";
    }
}