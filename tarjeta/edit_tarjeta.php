<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";
$idtarjeta=decrypt($_GET['id']);

$num_tarjeta=$_POST['txt_num_tarjeta'];
$monto_inicial=$_POST['txt_monto'];
$programa=$_POST['sel_programa'];
$region=$_POST['sel_region'];
$responsable=$_POST['txt_responsable'];

$dia_fvencimiento=substr($_POST['txt_fvencimiento'], 0, 2);
$mes_fvencimiento=substr($_POST['txt_fvencimiento'], 3, 2);
$ano_fvencimiento=substr($_POST['txt_fvencimiento'], 6, 4);
$fvencimiento= $ano_fvencimiento."-".$mes_fvencimiento."-".$dia_fvencimiento;

$idtipo_tarjeta=$_POST['sel_tipo'];
$empresa=$_POST['txt_empresa'];

if($monto_inicial==""){
	$monto_inicial="null";
}

mssql_query("BEGIN TRAN");	
$update="UPDATE tarjeta_combustible set monto_inicial=$monto_inicial, fecha_vencimiento='$fvencimiento', idprograma=$programa, responsable='$responsable', num_tarjeta='$num_tarjeta', idregion=$region, idtipo_tarjeta=$idtipo_tarjeta, empresa='$empresa' 
		where idtarjeta=$idtarjeta";
$tran_update=mssql_query ($update,$connection);	

if (!$tran_update) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
}

mssql_close($connection);
header("Location:../ver_tarjetas.php");
?>