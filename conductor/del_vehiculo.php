<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";

$idvehiculo=$_GET['id'];
$idconductor=$_GET['idconductor'];

mssql_query("BEGIN TRAN");	
$delete="delete from vehiculos_conductor where idconductor=$idconductor and idvehiculo=$idvehiculo";
$tran_delete=mssql_query ($delete,$connection);	

if (!$tran_delete) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
}

mssql_close($connection);
header("Location:../conductor_vehiculo.php?id=".encrypt($idconductor));
?>