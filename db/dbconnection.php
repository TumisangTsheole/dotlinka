<?php

$host     = 'sql105.infinityfree.com'; 
$db       = 'if0_42102752_dotlinkadb'; 
$user     = 'if0_42102752';            
$password = 'Rapperdreams2';
$charset  = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
     $connection = new PDO($dsn, $user, $password);
     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //echo "Connected successfully to the database!";
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// localhost connection 
// 	$host = "mysql:host=localhost;dbname=dotlinkaDB";
// 	$username = "tumisang";
// 	$password = "Rapperdreams@2";
// 
// 	
// 
// 	// attempt database connection
// 	try {
//     	$connection = new PDO($host, $username, $password);
// 
// 		// how pdo should handle  errors, throw an exception in this case
// 		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	} 
// 	catch (PDOException $ex) {
// 		echo $ex->getCode();
// 	}
//  	
