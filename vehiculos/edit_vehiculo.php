<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";
$idvehiculo=decrypt($_GET['id']);

$tipo_vehiculo=$_POST['sel_tipo_vehiculo'];
$patente=$_POST['txt_patente'];
$marca=$_POST['txt_marca'];
$modelo=$_POST['txt_modelo'];
$anio=$_POST['txt_anio']; 
$color=$_POST['txt_color'];
$programa=$_POST['sel_programa'];
$region=$_POST['sel_region']; 
$num_poliza=$_POST['txt_num_poliza'];
$compania=$_POST['txt_compania']; 
$num_motor=$_POST['txt_nmotor']; 
$num_chasis=$_POST['txt_chasis']; 


$dia_finicio=substr($_POST['txt_finicio'], 0, 2);
$mes_finicio=substr($_POST['txt_finicio'], 3, 2);
$ano_finicio=substr($_POST['txt_finicio'], 6, 4);
$finicio 	= $ano_finicio."-".$mes_finicio."-".$dia_finicio;

$dia_ftermino=substr($_POST['txt_ftermino'], 0, 2);
$mes_ftermino=substr($_POST['txt_ftermino'], 3, 2);
$ano_ftermino=substr($_POST['txt_ftermino'], 6, 4);
$ftermino 	= $ano_ftermino."-".$mes_ftermino."-".$dia_ftermino;


$file_img=$_FILES['file_img']['name'];
$tipo_img=$_FILES['file_img']['type'];
$ext_img = end(explode('.',$file_img));

$path="img_vehiculos/";
if (!file_exists($path)) {
	mkdir($path, 0777);
}



if (is_uploaded_file($_FILES['file_img']['tmp_name'])) { 

		copy($_FILES['file_img']['tmp_name'], $path.$_FILES['file_img']['name']); 
		
		rename($path.$_FILES['file_img']['name'], $path.$idvehiculo.".".$ext_img);
		$nombre_img=$path.$idvehiculo.".".$ext_img;	 
	
}

$file_poliza=$_FILES['file_poliza']['name'];
$tipo_poliza=$_FILES['file_poliza']['type'];
$ext_poliza = end(explode('.',$file_poliza));

$path2="poliza_vehiculos/";
if (!file_exists($path2)) {
	mkdir($path2, 0777);
}


if (is_uploaded_file($_FILES['file_poliza']['tmp_name'])) { 

		copy($_FILES['file_poliza']['tmp_name'], $path2.$_FILES['file_poliza']['name']); 
		
		rename($path2.$_FILES['file_poliza']['name'], $path2.$idvehiculo.".".$ext_poliza);
		$nombre_poliza=$path2.$idvehiculo.".".$ext_poliza;	 
}	

$file_resolucion=$_FILES['file_resolucion']['name'];
$tipo_resolucion=$_FILES['file_resolucion']['type'];
$ext_resolucion = end(explode('.',$file_resolucion));

$path3="resolucion_vehiculos/";
if (!file_exists($path2)) {
	mkdir($path3, 0777);
}


if (is_uploaded_file($_FILES['file_resolucion']['tmp_name'])) { 

		copy($_FILES['file_resolucion']['tmp_name'], $path3.$_FILES['file_resolucion']['name']); 
		
		rename($path3.$_FILES['file_resolucion']['name'], $path3.$idvehiculo.".".$ext_resolucion);
		$nombre_resolucion=$path3.$idvehiculo.".".$ext_resolucion;	 
}	


if($nombre_img==""){
	$nombre_img=$_POST['file_img'];
}
if($nombre_poliza==""){
	$nombre_poliza=$_POST['file_poliza'];
}
if($nombre_resolucion==""){
	$nombre_resolucion=$_POST['file_resolucion'];
}
mssql_query("BEGIN TRAN");	
$update="UPDATE vehiculo set patente='$patente', marca='$marca', modelo='$modelo', anio='$anio', color='$color', imagen='$nombre_img', num_poliza='$num_poliza', compania='$compania', finicio_poliza='$finicio', ftermino_poliza='$ftermino', docto_poliza='$nombre_poliza', 
		idprograma='$programa', idregion='$region', idtipo_vehiculo='$tipo_vehiculo', num_motor='$num_motor', num_chasis='$num_chasis', resolucion='$nombre_resolucion' WHERE idvehiculo=$idvehiculo";
 $tran_update=mssql_query ($update,$connection);	

if (!$tran_update) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
}

mssql_close($connection);
header("Location:../ver_vehiculos.php?ms=".encrypt(1)."");
?>