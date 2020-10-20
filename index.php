<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<?php
/*
		if(file_exists("participantes.txt")){
			$arquivo = fopen("participantes.txt", "r");
			$participantes = chop(fgets($arquivo));
			fclose($arquivo);
		}

		if($participantes>=5){
			header('Location: sala_cheia.html');
		}
*/
	?>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Chat</title>

    <link rel="stylesheet" href="style.css" type="text/css" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="chat.js"></script>
    <script type="text/javascript">

      var user = new Object();
        // ask user for name with popup prompt
      user.name = prompt("Enter your chat name:", "Guest");
      user.id = Date.now();

        // default name is 'Guest'
    	if (!user.name || user.name === ' ') {
    	   user.name = "Guest";
    	}

    	// strip tags
    	user.name = user.name.replace(/(<([^>]+)>)/ig,"");

    	// display name on page
    	$("#name-area").html("You are: <span>" + user.name + "</span>");

    	// kick off chat
        var chat =  new Chat();
		// criar função que retorna se a sala está cheia ou não
		var x = chat.sala();
		
		chat.register(user);
		
    	$(function() {

    		 chat.getState();

    		 // watch textarea for key presses
             $("#sendie").keydown(function(event) {

                 var key = event.which;

                 //all keys including return.
                 if (key >= 33) {

                     var maxLength = $(this).attr("maxlength");
                     var length = this.value.length;

                     // don't allow new content if length is maxed out
                     if (length >= maxLength) {
                         event.preventDefault();
                     }
                  }
    		 																																												  });
    		 // watch textarea for release of key press
    		 $('#sendie').keyup(function(e) {

    			  if (e.keyCode == 13) {

                    var text = $(this).val();
    				var maxLength = $(this).attr("maxlength");
                    var length = text.length;

                    // send
                    if (length <= maxLength + 1) {

    			        chat.send(text, user.name);
    			        $(this).val("");

                    } else {

    					$(this).val(text.substring(0, maxLength));

    				}


    			  }
             });

    	});
    </script>

</head>

<body onload="setInterval('chat.update()', 1000); setInterval('chat.turn(user.id)', 1000)">

    <div id="page-wrap">

        <h2>jQuery/PHP Chat</h2>

        <p id="name-area"></p>

        <div id="chat-wrap"><div id="chat-area"></div></div>

        <form id="send-message-area">
            <p>Your message: </p>
            <textarea id="sendie" maxlength = '100' ></textarea>
        </form>

		<br />
		<br />

        <h3 class="userData">Mensagem: </h3><br />
		<h3 class="teste">Usuário: </h3>
    </div>

</body>

</html>
