<?php 
session_start();  
include ("../include/conexion.php");
//print_r($_POST);
$_SESSION['status']="";

$id=$_GET['id'];

$sql="select idtarjeta, num_tarjeta, monto_inicial, fecha_vencimiento, b.descripcion as programa, responsable, a.idregion, c.nombre as region, a.saldo_tarjeta, a.idtipo_tarjeta 
from tarjeta_combustible a, programa b, region c 
where num_tarjeta=$id
and a.idprograma=b.idprograma
and a.idregion=c.idregion";
$rs = mssql_query ($sql,$connection);
$row=mssql_fetch_array($rs);

$date = date_create($row['fecha_vencimiento']);
$fvencimiento=date_format($date, 'd-m-Y');

echo $row['num_tarjeta']."|".$row['monto_inicial']."|".$fvencimiento."|".utf8_encode($row['region'])."|".utf8_encode($row['programa'])."|".$row['responsable']."|".$row['idregion']."|".$row['idtarjeta']."|".number_format($row['saldo_tarjeta'], 0, ',', '.')."|".$row['idtipo_tarjeta'];

mssql_close($connection);


?>