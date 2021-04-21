<?php 
session_start();  
include ("../include/conexion.php");
//print_r($_POST);
$_SESSION['status']="";

$num_tarjeta=$_GET['num_tarjeta'];

$dato=dato_tarjeta($num_tarjeta);

$idtarjeta=$dato['idtarjeta'];
echo "<div class='table-responsive'>
      <table class='table table-hover'>
        <thead class='text-success'>
          <tr>
            <th class='text-center'>#</th>
            <th>Veh&iacute;culo</th>
            <th>Patente</th>
            <th>Conductor</th>
            <th class='text-center'>Monto Combustible</th>
            <th class='text-center'>Lts. Combustible</th>
            <th class='text-center'>Fec. Inicio Viaje</th>
            <th>Lugar  Inicio Viaje</th>
            <th class='text-center'>Pasajeros</th>
          </tr>
        </thead>
        <tbody>";
			$sql_tarjeta="select c.descripcion as tipo_vehiculo, b.patente, (d.nombres+' '+d.apellidos) as conductor, a.monto_combustible, a.litros_combustible, a.finicio_viaje, a.lugar_inicio, a.num_pasajeros 
						from bitacora a, vehiculo b, tipo_vehiculo c, conductor d
						where a.idtarjeta=$idtarjeta	
						and a.idvehiculo=b.idvehiculo
						and b.idtipo_vehiculo=c.idtipo_vehiculo	
						and a.idconductor=d.idconductor";
			$rs_tarjeta = mssql_query ($sql_tarjeta,$connection);
			if(mssql_num_rows($rs_tarjeta)>0){
				$i=1; 
				while($row_tarjeta=mssql_fetch_array($rs_tarjeta)){
					$date = date_create($row_tarjeta['finicio_viaje']);
					$finicio_viaje=date_format($date, 'd-m-Y');
					echo "	<tr>
							  <td class='text-center'>".$i."</td>
							  <td>".$row_tarjeta['tipo_vehiculo']."</td>
							  <td>".$row_tarjeta['patente']."</td>
							  <td>".$row_tarjeta['conductor']."</td>
							  <td class='text-right'>$".number_format($row_tarjeta['monto_combustible'], 0, ',', '.')."</td>
							  <td class='text-center'>".$row_tarjeta['litros_combustible']."</td>
							  <td class='text-center'>".$finicio_viaje."</td>
							  <td>".$row_tarjeta['lugar_inicio']."</td>	
							  <td class='text-center'>".$row_tarjeta['num_pasajeros']."</td>	
							</tr>";

					$i++;
				}
			}else{
				echo "<tr>
						<td colspan='17' class='text-center'>No hay resultados</td>
					  </tr>";
			}
		echo "</tbody>
			</table>
		</div>";