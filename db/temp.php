<?php
/**
    This is an mini object-relational mapper (ORM) used to map php classes
    to database tables

    Even though the print_r statement may make the code look
    a bit unclean, they are there for debugging purposes
    
**/

    
// DATABASE INITIALIZATION: MAP MODELS TO DATABASE SCHEMA
// Responsible for creating database and schemas if they don't exist
////////////////////////////////////////////////////////////////////

include "dbconnection.php";


// CREATE DATABASE IF IT DOESN'T EXIST

$connection->exec("CREATE DATABASE IF NOT EXISTS dotlinka;");


// CREATE SCHEMAS FROM models USING REFLECTION


$modelsPath = __DIR__ . "/../models";

// check if path and .php file exist in the directory
if (!is_dir($modelsPath)){
    throw new Exception("Path '$modelsPath' does not exist.");
} 
else if (glob($modelsPath . "/*.php") == false){
    throw new Exception("No '.php' files exist in the directory -> '$modelsPath'");
}

// get all declared classes in scope at this point in execution
$before = get_declared_classes();

// include every .php file in /models hereby defining the classes present there
foreach (glob($modelsPath . "/*.php") as $file){


    include $file;
}

$after = get_declared_classes();

// Difference the arrays to get the newly defined classes
// of which are going to be from /models
$new_classes = array_diff($after, $before);

print_r("The following classes and properties were found in '$modelsPath':\n");
foreach ($new_classes as $model){
    $classMeta = new ReflectionClass($model);
    $properties = $classMeta->getProperties();
    
    //formatting
    print_r($model . "\n" . str_repeat("-", 3) . "\n");
    
    foreach ($properties as $prop){
        print_r($prop->getName() . "(" . $prop->getType() . ")\n");

        print_r(gettype($properties));
        

    } print_r("\n");
   
}



function createDatabaseSchema(object $dbConnection, array $assocArray){

}


