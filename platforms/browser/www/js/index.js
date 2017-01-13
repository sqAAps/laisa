/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
        app.receivedEvent('deviceready');
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
        var parentElement = document.getElementById(id);
        var listeningElement = parentElement.querySelector('.listening');
        var receivedElement = parentElement.querySelector('.received');

        listeningElement.setAttribute('style', 'display:none;');
        receivedElement.setAttribute('style', 'display:block;');

        console.log('Received Event: ' + id);
    }
};

/*	W I S H L I S T */
function add_to_wishlist(id){
    var ajax = ajaxObj("POST", "../php/profile.php");
	ajax.send("add_to_wishlist="+id);
}


/*	C H O R E S	*/
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
			var ajax = ajaxObj("POST", "../php/send_message.php");
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText.slice(-12) === 'message_sent'){
						var elem = document.getElementById("send_container");
						elem.parentNode.removeChild(elem);
						alert("Message Sent");
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



//ONclick Value Proposition arrows
$("img#arrows_scroll").on('click', function () {
    $('html,body').animate({
        scrollTop: $("h1#how_it_works_header").offset().top}, 'slow');
});

$("img#arrows_scroll").mouseenter(function() {
    $("img#arrows_scroll").css("opacity", "1");
});

$("img#arrows_scroll").mouseleave(function() {
    $("img#arrows_scroll").css("opacity", "0.5");
});



/*	M O B I L E		M E N U	*/
function open_profile_menu(){
	$('img#profile_menu').hide();
    $('img#search_menu').hide();    
    $('img#close_menu1').show();
    $('div#profile_menu_button').toggle();
}
function close_profile_menu(){
    $('div#profile_menu_button').hide();
    
    $('img#search_menu').show();    
    $('img#close_menu1').hide();
    $('img#profile_menu').show();
}

function open_search_menu(){
    $('div#search_menu_button').toggle();
    
    $('img#profile_menu').hide();
    $('img#search_menu').hide();
    $('img#close_menu2').show();
}
	
function close_search_menu(){
    $('div#search_menu_button').hide();
    
    $('img#search_menu').show();    
    $('img#close_menu2').hide();
    $('img#profile_menu').show();
}


$("img#nav_image").on('click', function(){
    $('div#profile_menu_button').toggle();
});
$("img#more").on('click', function(){
    $('div#profile_menu_button').toggle();
});



//      Footer
$('li#contact_us.footer_items').on('click', function () {
    
    $('div#contact_us_form').toggle();
    
    $('html,body').animate({
        scrollTop: $("div#contact_us_form").offset().top},
        'slow');
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