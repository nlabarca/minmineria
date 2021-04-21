<?php
include ("functions/funciones.php");
include ("include/conexion.php");

$user = $_GET['username'];
$pwd  = $_GET['pass'];
	
$user_valid = f_conect_ldap('172.16.90.130', 'minmineria.cl', $user, $pwd);

if($user_valid == 1){

	$q1 = "SELECT * FROM usuarios WHERE idestado = 1 AND usuario = '$user'";
	
	$rs_1 = mssql_query ($q1,$connection);
	$d_user_valido=mssql_num_rows($rs_1);
	
	if($d_user_valido == 1){
		$sql="select * from usuarios where usuario='$user' and idestado=1";
		$result = mssql_query ($sql,$connection);	
		$row=mssql_fetch_array($result);
	
		if(mssql_num_rows($result)>0){
			session_start(); 
			$_SESSION['intervalo']  = 30; // en minutos
			$_SESSION['inicio'] = time();
			$id_usuario=$row['rut'];	
			$id_perfil=$row['idperfil'];
			$nombre_usuario=$row['nombres']." ".$row['apellidos'];
			$region_usuario=$row['idregion'];
			$comuna_usuario=$row['idcomuna'];
			$usuario=$row['usuario'];	
			$unidad=$row['idunidades'];
			$_SESSION['id_usuario']=$id_usuario;
			$_SESSION['id_perfil']=$id_perfil;
			$_SESSION['nom_usuario']=$nombre_usuario;
			$_SESSION['region_usuario']=$region_usuario;
			$_SESSION['comuna_usuario']=$comuna_usuario;
			$_SESSION['unidad']=$unidad;
			$_SESSION['usuario']=$usuario;
			$_SESSION['pass']=$pwd;
			$_SESSION['status']="";
			$ses_id = session_id(); 
			header("location:dashboard.php");
		}
		
	}else{
		header("location:index.php?m=1");
	}
}else{
	header("location:index.php?m=1");
}
?>