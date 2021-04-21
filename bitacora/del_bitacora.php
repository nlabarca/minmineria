<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";
$idbitacora=$_GET['id'];

/**************************** Saldo Tarjeta Combustible **********************************/
$sql_idbitacora="select idtarjeta, monto_combustible from bitacora where idbitacora=$idbitacora";
$rs_idbitacora = mssql_query ($sql_idbitacora,$connection);	
$row_idbitacora=mssql_fetch_array($rs_idbitacora);
$idtarjeta=$row_idbitacora['idtarjeta'];
$monto_combustible=$row_idbitacora['monto_combustible'];


$sql_saldo="select saldo_tarjeta from tarjeta_combustible where idtarjeta=$idtarjeta";
$rs_saldo = mssql_query ($sql_saldo,$connection);	
$row_saldo=mssql_fetch_array($rs_saldo);

$saldo_tarjeta=$row_saldo['saldo_tarjeta']+$monto_combustible;

mssql_query("BEGIN TRAN");	

$update_saldo="update tarjeta_combustible set saldo_tarjeta=$saldo_tarjeta where idtarjeta=$idtarjeta";
$tran_update = mssql_query ($update_saldo,$connection);	
	
/************************** Fin Saldo Tarjeta Combustible **********************************/	


$delete="delete from bitacora where idbitacora=$idbitacora";
$tran_delete=mssql_query ($delete,$connection);	

$insert_log="INSERT INTO log_bitacora VALUES ($idbitacora, 'DELETE', '$delete', getdate(),'$_SESSION[usuario]')";
$tran_insert_log=mssql_query ($insert_log,$connection);	


if (!$tran_delete && !$insert_log && !$tran_update) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
}

mssql_close($connection);

?>