<?php

	include_once('/var/www/html/cloud/models/main/db.php');
	include_once('/var/www/html/cloud/models/main/dbShortcuts.php');
	include_once('/var/www/html/cloud/models/main/location.php');
	

	//$resp= dbMassData("SELECT * FROM interactions");

	//SELECT *, SQRT(POW(69.1 * ($tableLat - $lat ), 2) + POW(69.1 * ($lon- $tableLon) * COS($tableLat / 57.3), 2)) AS distance FROM $tableName HAVING distance < $distance ORDER BY distance LIMIT $responseLimit;
	//echo(json_encode($resp));
?>