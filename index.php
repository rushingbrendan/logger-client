<?php

$client_guid = getenv('CLIENT_GUID');
$server_url = getenv('SERVER_URL');

//include_once("test.html")

?>

<html>
<head>
<title>Chat Room</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
<script type="text/javascript">
$(document).ready(function() {

	var socket = io.connect('wss://mysterious-woodland-76957.herokuapp.com');

	socket.on('connect', function() {
	});

	socket.on('message', function(msg) {
		$("#messages").append('<li>Received message: '+msg+'</li>');
	});

	$('#debugSendbutton').on('click', function() {
		var toSend = { Level: "Debug", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
	});
	
	$('#InvalidGuidSend').on('click', function() {
		var toSend = { Level: "Debug", AuthGuid: "nah", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
	});
	
	$('#criticalSendbutton').on('click', function() {
		var toSend = { Level: "Critical", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
	});
	
	$('#errorSendbutton').on('click', function() {
		var toSend = { Level: "Error", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
	});

	$('#warningSendbutton').on('click', function() {
		var toSend = { Level: "Warning", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
	});

	$('#infoSendbutton').on('click', function() {
		var toSend = { Level: "Info", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
	});

	$('#massSendbutton').on('click', function() {
		var toSend = { Level: "Critical", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Critical", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0",Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Critical", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
		
		toSend = { Level: "Error", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Error", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Error", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
		
		toSend = { Level: "Warning", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Warning", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Warning", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0",Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
		
		toSend = { Level: "Info", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Info", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Info", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
		
		toSend = { Level: "Debug", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val() };
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Debug", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
		toSend = { Level: "Debug", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: $('#myMessage').val()};
		socket.send(JSON.stringify(toSend));
	});
	
	$('#NoLevel').on('click', function() {
		var toSend = { AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0", Message: "No Level" };
		socket.send(JSON.stringify(toSend));
	});
	
	$('#NoAuth').on('click', function() {
		var toSend = { Level: "Debug", Message: "No Auth" };
		socket.send(JSON.stringify(toSend));
	});
	
	$('#NoMessage').on('click', function() {
		var toSend = { Level: "Debug", AuthGuid: "878100a5-3228-4fbe-b91e-1e61a888f4e0"};
		socket.send(JSON.stringify(toSend));
	});

});
</script>
<ul id="messages"></ul>
<input type="text" id="myMessage">
<button id="criticalSendbutton">Critical</button>
<button id="errorSendbutton">Error</button>
<button id="warningSendbutton">Warning</button>
<button id="infoSendbutton">Info</button>
<button id="debugSendbutton">Debug</button>
<button id="massSendbutton">Mass AutoTesting</button>
<button id="InvalidGuidSend">Invalid Guid</button>
<button id="NoLevel">No Level</button>
<button id="NoAuth">No Auth</button>
<button id="NoMessage">No Message</button>
<!--https://mysterious-woodland-76957.herokuapp.com-->
<!--https://localhost:5000-->
</body>
</html>