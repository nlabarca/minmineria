<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";

$mes=$_POST['sel_mes'];
$anio=$_POST['sel_anio'];
$periodo=$_POST['sel_periodo'];
$idvehiculo=$_POST['sel_vehiculos'];
$idconductor=$_POST['sel_conductor'];
$num_tarjeta=$_POST['sel_tarjeta'];
$monto_combustible=str_replace(".", "", $_POST['txt_monto']);
$litros_combustible=$_POST['txt_combustible'];


$dia_finicio=substr($_POST['txt_finicio'], 0, 2);
$mes_finicio=substr($_POST['txt_finicio'], 3, 2);
$ano_finicio=substr($_POST['txt_finicio'], 6, 4);
$finicio_viaje 	= $ano_finicio."-".$mes_finicio."-".$dia_finicio;

$km_salida=$_POST['txt_km_salida']; 
$hora_salida=$_POST['txt_hora_salida'];
$lugar_inicio=$_POST['txt_lugar_inicio']; 

$dia_ftermino=substr($_POST['txt_ftermino'], 0, 2);
$mes_ftermino=substr($_POST['txt_ftermino'], 3, 2);
$ano_ftermino=substr($_POST['txt_ftermino'], 6, 4);
$ftermino_viaje= $ano_ftermino."-".$mes_ftermino."-".$dia_ftermino;

$km_llegada=$_POST['txt_km_llegada']; 
$hora_llegada=$_POST['txt_hora_llegada'];
$lugar_termino=$_POST['txt_lugar_termino']; 
$detalles_recorrido=$_POST['txta_detalle']; 
$num_pasajeros=$_POST['sel_pasajeros']; 


$sql_idtarjeta="select idtarjeta, saldo_tarjeta from tarjeta_combustible where num_tarjeta=$num_tarjeta";
$rs_idtarjeta = mssql_query ($sql_idtarjeta,$connection);	
$row_idtarjeta=mssql_fetch_array($rs_idtarjeta);
$idtarjeta=$row_idtarjeta['idtarjeta'];
$saldo_tarjeta=$row_idtarjeta['saldo_tarjeta'];

$sql_idbitacora="select max(idbitacora) as idbitacora from bitacora";
$rs_idbitacora = mssql_query ($sql_idbitacora,$connection);	
$row_idbitacora=mssql_fetch_array($rs_idbitacora);
$idbitacora=$row_idbitacora['idbitacora']+1;


if($num_pasajeros==""){
	$num_pasajeros="null";
}

mssql_query("BEGIN TRAN");	

$sql_folio_bitacora="select * from bitacora_mensual where mes=$mes and anio=$anio and periodo=$periodo and idvehiculo=$idvehiculo";
$rs_folio_bitacora = mssql_query ($sql_folio_bitacora,$connection);	

if(mssql_num_rows($rs_folio_bitacora)==0){
	$insert_folio_bitacora="INSERT INTO bitacora_mensual (mes, anio, idvehiculo, estado, fecha_creacion, periodo) 
							VALUES ($mes, $anio, $idvehiculo, 1, getdate(), $periodo)";
	$tran_insert_folio_bitacora=mssql_query ($insert_folio_bitacora,$connection);	
	
	$sql_id= "SELECT IDENT_CURRENT('bitacora_mensual') as id";
	$rs_id = mssql_query($sql_id, $connection);
	$row_id = mssql_fetch_array($rs_id);
	$folio_bitacora = $row_id['id'];
}else{
	$row_folio_bitacora=mssql_fetch_array($rs_folio_bitacora);
	$folio_bitacora = $row_folio_bitacora['folio_bitacora'];
	$estado_bitacora = $row_folio_bitacora['estado'];
}

if($estado_bitacora!=2){
$insert="INSERT INTO bitacora (idbitacora, mes, idvehiculo, idconductor, idtarjeta, monto_combustible, litros_combustible, finicio_viaje, km_salida, hora_salida, lugar_inicio, ftermino_viaje, km_llegada, hora_llegada, lugar_termino, detalles_recorrido, num_pasajeros, fecha_registro, usuario_registra, anio, folio_bitacora, periodo)
values ($idbitacora, $mes, $idvehiculo, $idconductor, $idtarjeta, $monto_combustible, '$litros_combustible', '$finicio_viaje', '$km_salida', '$hora_salida', '$lugar_inicio', '$ftermino_viaje', '$km_llegada', '$hora_llegada', '$lugar_termino', '$detalles_recorrido', $num_pasajeros, getdate(),'$_SESSION[usuario]', $anio, $folio_bitacora, $periodo)";
$tran_insert=mssql_query ($insert,$connection);	

$insert_text="INSERT INTO bitacora (idbitacora, mes, idvehiculo, idconductor, idtarjeta, monto_combustible, litros_combustible, finicio_viaje, km_salida, hora_salida, lugar_inicio, ftermino_viaje, km_llegada, hora_llegada, lugar_termino, detalles_recorrido, num_pasajeros, fecha_registro, usuario_registra, anio, folio_bitacora, periodo) values ($idbitacora, $mes, $idvehiculo, $idconductor, $idtarjeta, $monto_combustible, $litros_combustible, $finicio_viaje, $km_salida, $hora_salida, $lugar_inicio, $ftermino_viaje, $km_llegada, $hora_llegada, $lugar_termino, $detalles_recorrido, $num_pasajeros, getdate(),$_SESSION[usuario], $anio, $folio_bitacora, $periodo)";


/**************************** Saldo Tarjeta Combustible **********************************/

$saldo_tarjeta=$saldo_tarjeta-$monto_combustible;

$update_saldo="update tarjeta_combustible set saldo_tarjeta=$saldo_tarjeta where num_tarjeta=$num_tarjeta";
$tran_update = mssql_query ($update_saldo,$connection);	
	
/************************** Fin Saldo Tarjeta Combustible **********************************/	


$insert_log="INSERT INTO log_bitacora VALUES ($idbitacora, 'INSERT', '$insert_text', getdate(),'$_SESSION[usuario]')";
$tran_insert_log=mssql_query ($insert_log,$connection);	

if (!$tran_insert && !$tran_insert_log && !$tran_update && !$tran_insert_folio_bitacora) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
  $mensaje=3;
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
  $mensaje=1;
}

mssql_close($connection);
}else{
	$mensaje=2;
}
header("Location:../bitacora_nueva.php?idvehiculo=".encrypt($idvehiculo)."&mes=".encrypt($mes)."&anio=".encrypt($anio)."&periodo=".encrypt($periodo)."&ms=".encrypt($mensaje));
?>