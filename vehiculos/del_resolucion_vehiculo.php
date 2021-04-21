<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";

$idvehiculo=decrypt($_GET['id']);
$datos=dato_vehiculo($idvehiculo);

mssql_query("BEGIN TRAN");	
if(unlink( $datos['resolucion'])){
	$update="update vehiculo set resolucion=null where idvehiculo=$idvehiculo";
	$tran_update=mssql_query ($update,$connection);	

	if (!$tran_update) {
	  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
	  mssql_query("ROLLBACK");
	}else {
	  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
	  mssql_query("COMMIT");
	}
}
mssql_close($connection);
header("Location:../vehiculo_edit.php?id=".encrypt($idvehiculo));
?>