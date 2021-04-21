
<?php

#################
### Framework ###
#################
############################################################################

function base64_picture($path){
	$fichero = $path;
	if($fp = fopen($fichero,"rb", 0))
	{
	   $imagen = fread($fp,filesize($fichero));
	   fclose($fp);
	   // devuelve datos cifrados en base64
	   //  formatear $imagen usando la semántica del RFC 2045
	 
	   $base64 = chunk_split(base64_encode($imagen));
	   echo '
	   <img src="data:image/png;base64,' . $base64 .'" alt="Texto alternativo" width="100" height="100" />';
	   
	   echo $base64;
	}
}



function mmineria_f_data_type($data){
	if(is_string($data)){
		$result = 'String';
	}
	elseif(is_array($data)){
		$result = 'Array';
	}
	
	return $result;
}

function mmineria_f_message($data){

	#print_r($data);

	if(mmineria_f_data_type($data) == 'String'){
		
	}
	elseif(mmineria_f_data_type($data) == 'Array'){
		if(count($data) > 0){
			
			switch ($data['status'][0]) {
				case 'ok':
					
					if($data['status'][1] == 'icon'){
						$icon = '
						<img src="data:image/png;base64,
						iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0 U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAKfSURBVDjLpZPrS1NhHMf9O3bOdmwDCWRE IYKEUHsVJBI7mg3FvCxL09290jZj2EyLMnJexkgpLbPUanNOberU5taUMnHZUULMvelCtWF0sW/n 7MVMEiN64AsPD8/n83uucQDi/id/DBT4Dolypw/qsz0pTMbj/WHpiDgsdSUyUmeiPt2+V7SrIM+b Sss8ySGdR4abQQv6lrui6VxsRonrGCS9VEjSQ9E7CtiqdOZ4UuTqnBHO1X7YXl6Daa4yGq7vWO1D 40wVDtj4kWQbn94myPGkCDPdSesczE2sCZShwl8CzcwZ6NiUs6n2nYX99T1cnKqA2EKui6+TwphA 5k4yqMayopU5mANV3lNQTBdCMVUA9VQh3GuDMHiVcLCS3J4jSLhCGmKCjBEx0xlshjXYhApfMZRP 5CyYD+UkG08+xt+4wLVQZA1tzxthm2tEfD3JxARH7QkbD1ZuozaggdZbxK5kAIsf5qGaKMTY2lAU /rH5HW3PLsEwUYy+YCcERmIjJpDcpzb6l7th9KtQ69fi09ePUej9l7cx2DJbD7UrG3r3afQHOyCo +V3QQzE35pvQvnAZukk5zL5qRL59jsKbPzdheXoBZc4saFhBS6AO7V4zqCpiawuptwQG+UAa7Ct3 UT0hh9p9EnXT5Vh6t4C22QaUDh6HwnECOmcO7K+6kW49DKqS2DrEZCtfuI+9GrNHg4fMHVSO5kE7 nAPVkAxKBxcOzsajpS4Yh4ohUPPWKTUh3PaQEptIOr6BiJjcZXCwktaAGfrRIpwblqOV3YKdhfXO IvBLeREWpnd8ynsaSJoyESFphwTtfjN6X1jRO2+FxWtCWksqBApeiFIR9K6fiTpPiigDoadqCEag 5YUFKl6Yrciw0VOlhOivv/Ff8wtn0KzlebrUYwAAAABJRU5ErkJggg==
						" />';
					}
				
					echo '
					<div style="
					margin: 10px 20px 10px 20px;
					margin-top: 10px;
					margin-right: 20px;
					margin-bottom: 10px;
					margin-left: 20px;
					padding: 8px;
					padding-top: 8px;
					padding-right: 8px;
					padding-bottom: 8px;
					padding-left: 8px;
					border: 1px solid #DDD;
					border-top-width: 1px;
					border-right-width: 1px;
					border-bottom-width: 1px;
					border-left-width: 1px;
					border-top-style: solid;
					border-right-style: solid;
					border-bottom-style: solid;
					border-left-style: solid;
					border-top-color: #DDD;
					border-right-color: #DDD;
					border-bottom-color: #DDD;
					border-left-color: #DDD;
					background-color: #F0F0F0;
					font-size: 11pt;
					clear: both;
					border-image: initial;" >
					<b>Vídeo:</b> Todo el proceso de creación de .
					</div>';
					
					
					
					
					break;
				case 'error':
				
					if($data['status'][1] == 'icon'){
						$icon = '
						<img src="data:image/png;base64,
						iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0 U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJPSURBVDjLpZPLS5RhFMYfv9QJlelTQZwR b2OKlKuINuHGLlBEBEOLxAu46oL0F0QQFdWizUCrWnjBaDHgThCMoiKkhUONTqmjmDp2GZ0UnWbm fc/ztrC+GbM2dXbv4ZzfeQ7vefKMMfifyP89IbevNNCYdkN2kawkCZKfSPZTOGTf6Y/m1uflKlC3 LvsNTWArr9BT2LAf+W73dn5jHclIBFZyfYWU3or7T4K7AJmbl/yG7EtX1BQXNTVCYgtgbAEAYHlq YHlrsTEVQWr63RZFuqsfDAcdQPrGRR/JF5nKGm9xUxMyr0YBAEXXHgIANq/3ADQobD2J9fAkNiMT MSFb9z8ambMAQER3JC1XttkYGGZXoyZEGyTHRuBuPgBTUu7VSnUAgAUAWutOV2MjZGkehgYUA6O5 A0AlkAyRnotiX3MLlFKduYCqAtuGXpyH0XQmOj+TIURt51OzURTYZdBKV2UBSsOIcRp/TVTT4ewK 6idECAihtUKOArWcjq/B8tQ6UkUR31+OYXP4sTOdisivrkMyHodWejlXwcC38Fvs8dY5xaIId89V lJy7ACpCNCFCuOp8+BJ6A631gANQSg1mVmOxxGQYRW2nHMha4B5WA3chsv22T5/B13AIicWZmNZ6 cMchTXUe81Okzz54pLi0uQWp+TmkZqMwxsBV74Or3od4OISPr0e3SHa3PX0f3HXKofNH/UIG9pZ5 PeUth+CyS2EMkEqs4fPEOBJLsyske48/+xD8oxcAYPzs4QaS7RR2kbLTTOTQieczfzfTv8QPldGv TGoF6/8AAAAASUVORK5CYII= 
						" />';
					}
					
					echo '
					<div style="
					color: #E52B31;
					margin: 10px 20px 10px 20px;
					margin-top: 10px;
					margin-right: 20px;
					margin-bottom: 10px;
					margin-left: 20px;
					padding: 8px;
					border: 1px solid #E52B31;
					background-color: #FAD5D6;
					font-size: 10.2pt;
					clear: both;
					border-image: initial;" >
					<b>
					'.$icon,$data['message'][0].'</b>
					</div>';
					break;
				case 'comment':
					
					if($data['status'][1] == 'icon'){
						$icon = '
						<img src="data:image/png;base64,
						iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0 U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAADoSURBVBgZBcExblNBGAbA2ceegTRBuIKO giihSZNTcC5LUHAihNJR0kGKCDcYJY6D3/77MdOinTvzAgCw8ysThIvn/VojIyMjIyPP+bS1sUQI V2s95pBDDvmbP/mdkft83tpYguZq5Jh/OeaYh+yzy8hTHvNlaxNNczm+la9OTlar1UdA/+C2A4tr RCnD3jS8BB1obq2Gk6GU6QbQAS4BUaYSQAf4bhhKKTFdAzrAOwAxEUAH+KEM01SY3gM6wBsEAQB0 gJ+maZoC3gI6iPYaAIBJsiRmHU0AALOeFC3aK2cWAACUXe7+AwO0lc9eTHYTAAAAAElFTkSuQmCC 
						" />';
					}
				
					echo '
					<div style="
					color: #6E6E6E;
					margin: 10px 20px 10px 20px;
					margin-top: 10px;
					margin-right: 20px;
					margin-bottom: 10px;
					margin-left: 20px;
					padding: 8px;
					border: 1px solid #DDD;
					background-color: #F0F0F0;
					font-size: 10.2pt;
					clear: both;
					border-image: initial;" >
					<b>
					'.$icon,$data['message'][0].'</b>
					</div>';
					break;
				default:
				   echo "i no es igual a 0, 1 ni 2";
			}
			
		}
	}
		


	return $result;
}

