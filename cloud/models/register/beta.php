<?php

	include_once('/var/www/public_html/cloud/models/db/settings.php');

	include_once('/var/www/public_html/cloud/models/db/dbLib.php');

	extract($_REQUEST);

	dbQuery("INSERT INTO beta (email) VALUES '$email'");

	echo('added');

?>