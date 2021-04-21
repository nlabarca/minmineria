<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";
$idtarjeta=$_GET['idtarjeta'];
$idvehiculo=$_GET['idvehiculo'];



$sql_idvt="select max(id) as id from tarjeta_vehiculos";
$rs_idvt = mssql_query ($sql_idvt,$connection);	
$row_idvt=mssql_fetch_array($rs_idvt);
$idvt=$row_idvt['id']+1;


mssql_query("BEGIN TRAN");	
	
$sql2="select * from tarjeta_vehiculos where idtarjeta=$idtarjeta and idvehiculo=$idvehiculo";
$rs2 = mssql_query ($sql2,$connection);	
if(mssql_num_rows($rs2)==0){
	$insert2="INSERT INTO tarjeta_vehiculos (id, idtarjeta, idvehiculo, fecha_registro, usuario_registra)
			  VALUES ($idvt, $idtarjeta, $idvehiculo, getdate(),'$_SESSION[usuario]')";
	$tran_insert2=mssql_query ($insert2,$connection);	
	if (!$tran_insert2) {
		  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
		  mssql_query("ROLLBACK");
	}else {
		  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
		  mssql_query("COMMIT");
	}
}
mssql_close($connection);
header("Location:../tarjeta_vehiculo.php?id=".encrypt($idtarjeta));
?>