<?php
session_start();  
include ("include/conexion.php");
if($_SESSION['id_usuario']!=""){

}else{
	header("location:cerrar_session.php");
} 
$id=decrypt($_GET['id']);
$datos=dato_conductor($id);

/****opciones para menu****/
$op_principal=29; //Reportes
$op_secundaria=30; //Historial Tarjetas
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
            <a class="navbar-brand" href="#">Historial Tarjeta</a>
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
		  <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal" id="TypeValidation" name="TypeValidation" novalidate="novalidate">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary card-header-text">
					<div class="card-icon">
                    <i class="material-icons">credit_card</i>
                  </div>
                  <h4 class="card-title">Datos de la Tarjeta</h4>
                  <p class="card-category">Complete los datos</p>
                </div>
                <div class="card-body">
                 	
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
							<label class="bmd-label-static">Nº Tarjeta (*)</label>
							<select name="sel_tarjeta" class="form-control" id="sel_tarjeta" required="true" aria-invalid="true" aria-required="true" onChange="javascript:cargadatos_tarjeta();">
                                <option selected value="">...</option>
                                <?php
								if ($_SESSION['id_perfil']==2 || $_SESSION['id_perfil']==4){ 
                                    $query=" where idregion=$_SESSION[region_usuario]";
                                }
                                $sql3="select * from tarjeta_combustible".$query;
                                $rs3 = mssql_query ($sql3,$connection);	
                                while($row3=mssql_fetch_array($rs3)){
                                ?>
                                <option value="<?php echo $row3['num_tarjeta'];?>"><?php echo $row3['num_tarjeta'];?></option>
                                <?php }?>	
                            </select>
						</div>
                      </div>
                    </div>
					<div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-static">Monto Inicial</label>
                          <input name="txt_monto" type="text" class="form-control" id="txt_monto" readonly value="<?php echo $datos['monto_inicial'];?>">
						</div>
						   
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-static">Fecha de Vencimiento</label>
                          <?php
							if($datos['fvencimiento']!=""){
								$date = date_create($datos['fvencimiento']);
								$fvencimiento=date_format($date, 'd-m-Y');
							}
							?>	
						<input name="txt_fvencimiento" type="text" class="form-control" id="txt_fvencimiento" value="<?php echo $fvencimiento;?>" readonly />
						</div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
							<label class="bmd-label-static">Regi&oacute;n</label>
							<input name="txt_idregion" type="hidden" id="txt_idregion">	
                          	<input name="txt_region" type="text" class="form-control" id="txt_region" readonly value="<?php echo $datos['region'];?>">
						</div>
                      </div>
					</div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
							<label class="bmd-label-static">Programa</label>
                           <input name="txt_programa" type="text" class="form-control" id="txt_programa" readonly value="<?php echo $datos['programa'];?>">
						</div>
                      </div>	
                      <div class="col-md-4">
                        <div class="form-group bmd-form-group">
						  <label class="bmd-label-static">Responsable</label>
						  <input name="txt_responsable" type="text" class="form-control" id="txt_responsable" readonly value="<?php echo $datos['responsable'];?>">
						</div>
                   	  </div>
					  <div class="col-md-4">
                        <div class="form-group bmd-form-group">
						  <label class="bmd-label-static">Saldo Tarjeta</label>
						  <input name="txt_saldo" type="text" class="form-control" id="txt_saldo" readonly >
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
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Detalle Tarjeta</h4>
                </div>
                <div class="card-body">
                	<div class="row">
					   <div class="col-md-12">
						    <div class="card">
						<div class="card-body">
						<div id="tabla_tarjeta">	
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
								  <th class="text-center">Fec. Inicio Viaje</th>
								  <th class="text-center">Lugar  Inicio Viaje</th>
								  <th class="text-center">Pasajeros</th>
								</tr>
							  </thead>
							  <tbody>
							
								  
								  <tr>
								  <td colspan="9" class="text-center">No hay resultados</td>
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


function cargadatos_tarjeta(){
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
			  var num_tarjeta = elem[0];
			  var monto_inicial = elem[1];
			  var fvencimiento = elem[2];
			  var region = elem[3];
			  var programa = elem[4];
			  var responsable = elem[5];
			  var idregion = elem[6];
			  var idtarjeta = elem[7];
			  var saldo = elem[8];
		
			$("#txt_num_tarjeta").val(num_tarjeta);
			$("#txt_monto").val(monto_inicial);  
			$("#txt_fvencimiento").val(fvencimiento);  
			$("#txt_region").val(region);  
			$("#txt_programa").val(programa); 
			$("#txt_responsable").val(responsable); 
			$("#txt_idregion").val(idregion);  
			$("#txt_idtarjeta").val(idtarjeta);
			$("#txt_saldo").val(saldo);  
		  }
	  });
	carga_tabla_tarjeta();
}
function carga_tabla_tarjeta(){
	var num_tarjeta=$("#sel_tarjeta").val();
	$.ajax({
		type: "POST",
		url: "tarjeta/carga_tabla_historial.php?num_tarjeta="+num_tarjeta,
		data: num_tarjeta,
 		beforeSend: function()
		{
    		//$('#loading').show();
		},
		success: function(data) {
  			$("#tabla_tarjeta").html(data);
		}
	});
}				
  </script>	
</body>

</html>
