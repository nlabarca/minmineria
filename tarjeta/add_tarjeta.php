<?php 
session_start();  
include ("../include/conexion.php");

print_r($_POST);

$_SESSION['status']="";

$num_tarjeta=$_POST['txt_num_tarjeta'];
$monto_inicial=$_POST['txt_monto'];
$programa=$_POST['sel_programa'];
$region=$_POST['sel_region'];
$responsable=$_POST['txt_responsable'];

$dia_fvencimiento=substr($_POST['txt_fvencimiento'], 0, 2);
$mes_fvencimiento=substr($_POST['txt_fvencimiento'], 3, 2);
$ano_fvencimiento=substr($_POST['txt_fvencimiento'], 6, 4);
$fvencimiento= $ano_fvencimiento."-".$mes_fvencimiento."-".$dia_fvencimiento;

$idtipo_tarjeta=$_POST['sel_tipo'];
$empresa=$_POST['txt_empresa'];

$sql_idtarjeta="select max(idtarjeta) as idtarjeta from tarjeta_combustible";
$rs_idtarjeta = mssql_query ($sql_idtarjeta,$connection);	
$row_idtarjeta=mssql_fetch_array($rs_idtarjeta);
$idtarjeta=$row_idtarjeta['idtarjeta']+1;

if($monto_inicial==""){
	$monto_inicial="null";
}

mssql_query("BEGIN TRAN");	

$insert="INSERT INTO tarjeta_combustible (idtarjeta, monto_inicial, fecha_vencimiento, idprograma, responsable, fecha_registro, usuario_registra, idestado, num_tarjeta, idregion, saldo_tarjeta, idtipo_tarjeta, empresa)
		VALUES ($idtarjeta, $monto_inicial, '$fvencimiento', $programa, '$responsable', getdate(),'$_SESSION[usuario]', 1, '$num_tarjeta', $region, $monto_inicial, $idtipo_tarjeta, '$empresa')";
$tran_insert=mssql_query ($insert,$connection);	

if (!$tran_insert) {
  //la consulta ha fallado, y le indicamos al motor de la base de datos que restablezca la base de datos tal y como estaba antes de iniciar la transacción
  mssql_query("ROLLBACK");
}else {
  //La consulta se ha realizado correctamente, y le indicamos al motor de la base de datos que puede grabar los datos     
  mssql_query("COMMIT");
}

mssql_close($connection);
header("Location:../tarjeta_nueva.php");
?>