<?php

// Check if id param exists
if (!isset($_GET)){
    die("ERROR: No order id provided");
}

$id = $_GET['id'];

echo "Order with ID -> {$id} has been created!";

?>