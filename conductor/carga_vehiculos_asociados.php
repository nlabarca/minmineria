<?php 
session_start();  
include ("../include/conexion.php");
//print_r($_POST);
$_SESSION['status']="";

$idconductor=$_GET['idconductor'];
echo "<div class='table-responsive'>
		<table class='table table-hover'>
			<thead class='text-success'>
				<tr>
					<th class='text-center'>#</th>
					<th>Tipo Veh&iacute;culo</th>
					<th>Patente</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>A&ntilde;o</th>
					<th>Color</th>
					<th>Programa</th>
					<th>Regi&oacute;n</th>	
					<th class='text-right'>Actions</th>
				</tr>
			</thead>
		<tbody>";
		$sql_vehiculos="select a.idvehiculo, c.descripcion as tipo_vehiculo, b.patente, b.marca, b.modelo, b.anio, b.color, d.descripcion as programa, e.nombre as region  
                        from vehiculos_conductor a, vehiculo b, tipo_vehiculo c, programa d, region e 
                        where a.idconductor=$idconductor
                        and a.idvehiculo=b.idvehiculo
                        and b.idtipo_vehiculo=c.idtipo_vehiculo
                        and b.idprograma=d.idprograma
                        and b.idregion=e.idregion";
        $rs_vehiculos = mssql_query ($sql_vehiculos,$connection);
        $i=1; 
        while($row_vehiculos=mssql_fetch_array($rs_vehiculos)){
			echo "<tr>
					<td class='text-center'>".$i."</td>
					<td>".$row_vehiculos['tipo_vehiculo']."</td>
					<td>".$row_vehiculos['patente']."</td>
					<td>".$row_vehiculos['marca']."</td>
					<td>".$row_vehiculos['modelo']."</td>
					<td>".$row_vehiculos['anio']."</td>
					<td>".$row_vehiculos['color']."</td>
					<td>".utf8_encode($row_vehiculos['programa'])."</td>
					<td>".utf8_encode($row_vehiculos['region'])."</td>	
					<td class='td-actions text-right'>
						<button type='button' rel='tooltip' class='btn btn-danger' data-original-title='' title='' onClick='javascript:del_vehiculo(".$row_vehiculos['idvehiculo'].",".$idconductor.")'>
							<i class='material-icons'>close</i>
						</button>
					</td>
				</tr>";
			$i++;
		}
		echo "</tbody>
			</table>
		</div>";
mssql_close($connection);

?>
