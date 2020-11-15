<?php

# Enviroment variables
$client_guid = getenv('CLIENT_GUID');
$server_url = getenv('SERVER_URL');

?>

<!-- 
  FILE          : index.php
  PROJECT       : SENG2040 - Network Application Development - Logging Service
  PROGRAMMER    : Brendan Rushing & Eunjune Wi
  FIRST VERSION : 2020-11-15
  DESCRIPTION   :   Logging client to test logging service. 
                    Client made in php
                    Server made in phython
                    Client and Server hosted in Heroku and Enviroment variables are used to store senstive information.
-->

<html>
<head>
<title>Logger Client Test Application</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body>
<script type="text/javascript">

/*
FUNCTION :BuildMessage
DESCRIPTION : This function builds the logging message to be sent to server.
PARAMETERS : level, message
RETURNS : message
*/
function BuildMessage(level, message){

    // Get token from enviroment variables.
    var token = "<?php echo $client_guid ?>";
    
    // Build JSON.
    var toSend = { Level: level, AuthGuid: token, Message: message };
    return toSend;
}

$(document).ready(function() {

    // Get server URL from enviroment variables.
    var server = "<?php echo $server_url ?>";

    // Create web socket
	var socket = io.connect(server);

    // Connect web socket.
	socket.on('connect', function() {
	});

    // Message has been received.
	socket.on('message', function(msg) {
		$("#messages").append('<li>Received message: '+msg+'</li>');
	});

    // Debug button pressed.
	$('#debugSendbutton').on('click', function() {		
        var toSend = BuildMessage("Debug", $('#myMessage').val())
		socket.send(JSON.stringify(toSend));
	});
	
    // Critical button pressed.
	$('#criticalSendbutton').on('click', function() {
        var toSend = BuildMessage("Critical", $('#myMessage').val())
		socket.send(JSON.stringify(toSend));
	});
	
    // Error button pressed.
	$('#errorSendbutton').on('click', function() {
        var toSend = BuildMessage("Error", $('#myMessage').val())
		socket.send(JSON.stringify(toSend));
	});

    // Warning button pressed.
	$('#warningSendbutton').on('click', function() {
        var toSend = BuildMessage("Warning", $('#myMessage').val())
		socket.send(JSON.stringify(toSend));
	});

    // Info button pressed.
	$('#infoSendbutton').on('click', function() {
        var toSend = BuildMessage("Info", $('#myMessage').val())
		socket.send(JSON.stringify(toSend));
	});

    // Automated testing button pressed.
	$('#massSendbutton').on('click', function() {
        for (var y = 0; y < 200; y++){
            var toSend = BuildMessage("Critical", $('#myMessage').val())        
		    socket.send(JSON.stringify(toSend));
        }        
	});
	
    // No level button pressed.
	$('#NoLevel').on('click', function() {

        // Get token from enviroment variables.
        var token = "<?php echo $client_guid ?>";

		var toSend = { AuthGuid: token, Message: "No Level" };
		socket.send(JSON.stringify(toSend));
	});
	
    // No auth button pressed.
	$('#NoAuth').on('click', function() {
		var toSend = { Level: "Debug", Message: "No Auth" };
		socket.send(JSON.stringify(toSend));
	});
	
    // No message button pressed.
	$('#NoMessage').on('click', function() {

        // Get token from enviroment variables.
        var token = "<?php echo $client_guid ?>";
		var toSend = { Level: "Debug", AuthGuid: token};
		socket.send(JSON.stringify(toSend));
	});

    // Invalid Guid button pressed.
	$('#InvalidGuidSend').on('click', function() {
		var toSend = { Level: "Debug", AuthGuid: "nah", Message: $('#myMessage').val() };
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
<button id="InvalidGuidSend">Invalid Guid</button>
<button id="NoLevel">No Level</button>
<button id="NoAuth">No Auth</button>
<button id="NoMessage">No Message</button>


<button id="massSendbutton">Mass AutoTesting</button>
</body>
</html>