<?php
$ipgestor="http://172.16.90.126:5050";
$usuario="nlabarca";
$pass="Cuervo83*";

//Creación de expediente
		
/*$url = $ipgestor."/docux-api-services/services/ecm/";
$jsonData = array(
    'user' => $usuario,
    'password' => $pass
);
    $content = json_encode($jsonData);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

    $json_response = curl_exec($curl);

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ( $status != 200 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }


    curl_close($curl);

    $response = json_decode($json_response, true);
    var_dump($response);
    $idFlow=$response['result']['idFlow'];
    $tracingId=$response['result']['tracingId'];
    $taskId=$response['result']['taskId'];*/

// fin Creación de expediente


//cargar documento 

$archivo="hoja_ruta1.pdf";
$fp = fopen($archivo, "r");
$contents = fread($fp, filesize($archivo));
$filename=$archivo;
			
$tracingId="SIN-INF-494-2019";
$idFlow=3613;
$taskId=5202;

			
$url = $ipgestor."/docux-api-services/services/ecm/addDocument";  // sube docto
//$url = $ipgestor."/docux-api-services/services/ecm/uploadDocument";  //actualiza docto
$_POST["fileName"] = $filename;


$headers = array("Content-Type:multipart/form-data"); 


/*$postfields  = array('user' => $usuario, 'password' => $pass, 'idFlow' =>$idFlow , 
'taskId'=>$taskId, 'documentMatter'=>'demo2' ,'documentType'=>44, 
'origin'=>1,'introductionRelease'=>'1', 'destinationOrgan'=>'no aplica', 'emitterOrgan'=>'no aplica', 
'file'=> $contents,'fileName'=>$filename, 'idTracing'=>$tracingId);*/

$postfields  = array('user' => $usuario, 'password' => $pass, 'idFlow' =>$idFlow, 
'taskId'=>$taskId, 'documentMatter'=>'demo2' ,'documentType'=>44, 
'origin'=>1,'introductionRelease'=>'1', 'destinationOrgan'=>'no aplica', 'emitterOrgan'=>'no aplica', 
'documentNumber'=>'1', 'documentYear'=>'2019', 'file'=> $contents,'fileName'=>$filename, 'idTracing'=>$tracingId);


$ch = curl_init();
$options = array(
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => $postfields,
    CURLOPT_INFILESIZE => $filesize,  //comento esta linea para servicio de actualizar docto
    CURLOPT_RETURNTRANSFER => true
); 
curl_setopt_array($ch, $options);
$response2=curl_exec($ch);


if(!curl_errno($ch))
{
    $info = curl_getinfo($ch);
    if ($info['http_code'] == 200)
        $errmsg = "Documento subido correctamente";
}
else
{
    $errmsg = curl_error($ch);
}
curl_close($ch);
$response2a = json_decode($response2, true);
var_dump($response2a);
/*echo "<br>";
echo "->".$uuid=$response2a['result']['uuid'];*/
$uuid=$response2a['result']['uuid'];
// fin cargar documento



$rut=15425669;	
	  
$url_call = $ipgestor."/docux-api-services/services/signature/first_call";    
$content= " {\"user\":\"$usuario\",\"password\":\"$pass\",\"userRut\":\"$rut\",\"files\":[{\"uuid\":\"$uuid\",\"docType\":\"9\"}]}";		

$curl = curl_init($url_call);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Content-type: application/json"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 200 ) {
    die("Error: call to URL $url_call failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}
curl_close($curl);

$response_first_call=json_decode($json_response, true);
$sessionToken=$response_first_call['result']['sessionToken'];
echo "<br>sessionToken=>".$sessionToken;






?>