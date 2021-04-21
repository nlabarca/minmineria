<?php 
session_start();  
include ("../include/conexion.php");

$id=$_GET['id'];
$file=$_FILES['docto_bitacora']['name'];
$tipo=$_FILES['docto_bitacora']['type'];
$ext = end(explode('.',$file));


$path="doctos/";
if (!file_exists($path)) {
	mkdir($path, 0777);
}
$archivo=$path.$file;

if (is_uploaded_file($_FILES['docto_bitacora']['tmp_name'])) { 

		copy($_FILES['docto_bitacora']['tmp_name'], $path.$_FILES['docto_bitacora']['name']); 
		
		rename($path.$_FILES['docto_bitacora']['name'], $path.$id.".".$ext);
		$nombre_archivo=$path.$id.".".$ext;
	
	
	$update="UPDATE bitacora_mensual set estado=2, docto_adjunto='$nombre_archivo' where folio_bitacora=$id";
	mssql_query ($update,$connection);
	$mensaje=1;
}	
header("Location:../ver_bitacoras.php?ms=".encrypt($mensaje));
?>