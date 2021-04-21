<?php 
session_start();  
include ("../include/conexion.php");
//print_r($_POST);
$_SESSION['status']="";

$idregion=$_GET['idregion'];
$select= "select a.idvehiculo, a.patente, b.descripcion as tipo_vehiculo from vehiculo a, tipo_vehiculo b 
		where idregion=$idregion
		and a.idtipo_vehiculo=b.idtipo_vehiculo
		and a.idestado=1";
$rs_1 = mssql_query ($select,$connection);	
echo "<select name='sel_vehiculos' class='form-control' id='sel_vehiculos'>";
if(mssql_num_rows($rs_1)==0){
	echo "<option selected value=''>...</option>";
}else{
	echo "<option value=''>...</option>";
	while($row_1=mssql_fetch_array($rs_1))
	{
	  echo "<option value='".$row_1['idvehiculo']."'>".utf8_encode($row_1['tipo_vehiculo'])."-".$row_1['patente']."</option>";
	}
}
echo "</select>";
mssql_close($connection);

?>
