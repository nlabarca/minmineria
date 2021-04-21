<?php
$server = 'MyServer2000'; 
// Connect to MSSQL 
$connection = mssql_connect($server, 'sa', 'chino2001'); 
if (!$connection) { 
die('Something went wrong while connecting to MSSQL'); 
} 
mssql_select_db('insumos', $connection);
function unidad($id){
	global $connection;
	$sql="SELECT descripcion FROM unidades where idunidades=$id";
	$rs = mssql_query ($sql,$connection);	
	$row=mssql_fetch_array($rs);	
	$estado=$row['descripcion'];
	return $estado;
}
function revision($folio, $id){
	global $connection;
	$sql="select * from revision_solicitud where idsolicitud_compras=$folio and idencargados=$id";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);	
	$revision=mssql_num_rows($rs);
	return $revision;
}
function encargado($perfil){
	global $connection;
	$sql_encargado="select idencargados from encargados_revision where idperfil=$perfil and idestado=1";
	$rs_encargado = mssql_query ($sql_encargado,$connection);
	$row_encargado=mssql_fetch_array($rs_encargado);	
	$idencargados=$row_encargado['idencargados'];
	return $idencargados;
}
function estado($idsolicitud_compras){
	global $connection;
    $sql="select idestado_revision from solicitud_compras where idsolicitud_compras=$idsolicitud_compras";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);	
	$idestado_revision=$row['idestado_revision'];
	return $idestado_revision;
}
function visacion($idsolicitud_compras){
	global $connection;
	$sql="select b.idperfil, a.juridico from solicitud_compras a, usuarios b 
	where a.idsolicitud_compras=$idsolicitud_compras
	and a.usuario_solicitante=b.rut";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);	
	$idperfil=$row['idperfil'];
	$juridico=$row['juridico'];
	
	echo "estado->".$estado=estado($idsolicitud_compras);
	
	if($estado>1 && ($idperfil==1 || $idperfil==8)){
		$visacion=1; //Visacion Jefe Directo
	
		if($estado==3){
			$visacion=2; //Visacion Presupuesto
		}
		if($estado==4){
			$visacion=0; //Rechazado Jefe Directo
		}
		if($estado==5){
			$visacion=3; //Visacion Abastecimiento
		}
		if($estado==6){
			$visacion=0; //Rechazado Presupuesto
		}
		if($estado>=7 && $juridico==1){
			$visacion=6; //Visacion DAF;
			if($estado==11){
			  $visacion=4; //Visacion Juridico
			  if($estado==8){
				  $visacion=0; //Rechazado Abastecimiento
			  }
			}
		}
		if($estado==9){
				  $visacion=5; //Visacion Gabinete
			  
			  if($estado==10){
				  $visacion=0; //Rechazado Juridico
			  }
			  if($estado==13){
				  $visacion=7; //Finalizado Aprobado
			  }
			  if($estado==14){
				  $visacion=0; //Rechazado Gabinete
			  }
			}
		}
		if($estado>=7 && $juridico!=1){
			$visacion=6; //Visacion DAF;
			if($estado==11){
				$visacion=7; //Finalizado Aprobado
			}
			if($estado==12){
				$visacion=0; //Rechazado DAF
			}
		}
	}else{
		if($estado>1){
			$visacion=2; //Visacion Presupuesto
		}
		if($estado==5){
			$visacion=3; //Visacion Abastecimiento
		}
		if($estado==6){
			$visacion=0; //Rechazado Presupuesto
		}
		if($estado>=7 && $juridico==1){
			$visacion=6; //Visacion DAF
			if($estado==11){
				$visacion=4; //Visacion Juridico
				if($estado==8){
					$visacion=0; //Rechazado Abastecimiento
				}
			}
		}
		if($estado>=9 && $juridico==1){
					$visacion=5; //Visacion Gabinete
				
				if($estado==10){
					$visacion=0; //Rechazado Juridico
				}
				if($estado==13){
					$visacion=7; //Finalizado Aprobado
				}
				if($estado==14){
					$visacion=0; //Rechazado Gabinete
				}
			
		}
		if($estado>=7 && $juridico!=1){
			$visacion=6; //Visacion DAF
			if($estado==11){
				$visacion=7; //Finalizado Aprobado
			}
			if($estado==12){
				$visacion=0; //Rechazado DAF
			}
		}
	}
	return $visacion;
}
function factura($num_fac){
	global $connection;
    $sql="select idfactura from factura where num_fac=$num_fac";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);	
	$idfactura=$row['idfactura'];
	return $idfactura;
}
function orden($num_oc){
	global $connection;
    $sql="select idorden_compra from orden_compra where num_oc=$num_oc";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);	
	$idorden_compra=$row['idorden_compra'];
	return $idorden_compra;
}
function idevaluacion($idproveedor, $idfactura, $idorden_compra){
	global $connection;
    $sql="select idevaluacion_proveedor from evaluacion_proveedor where idproveedor=$idproveedor and idfactura=$idfactura and idorden_compra=$idorden_compra";
	$rs = mssql_query ($sql,$connection);
	$row=mssql_fetch_array($rs);	
	$idevaluacion_proveedor=$row['idevaluacion_proveedor'];
	return $idevaluacion_proveedor;
}
function encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}
function decrypt($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}
?>