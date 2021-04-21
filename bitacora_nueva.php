<?php
session_start();  
include ("include/conexion.php");
if($_SESSION['id_usuario']!=""){

}else{
	header("location:cerrar_session.php");
} 

$rut_conductor=number_format($_SESSION['id_usuario'], 0, ',', '.');

$sql_id="select idconductor from conductor where rut like '%$rut_conductor%'";   
$rs_id = mssql_query ($sql_id,$connection);	
$row_id=mssql_fetch_array($rs_id);
$idconductor=$row_id['idconductor'];

$id=decrypt($_GET['id']);
$datos=dato_conductor($id);

$idvehiculo=decrypt($_GET['idvehiculo']);
$mes=decrypt($_GET['mes']);
$anio=decrypt($_GET['anio']);
$periodo=decrypt($_GET['periodo']);

if($anio==""){
	$anio=date('Y');
}

if($mes==""){
	$mes=date('m');
}
if($periodo==""){
	$periodo=1;
}


$datos=dato_vehiculo($idvehiculo);
$patente=$datos['patente'];

/****opciones para menu****/
$op_principal=19; //Bitacoras
$op_secundaria=23; //Añadir Bitacora
/**************************/

if(decrypt($_GET['ms'])==1){
	$onload="showNotification('top','center', 1)";
}
if(decrypt($_GET['ms'])==2){
	$onload="showNotification('top','center', 2)";
}
if(decrypt($_GET['ms'])==3){
	$onload="showNotification('top','center', 3)";
}
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

