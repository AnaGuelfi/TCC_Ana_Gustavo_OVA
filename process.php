<?php
    $num_jogadores = 4;
    $function = $_POST['function'];
	$jogador_protegido = '';
	$papel = '';
	$contador = 0;
    $arquivo_jogo = '';
    $log = array();

    switch($function) {

		// função com as lógicas jogo
		case('mt'):
			$arquivo_jogo = "jogos\\" .$_POST['jid'].".json";
			//Recebe a jogada via post e executa a logica
			$idj = $_POST['turn_id'];
			$jogador_escolhido = $_POST['jogador_escolhido'];

			// Acessar o arquivo do Jogo
			$jogo = json_decode(file_get_contents($arquivo_jogo));
			$jogadores = $jogo->jogadores;
			
			// Gerar nova curiosidade
			$curiosidade = json_decode(file_get_contents('curiosidades.json'));
			$informacao = $curiosidade->curiosidades;
			shuffle($informacao);
			for($i=0;$i<count($jogadores);$i++) {
				$jogo->jogadores[$i]->curiosidade = $informacao[$i]->informacao;
			}
			
			// Jogo
			if($jogo->jogadores[$jogo->vez]->id == $idj){
				$papel = $jogo->jogadores[$jogo->vez]->id_personagem;
				if($jogo->vez != ($num_jogadores - 1)){
					// Executar a jogada
					$mensagem = '';
					switch($papel){
						case ("1"):

							foreach ( $jogadores as $j ){
								if ($j->id == $jogador_escolhido) {
									$j->estado = 1;
									$personagem_eliminado = $j->personagem;
									$mensagem = "<p'>Muito bem, Ácido Nítrico (HNO₃)! Você eliminou o $personagem_eliminado!</p>";
								}
							}

						break;
						case ("2"):

							$mensagem = "<p>A Estátua Fundador José de Souza (CaCO₃) é um patriôminio muito importante para a cidade, mas ainda está sujeita aos efeitos do Ácido Nítrico (HNO₃)! Torça pelos cientistas!</p>";

						break;
						case ("3"):

							$mensagem = "<p>A Estátua Fundadora Maria da Silva (CaCO₃) é um patriôminio muito importante para a cidade, mas ainda está sujeita aos efeitos do Ácido Nítrico (HNO₃)! Torça pelos cientistas!</p>";

						break;
						case ("4"):

							foreach ( $jogadores as $j ){
								if ($j->id == $jogador_escolhido) {
									if ($j->id_personagem == "1"){
										$j->estado = 1;
										$jogo->fim = 1;
										$jogo->fim1 = 1;
										$mensagem = "<p>Você identificou o Ácido Nítrico (HNO₃)! Parabéns!</p>";
									} else {
										$mensagem = "<p>Esse jogador não causará danos à cidade!</p>";
									}
									
								}
							}
						break;
					}

					// Contar quantos já foram eliminados
					$jogadores = $jogo->jogadores;
					foreach ( $jogadores as $j ){
						if ($j->estado == 1) {
							$contador++;
							if ($contador == $num_jogadores-1) {
								$jogo->fim = 1;
								$jogo->fim2 = 1;
							}
						}
					}

					// Mudar a vez
					$jogo->vez = $jogo->vez + 1;

				}else{
					$jogo->vez = 0;
					$jogo->turno = $jogo->turno+1;
				}

				$jogoJSON = json_encode($jogo);
				file_put_contents($arquivo_jogo, $jogoJSON, LOCK_EX);
			}

			$log = $mensagem;

        break;
		
		// função que registra os jogadores
		case('register'):

		$arquivo_jogo = "jogos\\" .$_POST['jid'].".json";
			//registra o arquivo do jogo
			if(!file_exists($arquivo_jogo)){
				$jogo->jogadores = array();
				$jogo->vez = -1;
				$jogo->turno = -1;
				$jogo->inicio = 0;//0 não iniciado - 1 iniciado
				$jogo->fim = 0;//0 não finalizado - 1 finalizado
				$jogo->fim1 = 0;//0 não finalizado - 1 finalizado -> caso o investigador ganhe
				$jogo->fim2 = 0;//0 não finalizado - 1 finalizado -> caso o impostor ganhe
				$jogoJSON = json_encode($jogo);
				file_put_contents($arquivo_jogo, $jogoJSON, LOCK_EX);
			}

			//verifica se o numero de jogadores é menor do que o esperado
			//numero de jogadores é contado pelo o array
			$jogo = json_decode(file_get_contents($arquivo_jogo));
			if (count($jogo->jogadores)<$num_jogadores) {
				// se tiver espaço na sala, registra o jogador
				$jogador->id = $_POST['id'];
				$jogador->nome = $_POST['user'];
				// 0 = vivo; 1 = morto
				$jogador->estado = 0;
				array_push($jogo->jogadores, $jogador);
				$jogoJSON = json_encode($jogo);
				file_put_contents($arquivo_jogo, $jogoJSON, LOCK_EX);
			} else {
				$log = 2;
			}

			//se numero de jogadores igual ao esperado inicia o jogo
			if (count($jogo->jogadores)==$num_jogadores) {
				
				//Definir ordem aleatória para os jogadores
				shuffle($jogo->jogadores);
				
				//Receber papéis em ordem aleatória
				$papel = json_decode(file_get_contents('papeis.json'));
				$personagens = $papel->personagens;
				shuffle($personagens);
				
				//Receber curiosidades em ordem aleatória
				$curiosidade = json_decode(file_get_contents('curiosidades.json'));
				$informacao = $curiosidade->curiosidades;
				shuffle($informacao);
				
				//Atribuir personagens e curiosidades para os jogadores
				for($i=0;$i<count($jogo->jogadores);$i++) {
					$jogo->jogadores[$i]->id_personagem = $personagens[$i]->identificador;
					$jogo->jogadores[$i]->personagem = $personagens[$i]->nome;
					$jogo->jogadores[$i]->funcao_personagem = $personagens[$i]->funcao;
					$jogo->jogadores[$i]->curiosidade = $informacao[$i]->informacao;
				}
				
				// Iniciar o jogo
				$jogo->vez = 1;
				$jogo->turno = 1;
				$jogo->inicio = 1;
				$jogoJSON = json_encode($jogo);
				file_put_contents($arquivo_jogo, $jogoJSON, LOCK_EX);
			}

		break;

		// função que pega o turno do jogo
		case('getTurn'):
			$arquivo_jogo = "jogos\\" .$_POST['jid'].".json";
			$jogo = json_decode(file_get_contents($arquivo_jogo));
			// Pegar o jogador atual
			$jogo->jogadoratual = $jogo->jogadores[$jogo->vez]->id;
			$log = $jogo;
			
		break;

    }

    echo json_encode($log);

?>
