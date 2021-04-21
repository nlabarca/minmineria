<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";
$idconductor=decrypt($_GET['id']);

$rut=$_POST['txt_rut'];
$nombres=$_POST['txt_nombres'];
$apellidos=$_POST['txt_apellidos'];
$cargo=$_POST['txt_cargo'];
$region=$_POST['sel_region'];
$programa=$_POST['sel_programa'];
$licencia=$_POST['sel_licencia'];

$dia_fvencimiento=substr($_POST['txt_fvencimiento'], 0, 2);
$mes_fvencimiento=substr($_POST['txt_fvencimiento'], 3, 2);
$ano_fvencimiento=substr($_POST['txt_fvencimiento'], 6, 4);
$fvencimiento= $ano_fvencimiento."-".$mes_fvencimiento."-".$dia_fvencimiento;

$num_poliza=$_POST['txt_num_poliza'];
$compania=$_POST['txt_compania'];

$dia_finicio=substr($_POST['txt_finicio'], 0, 2);
$mes_finicio=substr($_POST['txt_finicio'], 3, 2);
$ano_finicio=substr($_POST['txt_finicio'], 6, 4);
$fseguro_inicio 	= $ano_finicio."-".$mes_finicio."-".$dia_finicio;

$dia_ftermino=substr($_POST['txt_ftermino'], 0, 2);
$mes_ftermino=substr($_POST['txt_ftermino'], 3, 2);
$ano_ftermino=substr($_POST['txt_ftermino'], 6, 4);
$fseguro_termino 	= $ano_ftermino."-".$mes_ftermino."-".$dia_ftermino;


$file_poliza=$_FILES['file_poliza']['name'];
$tipo_poliza=$_FILES['file_poliza']['type'];
$ext_poliza = end(explode('.',$file_poliza));

$path2="poliza_conductor/";
if (!file_exists($path2)) {
	mkdir($path2, 0777);
}


if (is_uploaded_file($_FILES['file_poliza']['tmp_name'])) { 

		copy($_FILES['file_poliza']['tmp_name'], $path2.$_FILES['file_poliza']['name']); 
		
		rename($path2.$_FILES['file_poliza']['name'], $path2.$idconductor.".".$ext_poliza);
		$nombre_poliza=$path2.$idconductor.".".$ext_poliza;	 
}	

$file_licencia=$_FILES['file_licencia']['name'];
$tipo_licencia=$_FILES['file_licencia']['type'];
$ext_licencia = end(explode('.',$file_licencia));

$path3="licencia_conductor/";
if (!file_exists($path3)) {
	mkdir($path3, 0777);
}
if (is_uploaded_file($_FILES['file_licencia']['tmp_name'])) { 

		copy($_FILES['file_licencia']['tmp_name'], $path3.$_FILES['file_licencia']['name']); 
		
		rename($path3.$_FILES['file_licencia']['name'], $path3.$idconductor.".".$ext_licencia);
		$nombre_licencia=$path3.$idconductor.".".$ext_licencia;	 
}


if($nombre_poliza==""){
	$nombre_poliza=$_POST['file_poliza'];
}
if($nombre_licencia==""){
	$nombre_licencia=$_POST['file_licencia'];
}

mssql_query("BEGIN TRAN");	
$update="UPDATE conductor set idprograma=$programa, idtipo_licencia=$licencia, fvencimiento_licencia='$fvencimiento', num_poliza='$num_poliza', aseguradora='$compania', fseguro_inicio='$fseguro_inicio', fseguro_termino='$fseguro_termino', docto_poliza='$nombre_poliza', nombres='$nombres', apellidos='$apellidos', cargo='$cargo', idregion=$region, docto_licencia='$nombre_licencia' where idconductor=$idconductor";
$tran_update=mssql_query ($update,$connection);	

if (!$tran_update) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
}

mssql_close($connection);
header("Location:../ver_conductores.php");
?>