############################################################################

#################
### Databases ###
#################
############################################################################

function mmineria_f_connection_db($data){
	if(mmineria_f_data_type($data) == 'String'){
		if($data == '?'){
			mmineria_f_message(
			array(
				'status' => array('error', 'icon'), 
				'message' => array('Manual de Uso: ')
				)
			);
		}
	}
	elseif(mmineria_f_data_type($data) == 'Array'){
		if(count($data) > 0){
			switch ($data['sgbd'][0]) {
				case 'mysql':
					$connection_sgbd = @mysql_connect($data['host'][0].':'.$data['port'][0], $data['user'][0], $data['pass'][0]) 
					or die(mmineria_f_message(array(
							'status' => array('error', 'icon'),
							'message' => array(mysql_error())
							)));
					
					if($connection_sgbd){
						$result = $connection_sgbd;
					}
					
					break;
				case 'mssql':

					# .','.$data['port'][0]
//print_r($data);
					$connection_sgbd = @mssql_connect($data['host'][0], $data['user'][0], $data['pass'][0])
					or die(mmineria_f_message(array(
							'status' => array('error', 'icon'),
							'message' => array(mssql_get_last_message())
							)));
					
					if($connection_sgbd){
						$result = $connection_sgbd;
					}
					
					break;
				default:
				   echo "El SGBD ingresado no es valido para su coneccion.";
			}
			
			#$data['host'][0];
		}
		else{
		$error = 
			array(
				'status' => array('error', 'icon'), 
				'message' => array('No se han ingresado correctamente los parametros a la funcion.')
				);
				
			mmineria_f_message($error);
		}
	}
	
	return $result;
}


############################################################################



/*
echo "Pruebas...<br><br>";

$array = 
array(
	'host' => array('172.16.70.3'),
	'port' => array('3306'),
	'user' => array('sa'),
	'pass' => array('mmineria'),
	'sgbd' => array('mssql')
);


mmineria_f_connection_db($array);
*/

#base64_picture('date.png');


?>


