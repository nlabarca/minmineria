<?php
session_start();  
include ("include/conexion.php");
if($_SESSION['id_usuario']!=""){

}else{
	header("location:cerrar_session.php");
} 

$idmantencion=decrypt($_GET['id']);
$datos=dato_mantencion($idmantencion);

$datos_vehiculo=dato_vehiculo($datos['idvehiculo']);

/****opciones para menu****/
$op_principal=24; //Mantenciones
$op_secundaria=26; //Editar Mantención
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
            <a class="navbar-brand" href="#">Ver Mantenci&oacute;n</a>
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
		  <form action="mantencion/edit_mantencion.php?id=<?php echo encrypt($idmantencion);?>" method="post" enctype="multipart/form-data" class="form-horizontal" id="TypeValidation" name="TypeValidation" novalidate="novalidate">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-text">
					<div class="card-icon">
                    <i class="material-icons">directions_car</i>
                  </div>
                  <h4 class="card-title">Datos del Veh&iacute;culo</h4>
                  <p class="card-category">Complete los datos</p>
                </div>
                <div class="card-body">
                 	
                    <div class="row">
                      <div class="col-md-4">	
						  <div class="form-group">
								<label class="bmd-label-static">Regi&oacute;n (*)</label>
								<select name="sel_region" class="form-control" id="sel_region" required="true" aria-invalid="true" aria-required="true" disabled>
									<option selected value="">...</option>
									<?php
									$sql2="select * from region";
									$rs2 = mssql_query ($sql2,$connection);	
									while($row2=mssql_fetch_array($rs2)){
									?>
									<option value="<?php echo $row2['idregion'];?>" <?php if($datos_vehiculo['idregion']==$row2['idregion']) echo "selected"; ?>><?php echo utf8_encode($row2['nombre']);?></option>
									<?php }?>
								</select>
							</div>	
					  </div>
					  <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label-static">Veh&iacute;culo (*)</label>
                            <select name="sel_vehiculos" class="form-control" id="sel_vehiculos" required="true" aria-invalid="true" aria-required="true" onChange="javascript:datos_vehiculo();" disabled>
                                <option selected value="">...</option>
                                <?php
                                $sql1="select a.idvehiculo, b.descripcion as tipo_vehiculo from vehiculo a, tipo_vehiculo b 
                                        where a.idtipo_vehiculo=b.idtipo_vehiculo";
                                $rs1 = mssql_query ($sql1,$connection);	
                                while($row1=mssql_fetch_array($rs1)){
                                ?>
                                <option value="<?php echo $row1['idvehiculo'];?>" <?php if($datos['idvehiculo']==$row1['idvehiculo']) echo "selected";?>><?php echo $row1['tipo_vehiculo'];?></option>
                                <?php }?>	
                            </select>	
                        </div>
                      </div>	
                    </div>
					<br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
							<label class="bmd-label-static">Patente</label>
                           <input name="txt_patente" type="text" class="form-control" id="txt_patente" readonly="readonly"  aria-invalid="true" aria-required="true" value="<?php echo $datos_vehiculo['patente'];?>">
						</div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
							<label class="bmd-label-static">Marca</label>
                          	<input name="txt_marca" type="text" class="form-control" id="txt_marca" readonly="readonly" aria-invalid="true" aria-required="true" value="<?php echo $datos_vehiculo['marca'];?>">
						</div>
                   </div>
						 
						</div>
                    <div class="row">
					   <div class="col-md-6">
                        <div class="form-group">
						  <label class="bmd-label-static">Modelo</label>
                          	<input name="txt_modelo" type="text" class="form-control" id="txt_modelo" readonly="readonly" aria-invalid="true" aria-required="true" value="<?php echo $datos_vehiculo['modelo'];?>">
						</div>
                      </div>	
                      <div class="col-md-6">
                        <div class="form-group">
						  <label class="bmd-label-static">A&ntilde;o</label>
                          	<input name="txt_anio" type="text" class="form-control" id="txt_anio" readonly="readonly" aria-invalid="true" aria-required="true" value="<?php echo $datos_vehiculo['anio'];?>">
						</div>
                        
                      </div>
						
                     
                    </div>
                    
                    
                    <div class="clearfix"></div>
                  
                </div>
              </div>
            </div>
           
          </div>
			<div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-text">
					<div class="card-icon">
                    <i class="material-icons">build</i>
                  </div>
                  <h4 class="card-title">Datos de la Mantenci&oacute;n</h4>
                </div>
                <div class="card-body">
                <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-static">Concesionario (*)</label>
                          <input name="txt_concesionario" type="text" required="true" class="form-control" id="txt_concesionario" aria-invalid="true" aria-required="true" value="<?php echo $datos['concesionario'];?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-static">Costo de la manteci&oacute;n (*)</label>
                          <input name="txt_costo" type="text" class="form-control" id="txt_costo" required="true" aria-invalid="true" aria-required="true" value="<?php echo $datos['costo_mantencion'];?>" readonly>
						</div>
                      </div>
                      </div>
					  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                         <label class="bmd-label-static">Fecha de matenci&oacute;n (*)</label>
						 <?php
							$fecha_mantencion=date_format(date_create($datos['fecha_mantencion']), 'd-m-Y');
						  ?>		
    					 <input name="txt_fmantencion" type="text" required="true"  class="form-control  datepicker" id="txt_fmantencion" aria-invalid="true" aria-required="true" value="<?php echo $fecha_mantencion;?>" readonly/>
						</div>
						  
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-static">Kilometraje (*)</label>
                          <input name="txt_kilometraje" type="text" required="true" class="form-control" id="txt_kilometraje" aria-invalid="true" aria-required="true" value="<?php echo $datos['km'];?>" readonly>
						</div>
                      </div>
                      </div>
					 <div class="row">
					   <div class="col-md-12">
                    	<div class="form-group">
					    	<label class="bmd-label-static">Detalles de la mantenci&oacute;n (*)</label>
    						<div class="form-group bmd-form-group">
                            	<textarea name="txta_detalle" rows="5" class="form-control" id="txta_detalle" required="true" aria-invalid="true" aria-required="true" readonly><?php echo $datos['detalle'];?></textarea>
                          	</div>
						</div>
						</div>
					  </div>
					  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                         <label class="bmd-label-static">KM proxima mantenci&oacute;n (*)</label>
    					 <input name="txt_km_prox" type="text" required="true" class="form-control" id="txt_km_prox" aria-invalid="true" aria-required="true" value="<?php echo $datos['km_proxima_mantencion'];?>" readonly>
						</div>
						  
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-static">Fecha estimada proxima mantenci&oacute;n (*)</label>
						  <?php
							$festimada_prox_mantencion=date_format(date_create($datos['festimada_prox_mantencion']), 'd-m-Y');
						  ?>	
                          <input name="txt_fprox_mantencion" type="text" required="true"  class="form-control  datepicker" id="txt_fprox_mantencion" aria-invalid="true" aria-required="true" value="<?php echo $festimada_prox_mantencion;?>" readonly/>	
						</div>
                      </div>
                      </div>
                      <div class="row">
						<div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-static">Informe Mantenci&oacute;n (*)</label>
                          <input name="file_informe" type="text" class="form-control" id="file_informe" required="true" aria-invalid="true" aria-required="true" value="<?php echo $datos['informe'];?>" readonly>
						</div>
                      </div>
						  <div class="col-md-6">
							<div class="input-group">
								<a href="mantencion/<?php echo $datos['informe'];?>" target="_blank" class="btn btn-fab btn-round btn-round btn-primary"><i class="material-icons">pageview</i></a>
							</div>
							  </div>
					  </div>
				    <div class="clearfix"></div>
                 
					<div class="float-right">(*) Datos obligatorios.</div></div>
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
function del_informe(id){
	if(confirm("¿Esta seguro que desea eliminar?")){
		/*$.ajax({
				type: "POST",
				url: "vehiculos/del_vehiculo.php?id="+id,
				data: id,
				 beforeSend: function()
				{
					//$('#loading').show();
				},
				success: function() {
					location.reload(); 
				}
			});*/
			document.location.href="mantencion/del_informe_mantencion.php?id="+id;
		}
		return false;
	}	



		
  </script>	
</body>

</html>
