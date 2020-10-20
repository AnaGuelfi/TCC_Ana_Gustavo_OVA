<?php
    $num_jogadores = 4;
    $function = $_POST['function'];

    $log = array();

    switch($function) {
    	 case('getState'):
        	 if(file_exists('chat.txt')){
               $lines = file('chat.txt');
        	 }
             $log['state'] = count($lines);
        	 break;

    	 case('update'):
        	$state = $_POST['state'];
        	if(file_exists('chat.txt')){
        	   $lines = file('chat.txt');
        	 }
        	 $count =  count($lines);
        	 if($state == $count){
        		 $log['state'] = $state;
        		 $log['text'] = false;

        		 }
        		 else{
        			 $text= array();
        			 $log['state'] = $state + count($lines) - $state;
        			 foreach ($lines as $line_num => $line)
                       {
        				   if($line_num >= $state){
                         $text[] =  $line = str_replace("\n", "", $line);
        				   }
                      }
        			 $log['text'] = $text;
        		 }

             break;

    	 case('send'):
		  $nickname = htmlentities(strip_tags($_POST['nickname']));
			 $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			  $message = htmlentities(strip_tags($_POST['message']));
		 if(($message) != "\n"){

			 if(preg_match($reg_exUrl, $message, $url)) {
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
				}
        	 fwrite(fopen('chat.txt', 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n");
		 }


     break;

      case('register'):
      //registra o arquivo do jogo
      if(!file_exists("jogo.json")){
        $jogo->jogadores = array();
        $jogo->vez = -1;
        $jogo->turno = -1;
        $jogo->inicio = 0;//0 não iniciado - 1 iniciado
        $jogoJSON = json_encode($jogo);
        file_put_contents("jogo.json", $jogoJSON);
      }

      //verifica se o numero de jogadores é menor do que o esperado
      //numero de jogadores é contado pelo o array
			$jogo = json_decode(file_get_contents('jogo.json'));
			if (count($jogo->jogadores)<$num_jogadores) {
				// se tiver espaço na sala, registra o jogador
				$jogador->id = $_POST['id'];
				$jogador->nome = $_POST['user'];
				array_push($jogo->jogadores, $jogador);
				$jogoJSON = json_encode($jogo);
				file_put_contents("jogo.json", $jogoJSON);
			}

      //se numero de jogadores igual ao esperado inicia o jogo
		  if (count($jogo->jogadores)==$num_jogadores) {
			//$jogo = json_decode(file_get_contents('jogo.json'));
			shuffle($jogo->jogadores);
			$jogo->vez = 1;
			$jogo->turno = 1;
			$jogo->inicio = 1;
			$jogoJSON = json_encode($jogo);
			file_put_contents("jogo.json", $jogoJSON);
		  }

      break;

		 case('sala_cheia'):
			$log = "V";
		 break;

     case('getTurn'):
      $jogo = json_decode(file_get_contents('jogo.json'));
      $jogo->jogadoratual = $jogo->jogadores[$jogo->vez]->id;
     //  if ($jogo->inicio == 0){
     //   $log['text']="Aguardando para iniciar o jogo - " . count($jogo->jogadores) . "/4 participantes";
     // }else{
     //   $jogador = $jogo->jogadores[$jogo->vez];
     //   $log['text']="Jogo iniciado é a vez de ". $jogador->nome . " | ".$jogador->id;
     // }

      $log = $jogo;
      break;
    }


    echo json_encode($log);

?>
