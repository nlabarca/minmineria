<?php 
session_start();  
include ("../include/conexion.php");
//print_r($_POST);
$_SESSION['status']="";

$idvehiculo=$_GET['idvehiculo'];
$mes=$_GET['mes'];
$anio=$_GET['anio'];
$periodo=$_GET['periodo'];
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
            <th class='text-center'>N&deg; Tarjeta</th>
            <th class='text-center'>Fec. Inicio Viaje</th>
            <th class='text-center'>Lugar  Inicio Viaje</th>
            <th class='text-center'>Hr. Salida</th>
            <th class='text-center'>KM  Salida</th>
            <th class='text-center'>Fec. Termino Viaje</th>
            <th class='text-center'>Lugar Termino Viaje</th>
            <th class='text-center'>Hr. Llegada</th>
            <th class='text-center'>KM Llegada</th>
            <!--<th class='text-center'>Detalle Recorrido</th>-->
            <th class='text-center'>Pasajeros</th>";
			if(menu(23, $_SESSION['id_perfil'])==1){ 
            echo "<th class='text-right'>Actions</th>";
			}
          echo "</tr>
        </thead>
        <tbody>";
			$sql_bitacora="select a.idbitacora, c.descripcion, b.patente, (d.nombres+' '+d.apellidos) as conductor, a.monto_combustible, a.litros_combustible, e.saldo_tarjeta, a.finicio_viaje, a.lugar_inicio, a.hora_salida, a.km_salida, 
						  a.ftermino_viaje, a.lugar_termino, a.hora_llegada, a.km_llegada, a.detalles_recorrido, a.num_pasajeros, e.num_tarjeta, a.folio_bitacora
						  from bitacora a, vehiculo b, tipo_vehiculo c, conductor d, tarjeta_combustible e
						  where a.idvehiculo=b.idvehiculo
						  and b.idtipo_vehiculo=c.idtipo_vehiculo
						  and a.idconductor=d.idconductor
						  and a.idtarjeta=e.idtarjeta
						  and a.idvehiculo=$idvehiculo
						  and a.mes=$mes
						  and a.anio=$anio
						  and a.periodo=$periodo";
			$rs_bitacora = mssql_query ($sql_bitacora,$connection);
			if(mssql_num_rows($rs_bitacora)>0){
				$i=1; 
				while($row_bitacora=mssql_fetch_array($rs_bitacora)){
					$date = date_create($row_bitacora['finicio_viaje']);
					$finicio_viaje=date_format($date, 'd-m-Y');

					$date2 = date_create($row_bitacora['ftermino_viaje']);
					$ftermino_viaje=date_format($date2, 'd-m-Y');
					
					$sql_folio_bitacora="select estado from bitacora_mensual where folio_bitacora=$row_bitacora[folio_bitacora]";
					$rs_folio_bitacora = mssql_query ($sql_folio_bitacora,$connection);	
					$row_folio_bitacora=mssql_fetch_array($rs_folio_bitacora);

					echo "	<tr>
							  <td class='text-center'>".$i."</td>
							  <td>".$row_bitacora['descripcion']."</td>
							  <td>".$row_bitacora['patente']."</td>
							  <td>".$row_bitacora['conductor']."</td>
							  <td class='text-right'>$".number_format($row_bitacora['monto_combustible'], 0, ',', '.')."</td>
							  <td class='text-center'>".$row_bitacora['litros_combustible']."</td>
							  <td class='text-right'>".$row_bitacora['num_tarjeta']."</td>
							  <td class='text-center'>".$finicio_viaje."</td>
							  <td>".$row_bitacora['lugar_inicio']."</td>	
							  <td class='text-center'>".$row_bitacora['hora_salida']."</td>	
							  <td class='text-right'>".number_format($row_bitacora['km_salida'], 0, ',', '.')."</td>	
							  <td class='text-center'>".$ftermino_viaje."</td>	
							  <td>".$row_bitacora['lugar_termino']."</td>	
							  <td class='text-center'>".$row_bitacora['hora_llegada']."</td>	
							  <td class='text-right'>".number_format($row_bitacora['km_llegada'], 0, ',', '.')."</td>	
							  <td class='text-center'>".$row_bitacora['num_pasajeros']."</td>	
							  <td class='td-actions text-right'>";
						      if(menu(23, $_SESSION['id_perfil'])==1){ 
							  if($row_folio_bitacora['estado']==1){
								echo "<button type='button' rel='tooltip' class='btn btn-danger' data-original-title='' title='' onClick='javascript:del_bitacora(".$row_bitacora['idbitacora'].")'>
								  <i class='material-icons'>close</i>
								  </button>";
							  }
							  }
								echo "</td>
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