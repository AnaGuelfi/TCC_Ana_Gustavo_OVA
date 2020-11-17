<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Chat</title>

		<link rel="stylesheet" href="style.css" type="text/css" />

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="chat.js"></script>
		<script type="text/javascript">

			var user = new Object();

			// Nome do usuário:
			user.name = prompt("Enter your chat name:", "Guest");
			user.id = Date.now();
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
			var chat =  new Chat();

			chat.register(user);

			$(function() {
				$("#ptsendie").click(function() {
					chat.mut(user.id);
				});
			});

		</script>

	</head>

	<body onload="setInterval('chat.turn(user)', 1000)">

		<div id="page-wrap">

			<h2>Jogo</h2>

			<div class="status"></div>

				<form id="send-btn-area">
					<div id = "formulario"></div>
					<?php


/*
						$arquivo = 'jogo.json';

						if (file_exists($arquivo)) {
							$jogo = json_decode(file_get_contents('jogo.json'));
							$jogadores = $jogo->jogadores;
							echo '<select name = "jogador_escolhido">
									<option value = "x" checked = "checked">Selecione um jogador</option>';
							foreach ( $jogadores as $j ){
								echo "<option value = '$j->id'>$j->nome</option>";
							}
							echo '</select>';
						}
*/
					?>

					<br />
					<br />

					<button type="button" name="pt" id="ptsendie">Enviar</button>

				</form>

				<div id = "mensagem"></div>

			<br />
			<br />

			<h2 class="usuario" class="teste">Usuário: </h2>

			<br />

			<h3 class="userData"></h3>

		</div>

	</body>

</html>
