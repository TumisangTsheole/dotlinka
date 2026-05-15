<?php
	$host = "mysql:host=localhost;dbname=testdatabase";
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
?>


<?php
// // Connect to the database
// $pdo = new PDO("mysql:host=localhost;dbname=test", "user", "password");

// // Prepare the SQL with a named placeholder
// $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");

// // Execute the statement, binding the placeholder to the actual value
// $stmt->execute(['email' => $_GET['email']]);

// // Fetch all matching rows
// $result = $stmt->fetchAll();

// // Example: print results
// print_r($result);

?>