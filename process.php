<?php
    $num_jogadores = 3;
    $function = $_POST['function'];

    $log = array();

    switch($function) {

		case('mt'):
			//recebe a jogada via post e executa a logica
			$idj = $_POST['turn_id'];
			$jogador_escolhido = $_POST['jogador_escolhido'];

			$jogo = json_decode(file_get_contents('jogo.json'));
			$jogadores = $jogo->jogadores;
			//lógica
			//$jogo->jogadores[$jogo->vez]->papel;

			// foreach ( $jogadores as $j ){
			// 	if ($j == $jogador_escolhido){
			// 		unset($j);
			// 	}
			// }

			if($jogo->jogadores[$jogo->vez]->id == $idj){
				if($jogo->vez != ($num_jogadores - 1)){

					$jogo->vez = $jogo->vez + 1;
          //remove
          //$jogo->jogadores = array_splice($jogadores ,(count($jogadores)-1),1);
				}else{
					$jogo->vez = 0;
					$jogo->turno = $jogo->turno+1;
				}
				$jogoJSON = json_encode($jogo);
				file_put_contents("jogo.json", $jogoJSON, LOCK_EX);
			}

			$log = $jogador_escolhido;

        break;

		case('register'):
			//registra o arquivo do jogo
			if(!file_exists("jogo.json")){
				$jogo->jogadores = array();
				$jogo->vez = -1;
				$jogo->turno = -1;
				$jogo->inicio = 0;//0 não iniciado - 1 iniciado
				$jogoJSON = json_encode($jogo);
				file_put_contents("jogo.json", $jogoJSON, LOCK_EX);
			}

			//verifica se o numero de jogadores é menor do que o esperado
			//numero de jogadores é contado pelo o array
			$jogo = json_decode(file_get_contents('jogo.json'));
			if (count($jogo->jogadores)<$num_jogadores) {
				// se tiver espaço na sala, registra o jogador
				$jogador->id = $_POST['id'];
				$jogador->nome = $_POST['user'];
			//$jogador->vivo = 'S'
				array_push($jogo->jogadores, $jogador);
				$jogoJSON = json_encode($jogo);
				file_put_contents("jogo.json", $jogoJSON, LOCK_EX);
			}

			//se numero de jogadores igual ao esperado inicia o jogo
			if (count($jogo->jogadores)==$num_jogadores) {
				
				shuffle($jogo->jogadores);
				
				$papel = json_decode(file_get_contents('papeis.json'));
				$personagens = $papel->personagens;
				shuffle($personagens);
				for($i=0;$i<count($jogo->jogadores);$i++) {
				  $jogo->jogadores[$i]->papel = $personagens[$i]->nome;
				}
				$jogo->vez = 1;
				$jogo->turno = 1;
				$jogo->inicio = 1;
				$jogoJSON = json_encode($jogo);
				file_put_contents("jogo.json", $jogoJSON, LOCK_EX);
			}

			$log = $_POST['user'];

		break;

		case('getTurn'):
			$jogo = json_decode(file_get_contents('jogo.json'));
			$jogo->jogadoratual = $jogo->jogadores[$jogo->vez]->id;
			$log = $jogo;
		break;

    }

    echo json_encode($log);

?>
