<!DOCTYPE html>
<html lang="pt-BR">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Jogo</title>

		<link rel="sortcut icon" href="logo.gif" type="image/gif" />
		<link rel = "stylesheet" href = "estilos.css" />

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<link rel = "stylesheet" href = "css/bootstrap.min.css" />
		<script src = "js/jquery-3.4.1.min.js"></script>
		<script type="text/javascript" src="jogo_js.js"></script>
	</head>

	<body class = "jogo" onload="setInterval('jogo.turn(user)', 1000)">
		<div>
			<?php
				$jid = $_GET['nome_sala'];
				
				echo "<input type='hidden' id='jid' value='$jid' />";
				
			?>
			<script type="text/javascript">
				var user = new Object();

				// Nome do usuário:
				user.name = prompt("Digite seu nome:", "Guest");
				user.id = Date.now();

				user.jid = document.getElementById("jid").value;
				
				alert("Você entrou na sala: "+ user.jid);
				
				console.log("ID: " + user.id);

				// Nome padrão para o usuário ('Guest')
				if (!user.name || user.name === ' ') {
					user.name = "Guest";
				}

				// strip tags
				user.name = user.name.replace(/(<([^>]+)>)/ig,"");

				// Recursos visuais da página
				$("#name-area").html("You are: <span>" + user.name + "</span>");
				$(".Usuario").html("Usuário: <span>" + user.name + "</span>");

				// Funções do jogo
				var jogo =  new Jogo();

				jogo.register(user);

				$(function() {
					$("#bt").click(function() {
						jogo.mut(user);
					});
				});

			</script>

			<div class = "container" id = "jogo">

				<h1>Jogo</h1>
				<br />
				<div class = "branco">
					<div class="usuario"></div>

					<br /><br /><br />

						<form id="send-btn-area">

						<!-- div que recebe o select com os jogadores -->

							<div id="jogadores1">
							</div>

							<br />
							<br />

							<button id = "bt" class="btn btn-primary" type="button" name="pt">Enviar</button>
			
						</form>
						
						<br />
						
						<!-- div que recebe o estado do jogador -->
						
						<div class="status"></div>
						
						<br />
						
						<!-- mensagem após a jogada -->
						<div id = "mensagem"></div>
						<div id = "resultado_jogada_php"></div>
						<div class="curiosidade"></div>
					</div>
					
				<br />
				<br />
				<br />
			</div>
		</div>
	</body>

</html>
