<?php
	$host = "mysql:host=localhost;dbname=dotlinkaDB";
	$username = "tumisang";
	$password = "Rapperdreams@2";

	

	// attempt database connection
	try {
    	$connection = new PDO($host, $username, $password);

		// how pdo should handle  errors, throw an exception in this case
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} 
	catch (PDOException $ex) {
		echo $ex->getCode();
	}
	
