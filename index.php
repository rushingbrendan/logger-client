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





$(document).ready(function() {

    // Date extension.
    Date.prototype.getUTCTime = function(){ 
    return this.getTime()-(this.getTimezoneOffset()*60000); 
    };

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

            for (var y = 0; y < amount; y++){
                var toSend = BuildMessage(level);
                socket.send(JSON.stringify(toSend));
            }
        }

        /*
        FUNCTION :BuildMessage
        DESCRIPTION : This function builds the logging message to be sent to server.
        PARAMETERS : level
        RETURNS : message
        */
        function BuildMessage(level){

            // Get token from enviroment variables.
            var token = "<?php echo $client_guid ?>";
            var time = new Date().getUTCTime();

            // Build JSON.
            var message = { 
                ApplicationId: $('#applicationId').val(),
                Time: "2020-11-14_20:10:28:123456",
                TransactionId: $('#transactionId').val(),
                UserId: $('#userId').val(),
                Class: $('#class').val(),
                Method: $('#method').val(),
                Description: $('#description').val()            
            }

            var toSend = { 
                Level: level, 
                AuthGuid: token, 
                Message: message };

            console.log(JSON.parse(JSON.stringify(toSend)));
            return toSend;
        }

    // Message has been received.
	socket.on('message', function(msg) {
        var currentTime = Date.now();        
		$("#messages").append('<li class="list-group-item">'+ currentTime.toString() + ' - ' +'Received message: '+msg+'</li>');
	});

    // Debug button pressed.
	$('#debugSendbutton').on('click', function() {		
        var toSend = BuildMessage("Debug");
		socket.send(JSON.stringify(toSend));
	});
	
    // Critical button pressed.
	$('#criticalSendbutton').on('click', function() {
        var toSend = BuildMessage("Critical");
		socket.send(JSON.stringify(toSend));
	});
	
    // Error button pressed.
	$('#errorSendbutton').on('click', function() {
        var toSend = BuildMessage("Error");
		socket.send(JSON.stringify(toSend));
	});

    // Warning button pressed.
	$('#warningSendbutton').on('click', function() {
        var toSend = BuildMessage("Warning");
		socket.send(JSON.stringify(toSend));
	});

    // Info button pressed.
	$('#infoSendbutton').on('click', function() {
        var toSend = BuildMessage("Info");
		socket.send(JSON.stringify(toSend));
	});

    // Automated testing button pressed.
	$('#massSendbutton10').on('click', function() {
        MassMessages("Debug", 10)   
	});

    // Automated testing button pressed.
	$('#massSendbutton100').on('click', function() {
        MassMessages("Debug", 100)   
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
    <h1>Logging Service Client Testing Interface</h1>
    <br />
    <br />
    <div class="form-group">
        <label>Application Id</label>
        <input type="text" id="applicationId" class="form-control" value="123456">

        <label>Transaction Id</label>
        <input type="text" id="transactionId" class="form-control" value="abcdef">

        <label>User Id</label>
        <input type="text" id="userId" class="form-control" value="123456">

        <label>Class</label>
        <input type="text" id="class" class="form-control" value="ClassName">

        <label>Method</label>
        <input type="text" id="method" class="form-control" value="MethodName">

        <label>Description</label>
        <input type="text" id="description" class="form-control" value="Message To Log">
        
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
    </div>

    <label>Event Log</label>
    <ul id="messages" class="list-group"></ul>
</div>

</body>
</html>