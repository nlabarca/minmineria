<?php 
session_start();  
include ("../include/conexion.php");

$id=$_GET['id'];
$sancion=$_POST['chk_sancion'];
$obs=$_POST['txta_observacion'];
$otp=$_POST['txt_otp'];;
if($sancion==1){
	$estado=3;
	$mensaje=2;
}
if($sancion==2){
	$estado=4;
	$mensaje=3;
}
	
$update="UPDATE bitacora_mensual set estado=$estado, visacion_jefe_directo=$sancion, obs_visacion='$obs', fecha_visacion=getdate(), usuario_visacion='$_SESSION[usuario]' where folio_bitacora=$id";
mssql_query ($update,$connection);
	
if($sancion==1){
	header("Location:firmar_docto.php?id=".$id."&otp=".$otp);
}

//header("Location:../ver_bitacoras.php?ms=".encrypt($mensaje));
?>