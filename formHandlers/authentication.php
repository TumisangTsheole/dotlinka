<?php

require "../pathBootstrap.php";

$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);

print_r($email);
print_r($password);