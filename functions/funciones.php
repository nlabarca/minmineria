<?php
#####################
### Fix Variables ###
#####################
if(!isset($_SERVER['HTTP_REFERER'])){ $_SERVER['HTTP_REFERER'] = ''; } // Si ingreso directamente a una pagina necesito declarar la variable para no generar errrores en los logs
####################################################################################

############
### LDAP ###
############

function f_conect_ldap($vi_host, $vi_domain, $vi_user, $vi_pwd){
	$v_ldap_user	= $vi_user . "@" . $vi_domain;
	$v_ldap_pwd		= $vi_pwd;
	
	// Conexion al servidor LDAP
	$ldapconn = ldap_connect($vi_host) or die("No se pudo conectar al servidor LDAP.");

	if ($ldapconn) {
		// realizando la autenticación
		$ldapbind = @ldap_bind($ldapconn, $v_ldap_user, $v_ldap_pwd);

		// verificación del enlace
		if ($ldapbind) {
			$v_result = 1;
		} else {
			$v_result = 0;
		}

	}
	else{
		$v_result = 0;
	}
	
	return $v_result;
}


function f_date_ms($date, $separator){
	
	$a_data = explode($separator,$date);
	
	$data = $a_data[2].'-'.$a_data[1].'-'.$a_data[0];
	
	return $data; 
}
?>