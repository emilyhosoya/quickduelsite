<?php

	include_once('settings.php');

	include_once('dbLib.php');

	extract($_REQUEST);

	dbQuery("INSERT INTO betaUsers (email) VALUES '$email'");

	echo('added');

?>