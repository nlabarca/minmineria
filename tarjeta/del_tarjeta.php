<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";

$idtarjeta=$_GET['id'];

mssql_query("BEGIN TRAN");	
$update="update tarjeta_combustible set idestado=2 where idtarjeta=$idtarjeta";
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