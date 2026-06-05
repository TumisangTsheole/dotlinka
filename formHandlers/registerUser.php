<?php
require "../db/dbconnection.php";
require "../models/user.php";
require "../controllers/UserController.php";
require "../controllers/Router.php";

// save upload files to file storage
move_uploaded_file($_FILES["idCardImages"]["tmp_name"], "../staticFileStorage/" . htmlspecialchars($_POST["idNumber"]) . "_idCardImages.pdf");
move_uploaded_file($_FILES["userImages"]["tmp_name"], "../staticFileStorage/" . htmlspecialchars($_POST["idNumber"]) . "_userImages.png");

header("Location: /loginPage.php");
exit;