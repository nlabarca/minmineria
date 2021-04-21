<?php 
session_start();  
include ("../include/conexion.php");
//print_r($_POST);
$_SESSION['status']="";

$idvehiculo=$_GET['idvehiculo'];


echo "<div class='table-responsive'>
      <table class='table table-hover'>
        <thead class='text-success'>
          <tr>
            <th class='text-center'>#</th>
            <th>Concesionario</th>
            <th>Costo Mantenci&oacute;n</th>
            <th>Fecha Mantenci&oacute;n</th>
            <th>KM</th>
            <th>Detalle</th>
            <th>KM Prox. Mantenci&oacute;n</th>
            <th>Fecha Prox. Mantenci&oacute;n</th>
            <th>Informe</th>
          </tr>
        </thead>
        <tbody>";
			$sql="select concesionario, costo_mantencion, fecha_mantencion, km, detalle, km_proxima_mantencion, festimada_prox_mantencion, informe from mantenciones where idvehiculo=$idvehiculo";
			$rs = mssql_query ($sql,$connection);
			if(mssql_num_rows($rs)>0){
				$i=1; 
				while($row=mssql_fetch_array($rs)){
					$date = date_create($row['fecha_mantencion']);
					$fecha_mantencion=date_format($date, 'd-m-Y');
					
					$festimada_prox_mantencion=date_format(date_create($row['festimada_prox_mantencion']), 'd-m-Y');
					echo "	<tr>
							  <td class='text-center'>".$i."</td>
							  <td>".$row['concesionario']."</td>
							  <td class='text-right'>$".number_format($row['costo_mantencion'], 0, ',', '.')."</td>
							  <td class='text-center'>".$fecha_mantencion."</td>
							  <td class='text-right'>".number_format($row['km'], 0, ',', '.')."</td>
							  <td>".$row['detalle']."</td>
							  <td class='text-right'>".number_format($row['km_proxima_mantencion'], 0, ',', '.')."</td>
							  <td class='text-center'>".$festimada_prox_mantencion."</td>	
							  <td class='text-center'><a href='mantencion/".$row['informe']."' target='_blank'><i class='material-icons'>library_books</i></a></td>	
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