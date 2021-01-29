<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<title>Página Inicial</title>
		
		<link rel="sortcut icon" href="logo.gif" type="image/gif" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
		<link rel = "stylesheet" href = "css/bootstrap.min.css" />
		<link rel = "stylesheet" href = "estilos.css" />
		<script src = "js/jquery-3.4.1.min.js"></script>
	
	</head>
	<body>
		
		<ul class="nav justify-content-center bg-secondary">
			<li class="nav-item">
				<a class="nav-link text-dark font-weight-bold h5" href="index.php">Página Inicial</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-dark font-weight-bold h5" href="tutorial.php">Tutorial</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-dark font-weight-bold h5" href="sobre.php">Sobre</a>
			</li>
		</ul>
		
		<br />
		<br />
		<br />
		
		<div class="container w-75 bg-light" id = "historia" align = "center">
			<p class = "text-justify">Em uma pequena cidadezinha, vive uma comunidade de cientistas dedicados ao cuidado e desenvolvimento de sua cidade, responsáveis por inúmeras invenções e pesquisas. Entretanto, eles não previram que suas descobertas seriam usadas para construção de grandes fábricas, que, consequentemente, geraram uma enorme poluição. <strong>Nos gases emitidos pelas fábricas, são liberados para a atmosfera óxidos de enxofre (SO₂ e SO₃) e óxidos de nitrogênio (NO₂), os quais reagem com o vapor de água produzindo ácido sulfúrico (H₂SO₄) e ácido nítrico (HNO₃). Esses ácidos, quando  diluídos na água da chuva, dão origem à chuva ácida, com pH ácido.</strong> A cidade possui poucos patrimônios, incluindo as estátuas dos dois fundadores da cidade, José de Souza e Maria da Silva, feitas de carbonato de cálcio (CaCO₃), localizadas na praça central. Agora, cabe aos cientistas protegerem as estátuas, descobrindo quem é o ácido, através de testes com papel indicador, para impedi-lo antes que ele destrua os dois maiores símbolos desta cidade.<br />Dentro desse contexto, se divirta com seus amigos para aprender um pouco mais sobre a chuva ácida e a teoria Ácido-Base!</p>
		</div>
		
		<br />
		
		<div class = "formulario" align = "center">
		
			<form action = "jogo.php" method = "get">
			
				<p class = "paragrafo"><strong>Crie ou encontre uma sala: </strong></p>
				<input type = "text" name = "nome_sala" placeholder = "Digite aqui..."/>
				<br />
				<br />
				<input type = "submit" id = "bt" class="btn btn-primary" onclick="location.href = 'jogo.php';" id="myButton" value = "Iniciar" />
			
			</form>
		
		</div>
	</body>
</html>
