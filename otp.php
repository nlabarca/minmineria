<html>
<body onLoad="document.form1.otp.focus();">
<title>Ingreso de OTP</title>

<form id="form1" name="form1" method="post">
  <center><label for="otp">Ingreso de OTP:</label>
  </br>
  <input type="text" name="otp" id="otp">
  </center>
  </br>
  <input type="submit" name="submit" id="submit" value="Autorizar Firma" style="background-color:#22F26D; color:#FFFFFF">
  <input type="button" name="button" id="button" value="Cancelar" style="background-color:#AFAFAF; color:#FFFFFF" onClick="window.close()">
</form>
</body>
</html>
<?php
//segundo llamado para firmas
$sessionToken=$_GET['sesion'];
$user='nlabarca';


if ($_POST['otp']!="") {
$otp=$_POST['otp'];
$url_second='http://172.16.90.126:5050/docux-api-services/services/signature/second_call';
$jsonData_second = array(
						'sessionToken' => $sessionToken
						,'otp' => $otp
						,'user'=>$user
						);

$content_second = json_encode($jsonData_second);
 echo $content_second;

$curl = curl_init($url_second);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER,
array("Content-type: application/json"));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $content_second);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 200 ) {
	die("Error: call to URL $url_call failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}else{
	echo "<center>Firma OK</center>";	
}
curl_close($curl);

$response_first_call2=json_decode($json_response, true);
var_dump($response_first_call2);
   
}


?>
