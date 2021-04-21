<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";
$rut=$_GET['rut'];
$idvehiculo=$_GET['idvehiculo'];



$sql_idvc="select max(id) as id from vehiculos_conductor";
$rs_idvc = mssql_query ($sql_idvc,$connection);	
$row_idvc=mssql_fetch_array($rs_idvc);
$idvc=$row_idvc['id']+1;


mssql_query("BEGIN TRAN");	
$sql="select * from conductor where rut='$rut'";
$rs = mssql_query ($sql,$connection);	
$row=mssql_fetch_array($rs);
$idconductor=$row['idconductor'];
	
$sql2="select * from vehiculos_conductor where idconductor=$idconductor and idvehiculo=$idvehiculo";
$rs2 = mssql_query ($sql2,$connection);	
if(mssql_num_rows($rs2)==0){
	$insert2="INSERT INTO vehiculos_conductor (id, idconductor, idvehiculo, fecha_registro, usuario_registra)
			  VALUES ($idvc, $idconductor, $idvehiculo, getdate(),'$_SESSION[usuario]')";
	$tran_insert2=mssql_query ($insert2,$connection);	
	if (!$tran_insert2) {
		  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
		  mssql_query("ROLLBACK");
		  $mensaje=3;
	}else {
		  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
		  mssql_query("COMMIT");
		  $mensaje=1;
	}
}else{
	$mensaje=2;
}
echo $mensaje;
mssql_close($connection);
//header("Location:../conductor_vehiculo.php?id=".encrypt($idconductor)."&ms=".encrypt($mensaje));
?>