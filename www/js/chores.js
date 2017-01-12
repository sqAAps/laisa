function ajaxObj( meth, url ) {
	var x = new XMLHttpRequest();
	x.open( meth, url, true );
	x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	return x;
}

function ajaxReturn(x){
	if(x.readyState == 4 && x.status == 200){
		return true;	
	}
}

function _(id){
	return document.getElementById(id);
}

function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} 
	tf.value = tf.value.replace(rx, "");
}

function emptyElement(x){
	_(x).innerHTML = "";
}

function send_message(ad_id){
	var send_container = document.createElement('div');
	send_container.className = "send_container";
	send_container.id = "send_container";
	document.getElementById("send_msg_container").appendChild(send_container);
	
	
	var send_message = document.createElement('div');
	send_message.className = "send_message_div";
	send_message.id = "send_message."+ad_id;
	document.getElementById("send_container").appendChild(send_message);
	
	var send_message_head = document.createElement('div');
	send_message_head.className ="send_head";
	var send_message_text_text = document.createTextNode("Send Message");
	send_message_head.appendChild(send_message_text_text);
	document.getElementById("send_message."+ad_id).appendChild(send_message_head);
	
	var send_text = document.createElement('textarea');
	send_text.className = "send_text";
	send_text.id = "send_text." + ad_id;
	send_text.setAttribute('placeholder', ' Type your message here');
	document.getElementById("send_message." + ad_id).appendChild(send_text);
	
	var send_button = document.createElement('input');
	send_button.id = "send_button." + ad_id;
	send_button.className = "send_button";
	send_button.setAttribute('type', 'button');
	send_button.setAttribute('value', 'SEND');
	send_button.name = "send_button";
	send_button.onclick = function(){
		var message = document.getElementById("send_text." + ad_id).value;
		if(_("send_text." + ad_id) === ""){
			_("send_text." + ad_id).style.border = "2px solid red";
		}
		else{
			_("send_text." + ad_id).style.border = "1px solid gainsboro";

			//var ajax = ajaxObj("POST", "http://www.sqaaps.co.za/php/login.php");
			var ajax = ajaxObj("POST", "php/send_message.php");
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText.slice(-12) === 'message_sent'){
						var elem = document.getElementById("send_container");
						elem.parentNode.removeChild(elem);
						alert("Message Sent")
					}
				}
			}
			ajax.send("message="+message+"&ad_id="+ad_id);
		}
	}
	document.getElementById("send_message." + ad_id).appendChild(send_button);
	
	var cancel_button = document.createElement('input');
	cancel_button.id = "cancel_button." + ad_id;
	cancel_button.className = "cancel_button";
	cancel_button.setAttribute('type', 'button');
	cancel_button.setAttribute('value', 'CANCEL');
	cancel_button.name = "cancel_button";
	cancel_button.onclick = function(){
		var elem = document.getElementById("send_container");
		elem.parentNode.removeChild(elem);
	}
	document.getElementById("send_message." + ad_id).appendChild(cancel_button);
}