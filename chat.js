/*
Created by: Kenrick Beckett

Name: Chat Engine
*/

var instanse = false;
var state;
var mes;
var file;
var numero_jogadores = 3;

function Chat () {
	this.mut = getMt;
	this.register = registerUser;
	this.turn = getTurn;
}

//send the message
function getMt(id) {
	$.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'function': 'mt',
			'turn_id': id,
			jogador_escolhido: $("select[name='jogador_escolhido']").val(),
			'file': file
			},
		dataType: "json",
		success: function(data){
			$("#mensagem").html("Jogada realizada com sucesso!" + data);
			$("select[name='jogador_escolhido']").val("x");
		},
	});
}

//registra usuário
//Ana tera a missão de passar o objeto para o process.
function registerUser(user){
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
			$('.usuario').append(log);
			console.log("sucesso", log);
		},
		error: function(data){
			console.log(data);
		}
	});
}

function getTurn(u){
    $.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'function': 'getTurn',
			'file': file
			},
	    dataType: "json",
		success: function(log){
			console.log(log);
			
			if(log['jogadores'].length < numero_jogadores){
				$( "div.status" ).replaceWith( "Aguardando jogadores" );
			}

			if(u.id == log['jogadoratual']){
				$( "div.status" ).replaceWith( "Seu turno." );
				//$('#jogadores').append('<option>Luiz</option>');
				// for (var i = 0; i < numero_jogadores; i++) {
					// var valor_option = log['jogadores'];
					// $('#formulario').append('<select id="jogadores"><option' + valor_option + '>' + valor_option + '</option></select>');
				// }
				// $('#formulario').append('<button type="button" name="pt" id="ptsendie">Enviar</button>');
			}else{
				$( "div.status" ).replaceWith( "Aguarde sua vez." );
				$('#formulario').replaceWith('<select id="jogadores" style="display:none"></select>');
				//$('.userData').append("<p>Espera ai... Vez de "+log['jogadoratual']+"!</p>");
			}

				//$( "div.status" ).replaceWith( "<h2>New heading</h2>" );
		},
	});
}
