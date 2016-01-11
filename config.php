<?php

	$base = "mysql:host=localhost;dbname=omarecom_restaurantesmb";

	try {
	    $conn = new PDO($base, 'omarecom_forge', '4EUCBTzemcC1mTHCE1mn');
	} catch (PDOException $e) { echo $e; }

?>