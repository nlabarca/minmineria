<?php
$rut=$_GET['rut'];

	$server2 = 'sqlserver_2008'; 
	// Connect to MSSQL 
	$connection2 = mssql_connect($server2, 'sa', 'minmineria'); 
	if (!$connection2) { 
		die('Something went wrong while connecting to MSSQL'); 
	} 

	mssql_select_db('mineriadsm', $connection2);
    $sql="select * from usuarios where rut='$rut'";
	$rs = mssql_query ($sql,$connection2);
	$row=mssql_fetch_array($rs);
	echo htmlentities($row['nombres'])."|".utf8_encode($row['apellidos'])."|".utf8_encode($row['cargo']);



?>