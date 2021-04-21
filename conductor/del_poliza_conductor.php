<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";

$idconductor=decrypt($_GET['id']);
$datos=dato_conductor($idconductor);

mssql_query("BEGIN TRAN");	
if(unlink( $datos['docto_poliza'])){
	$update="update conductor set docto_poliza=null where idconductor=$idconductor";
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
header("Location:../conductor_edit.php?id=".encrypt($idconductor));
?>