<body onLoad="javascript:carga_tabla_bitacora();<?php echo $onload;?>">
  <div class="wrapper ">
    <?php include ("menu.php");?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#">Añadir Bitacora</a>
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
		  <form action="bitacora/add_bitacora.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="TypeValidation" name="TypeValidation" novalidate="novalidate">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-text">
					<div class="card-icon">
                    <i class="material-icons">create</i>
                  </div>
                  <h4 class="card-title">Datos de la Bitacora</h4>
                  <p class="card-category">Complete los datos</p>
                </div>
                <div class="card-body">
                 	
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
							<label class="bmd-label-static"><i class="material-icons">date_range</i> Mes (*)</label>
							<select name="sel_mes" class="form-control" id="sel_mes" required="true" aria-invalid="true" aria-required="true" onChange="javascript:carga_tabla_bitacora();">
								<option selected value="">...</option>
								<option value="1" <?php if($mes==1) echo "selected";?>>Enero</option>
								<option value="2" <?php if($mes==2) echo "selected";?>>Febrero</option>
								<option value="3" <?php if($mes==3) echo "selected";?>>Marzo</option>
								<option value="4" <?php if($mes==4) echo "selected";?>>Abril</option>
								<option value="5" <?php if($mes==5) echo "selected";?>>Mayo</option>
								<option value="6" <?php if($mes==6) echo "selected";?>>Junio</option>
								<option value="7" <?php if($mes==7) echo "selected";?>>Julio</option>
								<option value="8" <?php if($mes==8) echo "selected";?>>Agosto</option>
								<option value="9" <?php if($mes==9) echo "selected";?>>Septiembre</option>
								<option value="10" <?php if($mes==10) echo "selected";?>>Octubre</option>
								<option value="11" <?php if($mes==11) echo "selected";?>>Noviembre</option>
								<option value="12" <?php if($mes==12) echo "selected";?>>Diciembre</option>
							</select>
						</div>
                      </div>
					  <div class="col-md-3">
                        <div class="form-group">
						  <label class="bmd-label-static"><i class="material-icons">insert_invitation</i> Año (*)</label>
							<select name="sel_anio" class="form-control" id="sel_anio" required="true" aria-invalid="true" aria-required="true" onChange="javascript:carga_tabla_bitacora();">
								<option selected value="">...</option>
								<option value="2021" <?php if($anio==2021) echo "selected";?>>2021</option>
								<option value="2020" <?php if($anio==2020) echo "selected";?>>2020</option>
								<option value="2019" <?php if($anio==2019) echo "selected";?>>2019</option>
							</select>
						</div>
                      </div>	
					  <div class="col-md-3">
                        <div class="form-group">
						  <label class="bmd-label-static"><i class="material-icons">insert_invitation</i> Periodo (*)</label>
							<select name="sel_periodo" class="form-control" id="sel_periodo" required="true" aria-invalid="true" aria-required="true" onChange="javascript:carga_tabla_bitacora();">
								<option selected value="">...</option>
								<option value="1" <?php if($periodo==1) echo "selected";?>>1&deg; Quincena</option>
								<option value="2" <?php if($periodo==2) echo "selected";?>>2&ordf; Quincena</option>
							</select>
						</div>
                      </div>		
					</div>
					<div class="row">
                    	<div class="col-md-4">
                        	<div class="form-group bmd-form-group">
                          		<label class="bmd-label-static"><i class="material-icons">directions_car</i> Veh&iacute;culo (*)</label>
                          		<select name="sel_vehiculos" class="form-control" id="sel_vehiculos" required="true" aria-invalid="true" aria-required="true" onChange="javascript:datos_vehiculo();">
									<option selected value="">...</option>
									<?php
									if ($_SESSION['id_perfil']==2){ 
										$query=" and a.idregion=$_SESSION[region_usuario]";
										$tabla="";
									}
									if ($_SESSION['id_perfil']==3){ 
										$query=" and a.idregion=$_SESSION[region_usuario] 
										and a.idvehiculo=c.idvehiculo 
										and c.idconductor=$idconductor";
										$tabla=", vehiculos_conductor c";
									}

									
									
									
									$sql1="select a.idvehiculo, b.descripcion as tipo_vehiculo, a.patente from vehiculo a, tipo_vehiculo b".$tabla."
											where a.idtipo_vehiculo=b.idtipo_vehiculo".
											$query;
									$rs1 = mssql_query ($sql1,$connection);	
									while($row1=mssql_fetch_array($rs1)){
									?>
									<option value="<?php echo $row1['idvehiculo'];?>" <?php if($idvehiculo==$row1['idvehiculo']) echo "selected";?>><?php echo $row1['tipo_vehiculo'];?>-<?php echo $row1['patente'];?></option>
									<?php }?>	
					  			</select>	
							</div>
						</div>
						<div class="col-md-4">
                        	<div class="form-group">
                          		<label class="bmd-label-static"><i class="material-icons">calendar_view_day</i> Patente </label>
                          		<input name="txt_patente" type="text" class="form-control" id="txt_patente" readonly="readonly" value="<?php echo $patente;?>">
							</div>
						</div>
						<div class="col-md-4">
                        	<div class="form-group bmd-form-group">
						  		<label class="bmd-label-static"><i class="material-icons">face</i> Conductor (*)</label>
                          		<select name="sel_conductor" class="form-control" id="sel_conductor" required="true" aria-invalid="true" aria-required="true">
									<option selected value="">...</option>
									<?php
									if ($_SESSION['id_perfil']==2){ 
										$query=" where idregion=$_SESSION[region_usuario]";
									}
									if ($_SESSION['id_perfil']==3){ 
										$query=" where idregion=$_SESSION[region_usuario] and idconductor=$idconductor";
									}
									
									$sql2="select * from conductor".$query;
									$rs2 = mssql_query ($sql2,$connection);	
									while($row2=mssql_fetch_array($rs2)){
									?>
									<option value="<?php echo $row2['idconductor'];?>" <?php if($row2['idconductor']==$idconductor) echo "selected";?>><?php echo $row2['nombres'].' '.$row2['apellidos'];?></option>
									<?php }?>	
					  			</select>	
							</div>
					 	</div>
              		</div>	
					<div class="row">
						<div class="col-md-3">
                        	<div class="form-group bmd-form-group">
                          		<label class="bmd-label-static"><i class="material-icons">credit_card</i> Tarjeta de Combustible (*)</label>
                          		<select name="sel_tarjeta" class="form-control" id="sel_tarjeta" required="true" aria-invalid="true" aria-required="true" onChange="javascript:datos_tarjeta();">
									<option selected value="">...</option>
									<?php
									if ($_SESSION['id_perfil']==2 || $_SESSION['id_perfil']==3){ 
										$query=" where idregion=$_SESSION[region_usuario]";
									}
									
									$sql3="select * from tarjeta_combustible".$query;
									$rs3 = mssql_query ($sql3,$connection);	
									while($row3=mssql_fetch_array($rs3)){
									?>
									<option value="<?php echo $row3['num_tarjeta'];?>"><?php echo $row3['num_tarjeta'];?></option>
									<?php }?>	
					  			</select>	
								<input name="txt_tipo_tarjeta" type="hidden" id="txt_tipo_tarjeta" value="">
							</div>
						</div>
                    	<div class="col-md-3">
							<div class="form-group">
						  		<label class="bmd-label-static"><i class="material-icons">attach_money</i> Monto Combustible (*)</label>
                          		<input name="txt_monto" type="text" class="form-control" id="txt_monto" number="true" required="true" aria-invalid="true" aria-required="true" onKeyUp="format(this)" onChange="format(this)" onBlur="saldo_tarjeta()">
							</div>
                      	</div>
                    	<div class="col-md-3">
                        	<div class="form-group">
                          		<label class="bmd-label-static"><i class="material-icons">local_gas_station</i> Litros de Combustible (*)</label>
                          		<input name="txt_combustible" type="text" class="form-control" id="txt_combustible" number="true" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div>
                    	<div class="col-md-3">
                        	<div class="form-group">
                          		<label class="bmd-label-static"><i class="material-icons">attach_money</i> Saldo Tarjeta</label>
                          		<input name="txt_saldo" type="text" class="form-control" id="txt_saldo" readonly="readonly">
							</div>
						</div>
					</div>	
                    <div class="row">
						<div class="col-md-3">
                        	<div class="form-group">
                          		<label class="bmd-label-static"><i class="material-icons">calendar_today</i> Fecha Inicio de Viaje (*)</label>
                          		<input name="txt_finicio" type="text" class="form-control datepicker" id="txt_finicio" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div>	
                      	<div class="col-md-3">
                        	<div class="form-group">
								<label class="bmd-label-static"><i class="material-icons">my_location</i> Lugar de Inicio de Trayecto (*)</label>
                           		<input name="txt_lugar_inicio" type="text" class="form-control" id="txt_lugar_inicio" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div>
                      	<div class="col-md-3">
                        	<div class="form-group">
						  		<label class="bmd-label-static"><i class="material-icons">access_time</i> Hora de Salida (*)</label>
                           		<input name="txt_hora_salida" type="text" class="form-control timepicker" id="txt_hora_salida" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div>
                      	<div class="col-md-3">
                        	<div class="form-group">
                          		<label class="bmd-label-static"><i class="material-icons">speed</i> KM de Salida (*)</label>
                          		<input name="txt_km_salida" type="text" class="form-control" id="txt_km_salida" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div>
                    </div>	
                    <div class="row">
                    	<div class="col-md-3">
                        	<div class="form-group">
						  		<label class="bmd-label-static"><i class="material-icons">calendar_today</i> Fecha Termino de Viaje (*)</label>
                           		<input name="txt_ftermino" type="text" class="form-control datepicker" id="txt_ftermino" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div>
						<div class="col-md-3">
                        	<div class="form-group">
						  		<label class="bmd-label-static"><i class="material-icons">my_location</i> Lugar de Termino de Trayecto (*)</label>
                           		<input name="txt_lugar_termino" type="text" class="form-control" id="txt_lugar_termino" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div> 
						<div class="col-md-3">
                        	<div class="form-group">
						  		<label class="bmd-label-static"><i class="material-icons">access_time</i> Hora de Llegada (*)</label>
                           		<input name="txt_hora_llegada" type="text" class="form-control timepicker" id="txt_hora_llegada" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div>  
                      	<div class="col-md-3">
                        	<div class="form-group">
                          		<label class="bmd-label-static"><i class="material-icons">speed</i> KM de Llegada (*)</label>
                          		<input name="txt_km_llegada" type="text" class="form-control" id="txt_km_llegada" required="true" aria-invalid="true" aria-required="true">
							</div>
                      	</div>
                    </div>	
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                          <label><i class="material-icons">notes</i> Detalle del Recorrido (*)</label>
                          <div class="form-group bmd-form-group">
                            <textarea name="txta_detalle" rows="5" class="form-control" id="txta_detalle" required="true" aria-invalid="true" aria-required="true"></textarea>
                          </div>
                        </div>
                      </div>
                      </div>
					  <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-static"><i class="material-icons">group_add</i> Pasajeros</label>
                          <select name="sel_pasajeros" class="form-control" id="sel_pasajeros" aria-invalid="true" aria-required="true">
								<option selected value="">...</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
						  </select>
						</div>
						   
                      </div>
                      </div>	
                     <button type="submit" class="btn btn-primary pull-right" >Guardar<div class="ripple-container"></div></button>
					
					 <div class="clearfix"></div>
                 
					<div class="float-right">(*) Datos obligatorios.</div>
                  
                </div>
              </div>
            </div>
           
          </div>
			
		  <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-text">
					<div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Detalle de Viajes</h4>
                </div>
                <div class="card-body">
					 <div class="row">
					   <div class="col-md-12">
						    <div class="card">
						<div class="card-body">
						<div id="tabla_bitacora">	
                    	<div class="table-responsive">
							<table class="table">
							  <thead class="text-success">
								<tr>
								  <th class="text-center">#</th>
								  <th>Veh&iacute;culo</th>
								  <th>Patente</th>
								  <th>Conductor</th>
								  <th class="text-center">Monto Combustible</th>
								  <th class="text-center">Lts. Combustible</th>
								  <th class="text-center">N&deg; Tarjeta</th>
								  <th class="text-center">Fec. Inicio Viaje</th>
								  <th class="text-center">Lugar  Inicio Viaje</th>
								  <th class="text-center">Hr. Salida</th>
								  <th class="text-center">KM  Salida</th>
								  <th class="text-center">Fec. Termino Viaje</th>
								  <th class="text-center">Lugar Termino Viaje</th>
								  <th class="text-center">Hr. Llegada</th>
								  <th class="text-center">KM Llegada</th>
								  <!--<th class="text-center">Detalle Recorrido</th>-->
								  <th class="text-center">Pasajeros</th>
								  <th class="text-right">Actions</th>
								</tr>
							  </thead>
							  <tbody>
								
								  <tr>
								  <td colspan="17" class="text-center">No hay resultados</td>
								  </tr>
							  </tbody>
							</table>
						  </div>
						  </div>	
							</div>
								</div>
						</div>
					  </div>
                   
                    
                    
					
					 <div class="clearfix"></div>
                 
					
					
                </div>
				  
              </div>
            </div>
            
          </div>	
        </div>
		</form>
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
	
	<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
		
      // initialise Datetimepicker and Sliders
      md.initFormExtendedDatetimepickers();
      if ($('.slider').length != 0) {
        md.initSliders();
      }

		
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
		
		
		
		
		
		 // FileInput
    $('.form-file-simple .inputFileVisible').click(function() {
      $(this).siblings('.inputFileHidden').trigger('click');
    });

    $('.form-file-simple .inputFileHidden').change(function() {
      var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
      $(this).siblings('.inputFileVisible').val(filename);
    });

    $('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function() {
      $(this).parent().parent().find('.inputFileHidden').trigger('click');
      $(this).parent().parent().addClass('is-focused');
    });

    $('.form-file-multiple .inputFileHidden').change(function() {
      var names = '';
      for (var i = 0; i < $(this).get(0).files.length; ++i) {
        if (i < $(this).get(0).files.length - 1) {
          names += $(this).get(0).files.item(i).name + ',';
        } else {
          names += $(this).get(0).files.item(i).name;
        }
      }
      $(this).siblings('.input-group').find('.inputFileVisible').val(names);
    });

    $('.form-file-multiple .btn').on('focus', function() {
      $(this).parent().siblings().trigger('focus');
    });

    $('.form-file-multiple .btn').on('focusout', function() {
      $(this).parent().siblings().trigger('focusout');
    });
  

		
    });
	 
  </script>
	<script>
   function setFormValidation(id) {
      $(id).validate({
        highlight: function(element) {
          $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
          $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
        },
        success: function(element) {
          $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
          $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
        },
        errorPlacement: function(error, element) {
          $(element).closest('.form-group').append(error);
        },
      });
    }

    $(document).ready(function() {
      setFormValidation('#TypeValidation');
      
    });


