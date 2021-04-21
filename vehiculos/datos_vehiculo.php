<?php 
session_start();  
include ("../include/conexion.php");
//print_r($_POST);
$_SESSION['status']="";

$idvehiculo=$_GET['idvehiculo'];

$sql="select * from vehiculo where idvehiculo='$idvehiculo'";
$rs = mssql_query ($sql,$connection);
$row=mssql_fetch_array($rs);

echo $row['patente']."|".$row['marca']."|".$row['modelo']."|".$row['anio'];

mssql_close($connection);


?>