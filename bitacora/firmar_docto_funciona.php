<?php

## DATOS QUE DEBEN SER CREADOS DE FORMA DINAMICA, SOLO ESTAN PARA EFECTOS DE PRUEBAS ##
## Este es el rut del firmante, se debe cambiar por un valor dinamico al momento de implementar en un ambiente productivo ##
$run="15777000";
## Este es el valor del OTP al momento de enviar la segunda llamada. Debe ser reemplazado de forma dinamica cuando se quiera firmar ##
$otp =$_GET['otp'];

/*

$file_add=$_FILES['file']['name'];
$tipo=$_FILES['file']['type'];
$ext = end(explode('.',$file));

*/
//$archivo1=$file;
$file_add="doctos/13.pdf";

/*
if (is_uploaded_file($_FILES['file']['tmp_name'])) { 

		copy($_FILES['file']['tmp_name'], $_FILES['file']['name']); 
		
}
*/

## SIMULACIÓN DE ARCHIVO A FIRMAR -> DEBE CAMBIARSE EN ENTORNO PRODUCTIVO DE FORMA DINAMICA ##
//obtiene archivo
//$file1 = file_get_contents("http://www.sii.cl/normativa_legislacion/resoluciones/2017/reso61.pdf");

$file1 = file_get_contents($file_add);
//$file = file_put_contents("Tmpfile.pdf", fopen("http://www.sii.cl/normativa_legislacion/resoluciones/2017/reso61.pdf", 'r'));
$file = file_put_contents("Tmpfile.pdf", fopen($file_add, 'r'));
$fileName = "Tmpfile.pdf";


## DATOS ESTATICOS. VARIABLES GLOBALES ##
//Base Path para API Firma Segpres
$urlFirmaSegpres = 'https://apis.digital.gob.cl/firma-prod/v1/files/tickets';
$entity = 'Subsecretaría de Minería';
$purpose = 'Propósito General';
$secret = 'b1891112ea194c40b46447664072d7fd';
$expiration = date('Y-m-d\TH:i:s');
$api_token_key = '64661296-23ca-4b5d-9dfd-0fc8cc5a485e';


## GENERACIÓN DE VALORES PARA PRIMERA LLAMADA -> SON LOS CAMPOS CONTENT Y CHECKSUM ##
$data = base64_encode($file1);
$sha256 = hash_file('sha256', $fileName);


## SECUENCIA DE EJECUCIÓN DE FUNCIONES PARA FIRMAR UN ARCHIVO ##
//Generación de Token Json
$jwt = crearTokenJson($entity, $run, $expiration, $purpose, $secret);
//Generación de Json que se envia en la primera llamada
$jsonPrimeraLlamada = creaJsonPrimeraLlamada($data,$sha256,$api_token_key,$jwt);
//Guarda el resultado de la primera llamada en un arreglo
$resultadoPrimeraLlamada = json_decode(primeraLlamada('POST',$urlFirmaSegpres, $jsonPrimeraLlamada));
//rescata del arreglo el valor del session token que se requiere para la segunda llamada
$session_token = $resultadoPrimeraLlamada->{'session_token'};
//Guarda el resultado de la segunda llamada
$resultado_firma = segundaLlamada($urlFirmaSegpres,$session_token,$otp);
//Imprime el resultado de la segunda llamada
//echo $resultado_firma;

$resultado=json_decode($resultado_firma, true);
//var_dump($resultado);

//$resultado["files"][0]['status'];
$archivo=$resultado["files"][0]['content'];
//$datas=base64_decode($resultado["files"][0]['content']);


//$checksum_signed=$resultado["files"][0]['checksum_signed'];


//header('Content-Type: application/pdf');
//echo $datas;


/*$decoded = base64_decode($archivo);
$file = "docto_firmado.pdf";
file_put_contents($file, $decoded);

if (file_exists($file)) {
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".basename($file));
header("Expires: 0");
header("Cache-Control: must-revalidate");
header("Pragma: public");
header("Content-Length: " . filesize($file));
readfile($file);
exit;
}*/




//we give the file a random name
$name    = $file_add;

//a route is created, (it must already be created in its repository(pdf)).
$rute    = $name;

//decode base64
$pdf_b64 = base64_decode($archivo);

//you record the file in existing folder
if(file_put_contents($rute, $pdf_b64)){
    //just to force download by the browser
    header("Content-type: application/pdf");

    //print base64 decoded
    echo $pdf_b64;
}



## METODO QUE CREA EL JSON WEB TOKEN ##
function crearTokenJson($entity, $run, $expiration, $purpose, $secret){
    $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
    $payload = json_encode(['entity' => $entity, 'run' => $run, 'expiration' => $expiration,'purpose' => $purpose ]);
    $base64UrlHeader = base64_encode($header);
    $base64UrlPayload  = base64_encode($payload);
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
    $base64UrlSignature = base64_encode($signature);
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    return $jwt;
}

## METODO QUE CREA EL JSON QUE SE ENVIA EN LA PRIMERA LLAMADA ##
function creaJsonPrimeraLlamada($data,$sha256,$api_token_key,$jwt){
    $contentType = 'application/pdf';
    $content = $data;
    $description = 'description';
    $checksum = $sha256;
    $files = json_encode(['content-type' => $contentType, 'content' => $content, 'description' => $description, 'checksum' => $checksum]);
    $myArray = array('content-type' => $contentType, 'content' => $content, 'description' => $description, 'checksum' => $checksum);
    $jsonPrimeraLlamada = json_encode(['api_token_key' => $api_token_key, 'token' => $jwt, 'files' => array($myArray)]);
    return $jsonPrimeraLlamada;
}

## METODO QUE EJECUTA LA PRIMERA LLAMADA ##
function primeraLlamada($method, $urlFirmaSegpres, $jsonPrimeraLlamada){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonPrimeraLlamada);
    curl_setopt($curl, CURLOPT_URL, $urlFirmaSegpres);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
        ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $result = curl_exec($curl);
    //var_dump($result);
    if(!$result){die("Error de Conexión");}
    curl_close($curl);
    return $result;
 }

## METODO QUE EJECUTA LA SEGUNDA LLAMADA ##
function segundaLlamada($urlFirmaSegpres,$session_token, $otp){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $urlFirmaSegpres.'/'.$session_token);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'OTP: '.$otp,
     ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $result = curl_exec($curl);
    if(!$result){die("Error de Conexión");}
    curl_close($curl);
    //var_dump($result);
    return $result;
    }
?>
