<?php 
session_start();  
include ("../include/conexion.php");
//print_r($_POST);
$_SESSION['status']="";

$rut=$_GET['rut'];

$sql="select idconductor, rut, nombres, apellidos, cargo, c.nombre as region, b.descripcion as programa, d.descripcion as licencia, a.fvencimiento_licencia, a.idregion  
from conductor a, programa b, region c, licencia d
where a.idprograma=b.idprograma
and a.idregion=c.idregion
and a.idtipo_licencia=d.idtipo_licencia
and a.rut='$rut'";
$rs = mssql_query ($sql,$connection);
$row=mssql_fetch_array($rs);

$date = date_create($row['fvencimiento_licencia']);
$fvencimiento_licencia=date_format($date, 'd-m-Y');



echo utf8_encode($row['nombres'])."|".utf8_encode($row['apellidos'])."|".utf8_encode($row['cargo'])."|".utf8_encode($row['region'])."|".utf8_encode($row['programa'])."|".$row['licencia']."|".$fvencimiento_licencia."|".$row['idregion']."|".$row['idconductor'];

mssql_close($connection);


?>