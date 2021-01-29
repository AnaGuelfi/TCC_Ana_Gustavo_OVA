/*
Created by: Kenrick Beckett

Name: Chat Engine
*/

var papel = "";
var numero_jogadores = 4;

function Jogo () {
	this.mut = getMt;
	this.register = registerUser;
	this.turn = getTurn;
}

//envia a ação do jogador
function getMt(u) {
	$.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'function': 'mt',
			'turn_id': u.id,
			jogador_escolhido: $("select[name='jogadores']").val(),
			'jid': u.jid
			},
		dataType: "json",
		success: function(data){
			$("#mensagem").html("<p>Jogada realizada com sucesso!</p>");
			$("#resultado_jogada_php").html(data);
		},
	});
}

//registra usuário
function registerUser(user){
    $.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'function': 'register',
			'user': user.name,
			'id'  : user.id,
			'jid' : user.jid
			},
		dataType: "json",
		success: function(log){
			if (log == 2) {
				
				alert("A sala escolhida já está cheia!");
				
				setTimeout(function() {
					window.location.href = "index.php";
				}, 1000);
				
			}
			console.log("sucesso", log);
		},
		error: function(data){
			console.log(data);
		}
	});
}

// mensagens e turno
function getTurn(u){
    $.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'function': 'getTurn',
			'jid' : u.jid
			},
	    dataType: "json",
		success: function(log){
			console.log(log);
			
			// Identidade do jogador
			if (log['inicio'] != 0){
				var msg = "";
				var curiosidade = "";
				for (var i = 0; i < log['jogadores'].length; i++) {
					
					if (log['jogadores'][i]['id'] == u.id){
						msg = msg + " <p class='text-left identidade'><strong>Usuário: </strong>" +log['jogadores'][i]['nome']+ "</p> ";
						msg = msg + " <p class='text-left identidade'><strong>Personagem: </strong>" +log['jogadores'][i]['personagem']+ "</p> ";
						msg = msg + " <p class='text-left identidade'><strong>Função: </strong>" +log['jogadores'][i]['funcao_personagem']+ "</p>";
						// Gerar curiosidade
						curiosidade = curiosidade + " <div class = 'curiosidade'><p> <strong>Curiosidade: " +log['jogadores'][i]['curiosidade']+ "<strong></p></div>";
					}
				}
				$('.usuario').replaceWith(msg);
				$('.curiosidade').replaceWith(curiosidade);
			} else {
				$('.usuario').replaceWith("<strong class = 'aguarde'>Aguardando jogadores...</strong>");
			}
			
			// Lógica do jogo
			if (log['fim'] == 0){
				if(u.id == log['jogadoratual']){
					for (var i = 0; i < log['jogadores'].length; i++) {
						if (log['jogadores'][i]['id'] == log['jogadoratual']){
							var estado = log['jogadores'][i]['estado'];
							if (estado != 1){
								$( "div.status" ).replaceWith( "<div class='status'><strong class = 'vez'>Sua vez de jogar!</strong></div>" );
								
								// Formação do select com os jogadores que podem ser escolhidos
								var cmd = "";

								cmd = cmd + " <select name = 'jogadores' id='jogadores'> ";
								for (var i = 0; i < log['jogadores'].length; i++) {
									if (log['jogadores'][i]['id'] != log['jogadoratual']){
										if (log['jogadores'][i]['estado'] != 1){
											cmd = cmd + " <option value = " +log['jogadores'][i]['id']+ ">"+log['jogadores'][i]['nome']+"</option> ";
										}
									}
								}
								cmd = cmd + " </select> ";

								$('#jogadores1').replaceWith(cmd);
								
							} else {
								$( "div.status" ).replaceWith( "<div class='status'><span class = 'eliminado'>Você foi <strong>eliminado</strong>! Pressione o botão para continuar e descobrir o final desse jogo!</span></div>" );
							}
						}
					}
				}else{
					$( "div.status" ).replaceWith( "<div class='status'><strong class = 'aguarde'>Aguarde sua vez!</strong></div>" );
					$('#jogadores').replaceWith('<select name = "jogadores" id="jogadores1" style="display:none"></select>');
					$('#mensagem').replaceWith('<div id = "mensagem" style="display:none"></div>');
					$('#resultado_jogada_php').replaceWith('<div id = "resultado_jogada_php" style="display:none"></div>');
				}
			}else {
				if (log['fim1'] == 1) {
					$( "div.status" ).replaceWith( "<div class='status'><strong class = 'final'>O jogo acabou! O Ácido Nítrico (HNO₃) foi descoberto e será neutralizado! As estátuas estão salvas!</strong><p class = 'final'><a href = 'index.php'</a>Voltar para a Página Inicial.</p></div>" );
				}
				if (log['fim2'] == 1) {
					$( "div.status" ).replaceWith( "<div class='status'><strong class = 'final'>O jogo acabou! O Ácido Nítrico (HNO₃) eliminou as estátuas!</strong><p class = 'final'><a href = 'index.php'</a>Voltar para a Página Inicial.</p></div>" );
				}
				$('#jogadores').replaceWith('<select name = "jogadores" id="jogadores1" style="display:none"></select>');
			}
		},
	});
}
