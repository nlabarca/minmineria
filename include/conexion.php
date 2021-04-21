<?php
$server = 'sqlserver2008'; 
// Connect to MSSQL 
$connection = mssql_connect($server, 'ti', 'mineria123'); 
if (!$connection) { 
die('Something went wrong while connecting to MSSQL'); 
} 
mssql_select_db('bitacora_2021', $connection);

function encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}
function decrypt($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}
function dato_vehiculo($id) {
   global $connection;
    $sql="select * from vehiculo where idvehiculo=$id";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);
	return $row; 
}
function dato_conductor($id) {
	global $connection;
	$sql="select a.*, c.nombre as region, b.descripcion as programa, d.descripcion as licencia   
		from conductor a, programa b, region c, licencia d
		where a.idprograma=b.idprograma
		and a.idregion=c.idregion
		and a.idtipo_licencia=d.idtipo_licencia
		and a.idconductor='$id'";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);
	return $row; 	
}
function dato_tarjeta($id) {
	global $connection;
	$sql="select * from tarjeta_combustible	where num_tarjeta='$id'";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);
	return $row; 	
}
function dato_mantencion($id) {
	global $connection;
	$sql="select * from mantenciones where idmantencion='$id'";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);
	return $row; 	
}
function mes($id) {
	if($id==1) $mes="Enero";	
	if($id==2) $mes="Febrero";	
	if($id==3) $mes="Marzo";	
	if($id==4) $mes="Abril";	
	if($id==5) $mes="Mayo";	
	if($id==6) $mes="Junio";	
	if($id==7) $mes="Julio";	
	if($id==8) $mes="Agosto";	
	if($id==9) $mes="Septiembre";	
	if($id==10) $mes="Octubre";	
	if($id==11) $mes="Noviembre";	
	if($id==12) $mes="Diciembre";	
	return $mes; 
}
function estado($id) {
	if($id==1) $estado="En Proceso";	
	if($id==2) $estado="Enviado";	
	if($id==3) $estado="Aprobado";	
	if($id==4) $estado="Rechazado";	
	return $estado; 
}
function menu($id, $perfil){
	global $connection;
	$sql="select * from menu where id=$id and perfil like '%{$perfil}%'";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_num_rows($rs);	
	return $row; 		
}
function cantidad_vehiculo($perfil, $region) {
   global $connection;
	if($perfil==1){
		$sql="select count(*) as total from vehiculo where idestado=1";
	}else{
    	$sql="select count(*) as total from vehiculo where idestado=1 and idregion=$region";
	}
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);
	$total=$row['total']; 
	return $total; 
}
function cantidad_conductor($perfil, $region) {
   global $connection;
	if($perfil==1){
		$sql="select count(*) as total from conductor where idestado=1";
	}else{
    	$sql="select count(*) as total from conductor where idestado=1 and idregion=$region";
	}
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);
	$total=$row['total']; 
	return $total; 
}
?>