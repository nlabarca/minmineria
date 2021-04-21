<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bit&aacute;cora de Veh&iacute;culos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<script>
/*function ingresar(){
	var usuario=document.form.username.value;
	var pass=document.form.pass.value;
	if(usuario="" || pass==""){
		alert('[ERROR] Debe ingresar usuario y clave');
    	return false;
	}
  //document.form.action="index.php?accion=ingresar";
  document.form.action="validacion.php";
  document.form.method="post";
  document.form.submit();
}*/

</script>	
</head>
<body>
	
	<div class="limiter">
		
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" action="validacion.php">
					<span class="login100-form-title">
						Bit&aacute;cora de Veh&iacute;culos</span>
					
				  <div class="wrap-input100 validate-input m-b-16" data-validate="Por favor ingrese usuario">
						<input class="input100" type="text" name="username" placeholder="Usuario">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Por favor ingrese clave">
						<input class="input100" type="password" name="pass" placeholder="Clave">
						<span class="focus-input100"></span>
					</div>

					<div class="text-right p-t-13 p-b-23">
					<!--	<span class="txt1">
							Forgot
						</span>

						<a href="#" class="txt2">
							Username / Password?
						</a>-->
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" onClick="">Ingresar</button>
					</div>
					

					<div class="flex-col-c p-t-170 p-b-40">
						<img src="images/logo_ministerio_full.jpg" width="120" height="109" alt=""/>
						
						<!--<span class="txt1 p-b-9">
							Don’t have an account?
						</span>

						<a href="#" class="txt3">
							Sign up now
						</a>-->
					</div>
					<div align="right"><a href="Manual - Bitacora de Vehiculos.pdf" target="_blank"><img src="images/manuals.fw.png" alt="" width="100" height="73"/></a></div>
					<br>
			  </form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>