function datos_vehiculo(){
	var idvehiculo=$("#sel_vehiculos").val();
	$.ajax({
		type: "POST",
		url: "vehiculos/datos_vehiculo.php?idvehiculo="+idvehiculo,
		data: idvehiculo,
		beforeSend: function()
		{
			//$('#loading').show();
		},
		success: function(data) {
			var elem = data.split('|');
			var patente = elem[0];
			
			$("#txt_patente").val(patente);
		}
	});
	carga_tabla_bitacora();
}		
function datos_tarjeta(){
	 var id=$("#sel_tarjeta").val();
	 $.ajax({
		  type: "POST",
		  url: "tarjeta/datos_tarjeta.php?id="+id,
		  data: id,
		   beforeSend: function()
		  {
			  //$('#loading').show();
		  },
		  success: function(data) {
			  var elem = data.split('|');
			  var saldo_tarjeta = elem[8];
			  var tipo_tarjeta = elem[9];
			  
			$("#txt_saldo").val(saldo_tarjeta);
			$("#txt_tipo_tarjeta").val(tipo_tarjeta);  
		}
	  });
}		
function format(input)
{
var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
input.value = num;
}
 
//else{ alert('Solo se permiten numeros');
//input.value = input.value.replace(/[^\d\.]*/g,'');
//}
}

