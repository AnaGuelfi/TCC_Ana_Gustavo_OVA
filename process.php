<?php

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
			$arquivo = "participantes.txt";
	
			$handle = fopen($arquivo, 'r+');
			
			$data = fread($handle, 512);
			
			$participantes = $data;
			if ($participantes<5) {
				// se tiver espaço na sala, registra o jogador
				$user = $_POST['user'];
				$id = $_POST['id'];
				fwrite(fopen('user.txt', 'a'),$user.';'.$id."\n" );
				
				$participantes = $participantes + 1;
				
			} else {
				// se não tiver espaço na sala
				$data = 1;
			}
			
			fseek($handle, 0);
			
			fwrite($handle, $participantes);
			
			fclose($handle);
			
         break;
		
		 case('sala_cheia'):
			$log = "V";
		 break;
		
         case('getTurn'):
          //toda sua logica
		  // trazer o último jogador registrado
			$lines=array();
			$fp = fopen("user.txt", "r");
			while(!feof($fp)){
			   $line = fgets($fp, 4096);
			   array_Push($lines, $line);
			   if (count($lines)>1){
				   $log['text']=array_shift($lines);
			   }
			}
			fclose($fp);
         break;
    }


    echo json_encode($log);

?>
