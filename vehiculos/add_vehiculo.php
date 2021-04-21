<?php 
session_start();  
include ("../include/conexion.php");

//print_r($_POST);

$_SESSION['status']="";

$tipo_vehiculo=$_POST['sel_tipo_vehiculo'];
$patente=$_POST['txt_patente'];
$marca=$_POST['txt_marca'];
$modelo=$_POST['txt_modelo'];
$anio=$_POST['txt_anio']; 
$color=$_POST['txt_color'];
$programa=$_POST['sel_programa'];
$region=$_POST['sel_region']; 
$num_poliza=$_POST['txt_num_poliza'];
$compania=$_POST['txt_compania']; 
$num_motor=$_POST['txt_nmotor']; 
$num_chasis=$_POST['txt_chasis']; 


$dia_finicio=substr($_POST['txt_finicio'], 0, 2);
$mes_finicio=substr($_POST['txt_finicio'], 3, 2);
$ano_finicio=substr($_POST['txt_finicio'], 6, 4);
$finicio 	= $ano_finicio."-".$mes_finicio."-".$dia_finicio;

$dia_ftermino=substr($_POST['txt_ftermino'], 0, 2);
$mes_ftermino=substr($_POST['txt_ftermino'], 3, 2);
$ano_ftermino=substr($_POST['txt_ftermino'], 6, 4);
$ftermino 	= $ano_ftermino."-".$mes_ftermino."-".$dia_ftermino;


$file_img=$_FILES['file_img']['name'];
$tipo_img=$_FILES['file_img']['type'];
$ext_img = end(explode('.',$file_img));

$path="img_vehiculos/";
if (!file_exists($path)) {
	mkdir($path, 0777);
}

$sql_idvehiculo="select max(idvehiculo) as idvehiculo from vehiculo";
$rs_idvehiculo = mssql_query ($sql_idvehiculo,$connection);	
$row_idvehiculo=mssql_fetch_array($rs_idvehiculo);
$idvehiculo=$row_idvehiculo['idvehiculo']+1;


if (is_uploaded_file($_FILES['file_img']['tmp_name'])) { 

		copy($_FILES['file_img']['tmp_name'], $path.$_FILES['file_img']['name']); 
		
		rename($path.$_FILES['file_img']['name'], $path.$idvehiculo.".".$ext_img);
		$nombre_img=$path.$idvehiculo.".".$ext_img;	 
	
}

$file_poliza=$_FILES['file_poliza']['name'];
$tipo_poliza=$_FILES['file_poliza']['type'];
$ext_poliza = end(explode('.',$file_poliza));

$path2="poliza_vehiculos/";
if (!file_exists($path2)) {
	mkdir($path2, 0777);
}


if (is_uploaded_file($_FILES['file_poliza']['tmp_name'])) { 

		copy($_FILES['file_poliza']['tmp_name'], $path2.$_FILES['file_poliza']['name']); 
		
		rename($path2.$_FILES['file_poliza']['name'], $path2.$idvehiculo.".".$ext_poliza);
		$nombre_poliza=$path2.$idvehiculo.".".$ext_poliza;	 
}	

$file_resolucion=$_FILES['file_resolucion']['name'];
$tipo_resolucion=$_FILES['file_resolucion']['type'];
$ext_resolucion = end(explode('.',$file_resolucion));

$path3="resolucion_vehiculos/";
if (!file_exists($path3)) {
	mkdir($path3, 0777);
}

if (is_uploaded_file($_FILES['file_resolucion']['tmp_name'])) { 

		copy($_FILES['file_resolucion']['tmp_name'], $path3.$_FILES['file_resolucion']['name']); 
		
		rename($path3.$_FILES['file_resolucion']['name'], $path3.$idvehiculo.".".$ext_resolucion);
		$nombre_resolucion=$path3.$idvehiculo.".".$ext_resolucion;	 
}	

$sql_vehiculo="select * from vehiculo where patente='$patente'";
$rs_vehiculo = mssql_query ($sql_vehiculo,$connection);	
if(mssql_num_rows($rs_vehiculo)==0){  	
	mssql_query("BEGIN TRAN");
	$insert="INSERT INTO vehiculo (idvehiculo, patente,marca,modelo,anio,color,imagen,num_poliza,compania,finicio_poliza,ftermino_poliza,docto_poliza,idprograma,idregion,fecha_registro,usuario_registra,idtipo_vehiculo, idestado, num_motor, num_chasis, resolucion)
			VALUES ($idvehiculo, '$patente','$marca','$modelo','$anio','$color','$nombre_img','$num_poliza','$compania','$finicio','$ftermino','$nombre_poliza',$programa,$region,getdate(),'$_SESSION[usuario]',$tipo_vehiculo, 1, '$num_motor', '$num_chasis', '$nombre_resolucion')";
	$tran_insert=mssql_query ($insert,$connection);	

	if (!$tran_insert) {
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
mssql_close($connection);
header("Location:../vehiculo_nuevo.php?ms=".encrypt($mensaje)."");
?>