function carga_tabla_bitacora(){
	var idvehiculo=$("#sel_vehiculos").val();
	var mes=$("#sel_mes").val();
	var anio=$("#sel_anio").val();
	var periodo=$("#sel_periodo").val();
	$.ajax({
		type: "POST",
		url: "bitacora/carga_tabla_bitacora.php?idvehiculo="+idvehiculo+"&mes="+mes+"&anio="+anio+"&periodo="+periodo,
		data: mes,
 		beforeSend: function()
		{
    		//$('#loading').show();
		},
		success: function(data) {
  			$("#tabla_bitacora").html(data);
		}
	});
}		
function del_bitacora(idbitacora){
	/*if(confirm("¿Esta seguro que desea eliminar?")){
		$.ajax({
				type: "POST",
				url: "bitacora/del_bitacora.php?id="+idbitacora,
				data: idbitacora,
				 beforeSend: function()
				{
					//$('#loading').show();
				},
				success: function() {
					//location.reload(); 
					carga_tabla_bitacora();  
				}
			});*/
		//document.location.href="conductor/del_vehiculo.php?id="+id+"&idconductor="+idconductor;
			/*document.form_solicitud.action="solicitud/eliminar_producto.php?idproducto="+id+"&idsolicitud="+id_solicitud;
			document.form_solicitud.method="post";
			document.form_solicitud.submit();*/
		/*}
		return false;*/
	swal({
          title: "¿Esta seguro que desea eliminar?",
          text: "¡Se eliminará permanentemente!",
          icon: "warning",
          buttons: [
            'No, cancelar',
            'Sí, estoy serguro'
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
          if (isConfirm) {
            swal({
              title: 'Eliminado',
              text: '¡El registro ha sido eliminado!',
              icon: 'success'
            }).then(function() {
              	$.ajax({
					type: "POST",
					url: "bitacora/del_bitacora.php?id="+idbitacora,
					data: idbitacora,
				 	beforeSend: function()
					{
						//$('#loading').show();
					},
					success: function() {
						//location.reload(); 
						carga_tabla_bitacora();  
					}
				});
            });
          } else {
            //swal("Cancelled", "Your imaginary file is safe :)", "error");
			swal.close();  
          }
     })
}
function saldo_tarjeta(){
	var monto=$("#txt_monto").val();
	var saldo=$("#txt_saldo").val();
	var tipo_tarjeta=$("#txt_tipo_tarjeta").val();
	
	monto=monto.replace(".", "");
	monto=monto.replace(".", "");
	saldo=saldo.replace(".", "");
	
	if(tipo_tarjeta==1){
		if(parseInt(monto)>parseInt(saldo)){
			alert("Saldo de tarjeta insuficiente");
			$("#sel_tarjeta").val("");
			$("#txt_monto").val("");
		}
	}
	
}
function showNotification(from, align, ms){
    if(ms==1){ 
        $.notify({
            icon: "check_circle",
            message: "El viaje se ha registrado exitosamente!"
        },{
            type:'success',
            timer: 3000,
            placement: {
                from: from,
                align: align
            }
        });
    }
	if(ms==2){ 
        $.notify({
            icon: "check_circle",
            message: "La Bitacora de este mes esta cerrada"
        },{
            type:'danger',
            timer: 3000,
            placement: {
                from: from,
                align: align
            }
        });
    }
    if(ms==3){ 
        $.notify({
            icon: "info",
            message: "La consulta ha fallado!"
        },{
            type:'warning',
            timer: 3000,
            placement: {
                from: from,
                align: align
            }
        });
    }
}			
  </script>	
</body>

</html>
