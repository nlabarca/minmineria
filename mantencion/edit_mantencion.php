<?php 
session_start();  
include ("../include/conexion.php");

$_SESSION['status']="";

$idmantencion=decrypt($_GET['id']);

$idvehiculo=$_POST['sel_vehiculos'];
$concesionario=$_POST['txt_concesionario'];
$costo=$_POST['txt_costo'];
$kilometraje=$_POST['txt_kilometraje'];
$detalle=$_POST['txta_detalle']; 
$km_prox=$_POST['txt_km_prox'];


$dia_fmantencion=substr($_POST['txt_fmantencion'], 0, 2);
$mes_fmantencion=substr($_POST['txt_fmantencion'], 3, 2);
$ano_fmantencion=substr($_POST['txt_fmantencion'], 6, 4);
$fmantencion 	= $ano_fmantencion."-".$mes_fmantencion."-".$dia_fmantencion;

$dia_fprox_mantencion=substr($_POST['txt_fprox_mantencion'], 0, 2);
$mes_fprox_mantencion=substr($_POST['txt_fprox_mantencion'], 3, 2);
$ano_fprox_mantencion=substr($_POST['txt_fprox_mantencion'], 6, 4);
$fprox_mantencion 	= $ano_fprox_mantencion."-".$mes_fprox_mantencion."-".$dia_fprox_mantencion;


$file_informe=$_FILES['file_informe']['name'];
$tipo_img=$_FILES['file_informe']['type'];
$ext_img = end(explode('.',$file_informe));

$path="doctos/";
if (!file_exists($path)) {
	mkdir($path, 0777);
}


if (is_uploaded_file($_FILES['file_informe']['tmp_name'])) { 

		copy($_FILES['file_informe']['tmp_name'], $path.$_FILES['file_informe']['name']); 
		
		rename($path.$_FILES['file_informe']['name'], $path.$idmantencion.".".$ext_img);
		$nombre_informe=$path.$idmantencion.".".$ext_img;	 
}

if($nombre_informe==""){
	$nombre_informe=$_POST['file_informe'];
}
mssql_query("BEGIN TRAN");	
echo $update="UPDATE mantenciones set concesionario='$concesionario', costo_mantencion=$costo, fecha_mantencion='$fmantencion', km='$kilometraje', detalle='$detalle', km_proxima_mantencion='$km_prox', festimada_prox_mantencion='$fprox_mantencion', informe='$nombre_informe'
		WHERE idmantencion=$idmantencion";
$tran_update=mssql_query ($update,$connection);	

if (!$tran_update) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
}

mssql_close($connection);
header("Location:../ver_mantenciones.php");
?>