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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
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

        /*
        FUNCTION :MassMessages
        DESCRIPTION : This function sends a mass message request
        PARAMETERS : amount, message, level
        RETURNS : none
        */
        function MassMessages(level, message, amount){

        // Get token from enviroment variables.
        var token = "<?php echo $client_guid ?>";

        // Build JSON.
        var toSend = { Level: level, AuthGuid: token, Message: message };

        for (var y = 0; y < amount; y++){
            socket.send(JSON.stringify(toSend));
        }
    }

    // Message has been received.
	socket.on('message', function(msg) {
        var currentTime = Date.now();        
		$("#messages").append('<li class="list-group-item">'+ currentTime.toString() + ' - ' +'Received message: '+msg+'</li>');
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
	$('#massSendbutton10').on('click', function() {
        MassMessages("Debug", $('#myMessage').val(), 10)   
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

<div class="container">
    <div class="form-group">
        <label>Log Message</label>
        <input type="text" id="myMessage" class="form-control" value="Test Message">
        <button id="criticalSendbutton" class="btn btn-danger">Critical</button>
        <button id="errorSendbutton" class="btn btn-primary">Error</button>
        <button id="warningSendbutton" class="btn btn-warning">Warning</button>
        <button id="infoSendbutton" class="btn btn-info">Info</button>
        <button id="debugSendbutton" class="btn btn-light">Debug</button>
        <br />
        <br />
        <br />

        <label>Invalid Log Messages</label>
        <button id="InvalidGuidSend" class="btn btn-secondary">Invalid Guid</button>
        <button id="NoLevel" class="btn btn-secondary">No Level</button>
        <button id="NoAuth" class="btn btn-secondary">No Auth</button>
        <button id="NoMessage" class="btn btn-secondary">No Message</button>
        <br />
        <br />
        <br />

        <label>Automated Testing</label>
        <button id="massSendbutton10" class="btn btn-primary">10 Messages</button>
        <button id="massSendbutton100" class="btn btn-primary">100 Messages</button>
        <button id="massSendbutton1000" class="btn btn-primary">1000 Messages</button>
        <button id="massSendbutton10000" class="btn btn-primary">10000 Messages</button>
    </div>

    <label>Event Log</label>
    <ul id="messages" class="list-group"></ul>
</div>

</body>
</html>