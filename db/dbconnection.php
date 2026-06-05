<?php

// RENDER DB
// $connectionString = "postgresql://dotlinkadb_user:1KSPBl9t2JNlp4p3RwSxje2nbpfShqkd@dpg-d8hhgo42m8qs73b59f40-a.oregon-postgres.render.com/dotlinkadb";
// //$connectionString =  "postgresql://dotlinkadb_user:1KSPBl9t2JNlp4p3RwSxje2nbpfShqkd@dpg-d8hhgo42m8qs73b59f40-a/dotlinkadb";
// 
// 
// $url = parse_url($connectionString);
// 
// $host     = $url['host'];
// $db       = ltrim($url['path'], '/');
// $user     = $url['user'];
// $password = $url['pass'];
// $port     = isset($url['port']) ? $url['port'] : '5432';
// 
// // Build the DSN
// $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
// 
// try {
//     // Create the PDO connection
//     $connection = new PDO($dsn, $user, $password);
//     
//     // Set error mode to exception
//     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     
//     echo "Connected successfully to Render PostgreSQL!";
//     
// } catch (\PDOException $e) {
//     // Log the error
//     throw new \PDOException($e->getMessage(), (int)$e->getCode());
// }


//INFINITYFREE
// $host     = 'sql105.infinityfree.com'; 
// $db       = 'if0_42102752_dotlinkadb'; 
// $user     = 'if0_42102752';            
// $password = 'Rapperdreams2';
// $charset  = 'utf8mb4';
// 
// 
// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// 
// try {
//      $connection = new PDO($dsn, $user, $password);
//      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//      //echo "Connected successfully to the database!";
// } catch (\PDOException $e) {
//      throw new \PDOException($e->getMessage(), (int)$e->getCode());
// }



// LOCALHOST connection 
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
 	
