<?php
session_start();  
include ("include/conexion.php");
if($_SESSION['id_usuario']!=""){

}else{
	header("location:cerrar_session.php");
} 
/****opciones para menu****/
$op_principal=19; //Bitacoras
$op_secundaria=20; //Todas las Bitacoras
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
	<link href="assets/css/fileinput.css" rel="stylesheet" type="text/css" />
</head>
<body onLoad="<?php echo $onload;?>">
  <div class="wrapper ">
    <?php include ("menu.php");?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#">Todas las Bitacoras</a>
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
							<i class="material-icons">assignment</i>
						  </div>
						  <h4 class="card-title">Bitacoras</h4>
						</div>
						<div class="card-body">
						  <div class="table-responsive">
							<table class="table table-hover">
							  <thead class="text-success">
								<tr>
								  <th class="text-center">#</th>
								  <th>Mes</th>
								  <th>Periodo</th>	
								  <th>A&ntilde;o</th>
								  <th>Tipo Veh&iacute;culo</th>
								  <th>Patente</th>
								  <th>Regi&oacute;n</th>
								  <th class="text-center">Documento</th>	
								  <th>Estado</th>
								  <th class="text-center">Actions</th>
								</tr>
							  </thead>
							  <tbody>
								<?php 
								if ($_SESSION['id_perfil']==2 || $_SESSION['id_perfil']==3 || $_SESSION['id_perfil']==4){
									$query=" and b.idregion=$_SESSION[region_usuario]";
								}  
								$sql="select a.idvehiculo, a.folio_bitacora, a.mes, a.anio, c.descripcion as tipo_vehiculo, b.patente, d.nombre as region, a.docto_adjunto, a.estado, a.periodo 
									from bitacora_mensual a, vehiculo b, tipo_vehiculo c, region d
									where a.idvehiculo=b.idvehiculo
									and b.idtipo_vehiculo=c.idtipo_vehiculo
									and b.idregion=d.idregion".
									$query;
								$rs = mssql_query ($sql,$connection);
								if(mssql_num_rows($rs)>0){    
								$i=1; 
								while($row=mssql_fetch_array($rs)){
									if($row['periodo']==1){$periodo="1&deg; Quincena";}
									if($row['periodo']==2){$periodo="2&ordf; Quincena";}
								?>	  
								<tr>
								  <td class="text-center"><?php echo $i;?></td>
								  <td><?php echo mes($row['mes']);?></td>
								  <td><?php echo $periodo;?></td>
								  <td><?php echo $row['anio'];?></td>
								  <td><?php echo $row['tipo_vehiculo'];?></td>
								  <td><?php echo $row['patente'];?></td>
								  <td><?php echo utf8_encode($row['region']);?></td>
								  <td class="text-center"> <span id="mensaje<?php echo $row['folio_bitacora'];?>">
									  <?php if($row['docto_adjunto']==""){
									  			echo "Sin Documento";
											}else{ ?>
												<a href="bitacora/<?php echo $row['docto_adjunto'];?>" target="_blank"><i class='material-icons'>library_books</i></a>
									 		<?php }?>
									  </span>
									  </td>
								  <td><?php echo estado($row['estado']);?></td>
								  <td class="td-actions text-center">
									<?php if(menu(23, $_SESSION['id_perfil'])==1){?>   
									<?php if($row['docto_adjunto']==""){?>  
									<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal" rel="tooltip" title="Adjuntar Hoja de Ruta" onClick="javascript:up_bitacora('<?php echo encrypt($row['folio_bitacora']);?>')"><i class="material-icons">attach_file</i></button>  
									<?php }
									}?>   
									<button type="button" rel="tooltip" class="btn btn-info" data-original-title="" title="Ver" onClick="javascript:ver_bitacora('<?php echo encrypt($row['folio_bitacora']);?>')">
									  <i class="material-icons">visibility</i>
									</button>
									<?php if(menu(22, $_SESSION['id_perfil'])==1){?>    
									<?php if($row['estado']==2){?>  
									<button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="Visar Bitacora" onClick="javascript:visar_bitacora('<?php echo encrypt($row['folio_bitacora']);?>')">
									  <i class="material-icons">assignment_turned_in</i>
									</button>
									<?php }?>
									<?php }?>  
								  </td>
								</tr>
								<?php 
										$i++;
									}
								}else{?> 
								  <tr>
								  <td colspan="9" class="text-center">No hay resultados</td>
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
	<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subir Documento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form method="POST" action="#" enctype="multipart/form-data">
	<!-- COMPONENT START -->
	<div class="form-group">
		<div class="input-group input-file" name="Fichier1">
    		<input type="text" class="form-control" placeholder='Choose a file...' />			
            <span class="input-group-btn">
        		<button class="btn btn-default btn-choose" type="button">Choose</button>
    		</span>


		</div>
	</div>
	<!-- COMPONENT END -->
	<div class="form-group">
		<button type="submit" class="btn btn-primary pull-right" disabled>Submit</button>
		<button type="reset" class="btn btn-danger">Reset</button>
	</div>
</form>
						
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
	<!-- Fin Modal -->
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
	 $("#docto_bitacora").fileinput({
        showPreview: false,
        showUpload: false,
        elErrorContainer: '#kartik-file-errors',
        allowedFileExtensions: ["jpg", "png", "gif"]
    });
	
	 
});		 	
	
function docto_folio(folio){
	$("#folio_bitacora").val(folio);
}

function subir_docto(){
	var id=$("#folio_bitacora").val();
	
	var formData = new FormData(document.getElementById("form_docto"));
	alert(formData);
	formData.append("dato", "valor");
	$.ajax({
		url: "bitacora/sube_bitacora.php?id="+id,
		type: "post",
		dataType: "html",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	})
	.done(function(res){
		$("#mensaje"+id).html(res);
	});
}	
	
	function ver_bitacora(folio_bitacora){
		 document.location.href="revisar_bitacora.php?id="+folio_bitacora;
	}
	function up_bitacora(folio_bitacora){
		 document.location.href="revisar_bitacora.php?id="+folio_bitacora+"&up=1";
	}
	function visar_bitacora(folio_bitacora){
		 document.location.href="revisar_bitacora.php?id="+folio_bitacora+"&visar=1";
	}
function showNotification(from, align, ms){
    if(ms==1){ 
        $.notify({
            icon: "add_alert",
            message: "El documento se ha <b>adjuntado</b> exitosamente!"
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
            icon: "add_alert",
            message: "La bitacora se ha <b>Aprobado</b> exitosamente!"
        },{
            type:'success',
            timer: 3000,
            placement: {
                from: from,
                align: align
            }
        });
    }
	if(ms==3){ 
        $.notify({
            icon: "add_alert",
            message: "La bitacora se ha <b>Rechazado</b> exitosamente!"
        },{
            type:'success',
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
