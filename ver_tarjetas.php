<?php
session_start();  
include ("include/conexion.php");
if($_SESSION['id_usuario']!=""){

}else{
	header("location:cerrar_session.php");
}
/****opciones para menu****/
$op_principal=13; //Tarjetas Combustibles
$op_secundaria=14; //Todas las Tarjetas
/**************************/
?>
<!doctype html>
<html lang="en">

<head>
  <title>Bit&aacute;cora de Veh&iacute;culos</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
</head>

<body>
  <div class="wrapper ">
    <?php include ("menu.php");?>	
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#">Todas las Tarjetas</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
         <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span  class="simple-text logo-normal"><?php echo utf8_encode($_SESSION['nom_usuario']);?></span> <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Perfil</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="cerrar_session.php">Cerrar Sesi&oacute;n</a>
                </div>
              </li>
            </ul>
          </div> 
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
					  <div class="card">
						<div class="card-header card-header-primary card-header-icon">
						  <div class="card-icon">
							<i class="material-icons">credit_card</i>
						  </div>
						  <h4 class="card-title">Tarjetas</h4>
						</div>
						<div class="card-body">
						  <div class="table-responsive">
							<table class="table table-hover">
							  <thead class="text-success">
								<tr>
								  <th class="text-center">#</th>
								  <th>N&deg; Tarjeta</th>
								  <th>Empresa</th>	
								  <th>Monto Inicial</th>
								  <th>Fecha de Vencimiento</th>
								  <th>Regi&oacute;n</th>
								  <th>Programa</th>	
								  <th>Responsable</th>
								  <th class="text-center">Actions</th>
								</tr>
							  </thead>
							  <tbody>
								<?php 
								if ($_SESSION['id_perfil']==2){
									$query=" and a.idregion=$_SESSION[region_usuario]";
								}
								  
								$sql="select idtarjeta, num_tarjeta, monto_inicial, fecha_vencimiento, b.descripcion as programa, responsable, c.nombre as region, a.empresa, a.idtipo_tarjeta 
									from tarjeta_combustible a, programa b, region c 
									where idestado=1
									and a.idprograma=b.idprograma
									and a.idregion=c.idregion".
									$query;
								$rs = mssql_query ($sql,$connection);
								if(mssql_num_rows($rs)>0){   
								$i=1; 
								while($row=mssql_fetch_array($rs)){
									$date = date_create($row['fecha_vencimiento']);
									$fecha_vencimiento=date_format($date, 'd-m-Y');
									
									if($row['idtipo_tarjeta']==1){
										$monto="$".number_format($row['monto_inicial'], 0, ',', '.');
									}
									if($row['idtipo_tarjeta']==2){
										$monto="T-Post Pago";
										$fecha_vencimiento="-";
									}
								?>	  
								<tr>
								  <td class="text-center"><?php echo $i;?></td>
								  <td><?php echo $row['num_tarjeta'];?></td>
								  <td><?php echo $row['empresa'];?></td>	
								  <td><?php echo $monto;?></td>
								  <td><?php echo $fecha_vencimiento;?></td>
								  <td><?php echo utf8_encode($row['region']);?></td>
								  <td><?php echo $row['programa'];?></td>
								  <td><?php echo $row['responsable'];?></td>
								  <td class="td-actions text-center">
									<button type="button" rel="tooltip" class="btn btn-info" data-original-title="" title="Ver" onClick="javascript:ver_tarjeta('<?php echo encrypt($row['num_tarjeta']);?>')">
									  <i class="material-icons">visibility</i>
									</button>
									<button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="Editar" onClick="javascript:edit_tarjeta('<?php echo encrypt($row['num_tarjeta']);?>')">
									  <i class="material-icons">edit</i>
									</button>  
									<button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="Eliminar" onClick="javascript:del_tarjeta(<?php echo $row['idtarjeta'];?>)">
									  <i class="material-icons">close</i>
									</button>
								  </td>
								</tr>
								<?php 
										$i++;
									}
								}else{?> 
								  <tr>
								  <td colspan="8" class="text-center">No hay resultados</td>
							    </tr>
								<?php }?>  
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
            		</div>
                 
           
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          
          <div class="copyright float-right">
           Amunátegui 232, Pisos 15, 16 y 17; Santiago - Chile / Teléfono: (562) 2 473 3000.
          </div>
          <!-- your footer here -->
        </div>
      </footer>
    </div>
  </div>
	<!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="assets/js/plugins/nouislider.min.js"></script>
 
  <!-- Library for adding dinamically elements -->
  <script src="assets/js/plugins/arrive.min.js"></script>
  <!-- Chartist JS -->
  <script src="assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
<script type="text/javascript">  
$(document).ready(function(){
	
});
	function ver_tarjeta(id){
		 document.location.href="tarjeta_ver.php?id="+id;
	}
	function edit_tarjeta(id){
		 document.location.href="tarjeta_edit.php?id="+id;
	}
	function del_tarjeta(id){
	if(confirm("¿Esta seguro que desea eliminar?")){
		$.ajax({
				type: "POST",
				url: "tarjeta/del_tarjeta.php?id="+id,
				data: id,
				 beforeSend: function()
				{
					//$('#loading').show();
				},
				success: function() {
					location.reload(); 
				}
			});
			/*document.form_solicitud.action="solicitud/eliminar_producto.php?idproducto="+id+"&idsolicitud="+id_solicitud;
			document.form_solicitud.method="post";
			document.form_solicitud.submit();*/
		}
		return false;
	}
</script>	
</body>

</html>
