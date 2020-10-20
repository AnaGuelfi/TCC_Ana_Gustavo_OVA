/*
Created by: Kenrick Beckett

Name: Chat Engine
*/

var instanse = false;
var state;
var mes;
var file;
var id;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
	  this.getState = getStateOfChat;
    this.register = registerUser;
    this.turn = getTurn;
	this.sala = sala_cheia;
}

//gets the state of the chat
function getStateOfChat(){
	if(!instanse){
		 instanse = true;
		 $.ajax({
			   type: "POST",
			   url: "process.php",
			   data: {
			   			'function': 'getState',
						'file': file
						},
			   dataType: "json",

			   success: function(data){
				   state = data.state;
				   instanse = false;
			   },
			});
	}
}

//Updates the chat
function updateChat(){
	 if(!instanse){
		 instanse = true;
	     $.ajax({
			   type: "POST",
			   url: "process.php",
			   data: {
			   			'function': 'update',
						'state': state,
						'file': file
						},
			   dataType: "json",
			   success: function(data){
				   if(data.text){
						for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                        }
				   }
				   document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				   instanse = false;
				   state = data.state;
			   },
			});
	 }
	 else {
		 setTimeout(updateChat, 1500);
	 }
}

//send the message
function sendChat(message, nickname)
{
    updateChat();
     $.ajax({
		   type: "POST",
		   url: "process.php",
		   data: {
		   			'function': 'send',
					'message': message,
					'nickname': nickname,
					'file': file
				 },
		   dataType: "json",
		   success: function(data){
			   updateChat();
		   },
		});
}

//registra usuário

function registerUser(user)
{
     $.ajax({
		   type: "POST",
		   url: "process.php",
		   data: {
		   			'function': 'register',
					  'user': user.name,
            'id'  : user.id,
					  'file': file
				 },
		   dataType: "json",
		   success: function(log){
			console.log("sucesso", log);
		   },
		   error: function(data){
			console.log(data);
		   }
		});
}

function getTurn(u)
{
     $.ajax({
		   type: "POST",
		   url: "process.php",
		   data: {
		   			'function': 'getTurn',
					  'file': file
				 },
		   dataType: "json",
		   success: function(log){
			 if(id == log['jogadoratual']){
				$('.userData').append("Vez deste infeliz!");
				$('.teste').append(log['jogadoratual']);
			 }else{
			   $('.userData').append("Espera ai...");
			   $('.teste').append(log['jogadoratual']);
			 }

			   // updateChat();
		   },
		});
}

function teste(){
	return(true);
}

function sala_cheia()
{
     $.ajax({
		   type: "POST",
		   url: "process.php",
		   data: {
		   			'function': 'sala_cheia',
					  'file': file
				 },
		   dataType: "json",
		   success: function(log){
				//alert(teste());
		   },
		});
}
