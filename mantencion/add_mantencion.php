<?php 
session_start();  
include ("../include/conexion.php");

$_SESSION['status']="";

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

$sql_idmantencion="select max(idmantencion) as idmantencion from mantenciones";
$rs_idmantencion = mssql_query ($sql_idmantencion,$connection);	
$row_idmantencion=mssql_fetch_array($rs_idmantencion);
$idmantencion=$row_idmantencion['idmantencion']+1;


if (is_uploaded_file($_FILES['file_informe']['tmp_name'])) { 

		copy($_FILES['file_informe']['tmp_name'], $path.$_FILES['file_informe']['name']); 
		
		rename($path.$_FILES['file_informe']['name'], $path.$idmantencion.".".$ext_img);
		$nombre_informe=$path.$idmantencion.".".$ext_img;	 
	
}

mssql_query("BEGIN TRAN");	
$insert="INSERT INTO mantenciones (idmantencion, idvehiculo, concesionario, costo_mantencion, fecha_mantencion, km, detalle, km_proxima_mantencion, festimada_prox_mantencion, informe, fecha_registro, usuario_registra, estado)
		VALUES ($idmantencion, $idvehiculo, '$concesionario', $costo, '$fmantencion', '$kilometraje', '$detalle', '$km_prox', '$fprox_mantencion', '$nombre_informe', getdate(),'$_SESSION[usuario]', 1)";
$tran_insert=mssql_query ($insert,$connection);	

if (!$tran_insert) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
}

mssql_close($connection);
header("Location:../mantencion_nueva.php");
?>