<div class="sidebar" data-color="green" data-background-color="white" data-image="assets/img/sidebar-4.jpg">
<!--
Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

Tip 2: you can also add an image using data-image tag
-->
<div class="logo">
	<a href="#" class="simple-text logo-mini">
	<!--<img src="assets/img/logo_ministerio_full.jpg" width="120" height="109" alt=""/> </a>-->
	<a href="#" class="simple-text logo-normal">Bit&aacute;cora de Veh&iacute;culos</a>
</div>
<div class="sidebar-wrapper">
	<ul class="nav">
		<?php if(menu(1, $_SESSION['id_perfil'])==1){?> 
  		<li class="nav-item <?php if($op_principal==1) echo "active";?>">
    		<a class="nav-link" href="dashboard.php">
      			<i class="material-icons">dashboard</i><p>Dashboard</p>
    		</a>
  		</li>
		<?php }?> 
		<?php if(menu(2, $_SESSION['id_perfil'])==1){?> 
    	<li class="nav-item  <?php if($op_principal==2) echo "active";?>">
			<a class="nav-link <?php if($op_principal!=2){ echo "collapsed";}else{ echo "";}?>" data-toggle="collapse" href="#pagesExamples" aria-expanded="true">
				<i class="material-icons">directions_car</i><p>Vehiculos<b class="caret"></b></p>
			</a>
			<div class="collapse <?php if($op_principal==2) echo "show";?>" id="pagesExamples" style="">
				<ul class="nav">
					<?php if(menu(3, $_SESSION['id_perfil'])==1){?>   
						<li class="nav-item <?php if($op_secundaria==3) echo "active";?>">
				  			<a class="nav-link" href="ver_vehiculos.php">
								<i class="material-icons">view_list</i>
								<span class="sidebar-normal">Todos los Veh&iacute;culos</span>
				  			</a>
						</li>
					<?php }?>   
					<?php if(menu(6, $_SESSION['id_perfil'])==1){?>     
				  		<li class="nav-item <?php if($op_secundaria==6) echo "active";?>">
				  			<a class="nav-link" href="vehiculo_nuevo.php">
								<i class="material-icons">note_add</i>
								<span class="sidebar-normal">A&ntilde;adir Veh&iacute;culo</span>
				  			</a>
						</li>
					<?php }?>  
			  	</ul>
			</div>
		</li>
		<?php }?>
		<!-- CONDUCTORES -->
  		<?php if(menu(7, $_SESSION['id_perfil'])==1){?>   	
   		<li class="nav-item  <?php if($op_principal==7) echo "active";?>">
    		<a class="nav-link <?php if($op_principal!=7){ echo "collapsed";}else{ echo "";}?>" data-toggle="collapse" href="#pagesConductores" aria-expanded="true">
      			<i class="material-icons">person</i>
      			<p>Conductores<b class="caret"></b></p>
    		</a>
    		<div class="collapse <?php if($op_principal==7) echo "show";?>" id="pagesConductores" style="">
				<ul class="nav">
					<?php if(menu(8, $_SESSION['id_perfil'])==1){?>    
						<li class="nav-item <?php if($op_secundaria==8) echo "active";?>">
				  			<a class="nav-link" href="ver_conductores.php">
								<i class="material-icons">view_list</i>
								<span class="sidebar-normal">Todos los Conductores</span>
				  			</a>
						</li>
					<?php }?> 
					<?php if(menu(11, $_SESSION['id_perfil'])==1){?>
				  	<li class="nav-item <?php if($op_secundaria==11) echo "active";?>">
				  		<a class="nav-link" href="conductor_nuevo.php">
							<i class="material-icons">person_add</i>
							<span class="sidebar-normal">A&ntilde;adir Conductor</span>
				  		</a>
					</li>
					<?php }?>  
					<?php if(menu(12, $_SESSION['id_perfil'])==1){?>  
					<li class="nav-item <?php if($op_secundaria==12) echo "active";?>">
				  		<a class="nav-link" href="conductor_vehiculo.php">
							<i class="material-icons">link</i>
							<span class="sidebar-normal">Asociar Veh&iacute;culos</span>
				  		</a>
					</li>
					<?php }?>   
			  	</ul>
    		</div>
  		</li>
		<!-- FIN CONDUCTORES -->
  		<?php }?>	
  		<?php if(menu(13, $_SESSION['id_perfil'])==1){?> 
  		<li class="nav-item  <?php if($op_principal==13) echo "active";?>">
    		<a class="nav-link <?php if($op_principal!=13){ echo "collapsed";}else{ echo "";}?>" data-toggle="collapse" href="#pagesTarjeta" aria-expanded="true">
      			<i class="material-icons">credit_card</i>
      			<p>Tarjetas Combustible<b class="caret"></b></p>
    		</a>
    		<div class="collapse <?php if($op_principal==13) echo "show";?>" id="pagesTarjeta" style="">
      			<ul class="nav">
					<?php if(menu(14, $_SESSION['id_perfil'])==1){?>
        			<li class="nav-item <?php if($op_secundaria==14) echo "active";?>">
          				<a class="nav-link" href="ver_tarjetas.php">
            				<i class="material-icons">view_list</i>
            				<span class="sidebar-normal">Todas las Tarjetas</span>
          				</a>
        			</li>
					<?php }?>
        			<?php if(menu(17, $_SESSION['id_perfil'])==1){?>   
          			<li class="nav-item <?php if($op_secundaria==17) echo "active";?>">
          				<a class="nav-link" href="tarjeta_nueva.php">
            				<i class="material-icons">note_add</i>
            				<span class="sidebar-normal">A&ntilde;adir Tarjeta</span>
          				</a>
        			</li>
					<?php }?>
        			<?php if(menu(18, $_SESSION['id_perfil'])==1){?> 
        			<li class="nav-item <?php if($op_secundaria==18) echo "active";?>">
          				<a class="nav-link" href="tarjeta_vehiculo.php">
            				<i class="material-icons">link</i>
            				<span class="sidebar-normal">Asociar Tarjeta</span>
          				</a>
        			</li>
        			<?php }?>  
      			</ul>
    		</div>
  		</li>	
  		<?php }?>
		<?php if(menu(19, $_SESSION['id_perfil'])==1){?> 
  		<li class="nav-item  <?php if($op_principal==19) echo "active";?>">
    		<a class="nav-link <?php if($op_principal!=19){ echo "collapsed";}else{ echo "";}?>" data-toggle="collapse" href="#pagesBitacora" aria-expanded="true">
      			<i class="material-icons">assignment</i>
      			<p>Bitacoras<b class="caret"></b></p>
    		</a>
    		<div class="collapse <?php if($op_principal==19) echo "show";?>" id="pagesBitacora" style="">
      			<ul class="nav">
					<?php if(menu(20, $_SESSION['id_perfil'])==1){?> 
					<li class="nav-item <?php if($op_secundaria==20) echo "active";?>">
						<a class="nav-link" href="ver_bitacoras.php">
							<i class="material-icons">view_list</i>
							<span class="sidebar-normal">Todas las Bitacoras</span>
					  	</a>
					</li>
					<?php }?>
        			<?php if(menu(23, $_SESSION['id_perfil'])==1){?> 
				  	<li class="nav-item <?php if($op_secundaria==23) echo "active";?>">
				  		<a class="nav-link" href="bitacora_nueva.php">
							<i class="material-icons">assignment_turned_in</i>
							<span class="sidebar-normal">A&ntilde;adir Bitacora</span>
				  		</a>
					</li>
					<?php }?>
      			</ul>
    		</div>
  		</li>
		<?php }?>
		<?php if(menu(24, $_SESSION['id_perfil'])==1){?> 
  		<li class="nav-item  <?php if($op_principal==24) echo "active";?>">
    		<a class="nav-link <?php if($op_principal!=24){ echo "collapsed";}else{ echo "";}?>" data-toggle="collapse" href="#pagesMantencion" aria-expanded="true">
      			<i class="material-icons">build</i>
      			<p>Mantenciones<b class="caret"></b></p>
    		</a>
    		<div class="collapse <?php if($op_principal==24) echo "show";?>" id="pagesMantencion" style="">
      			<ul class="nav">
					<?php if(menu(25, $_SESSION['id_perfil'])==1){?> 
        			<li class="nav-item <?php if($op_secundaria==25) echo "active";?>">
          				<a class="nav-link" href="ver_mantenciones.php">
            				<i class="material-icons">view_list</i>
            				<span class="sidebar-normal">Todas las Mantenciones</span>
          				</a>
        			</li>
					<?php }?>
        			<?php if(menu(28, $_SESSION['id_perfil'])==1){?> 
          			<li class="nav-item <?php if($op_secundaria==28) echo "active";?>">
          				<a class="nav-link" href="mantencion_nueva.php">
            				<i class="material-icons">post_add</i>
            				<span class="sidebar-normal">A&ntilde;adir Mantenci&oacute;n</span>
          				</a>
        			</li>
      				<?php }?>
        		</ul>
    		</div>
  		</li>
		<?php }?>
  		<?php if(menu(29, $_SESSION['id_perfil'])==1){?> 		
  		<li class="nav-item  <?php if($op_principal==29) echo "active";?>">
			<a class="nav-link <?php if($op_principal!=29){ echo "collapsed";}else{ echo "";}?>" data-toggle="collapse" href="#pagesReportes" aria-expanded="true">
				<i class="material-icons">library_books</i>
			  	<p>Reportes<b class="caret"></b></p>
			</a>
    		<div class="collapse <?php if($op_principal==29) echo "show";?>" id="pagesReportes" style="">
      			<ul class="nav">
					<?php if(menu(30, $_SESSION['id_perfil'])==1){?> 
        			<li class="nav-item <?php if($op_secundaria==30) echo "active";?>">
          				<a class="nav-link" href="historial_tarjetas.php">
            				<i class="material-icons">description</i>
            				<span class="sidebar-normal">Historial de Tarjetas</span>
          				</a>
        			</li>
					<?php }?>
        			<?php if(menu(31, $_SESSION['id_perfil'])==1){?> 
          			<li class="nav-item <?php if($op_secundaria==31) echo "active";?>">
						<a class="nav-link" href="historial_mantencion.php">
							<i class="material-icons">description</i>
							<span class="sidebar-normal">Historial de Mantenciones</span>
						</a>
        			</li>
      				<?php }?>
        		</ul>
    		</div>
  		</li>	
  		<?php }?>	
		<li class="nav-item">
			<a class="nav-link" href="cerrar_session.php">
				<i class="material-icons">logout</i>
			  	<p>Cerrar Sesi&oacute;n</p>
			</a>
  		</li>	
  	<!-- your sidebar here -->
	</ul>
</div>
</div>	