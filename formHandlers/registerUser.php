<?php
require "../db/dbconnection.php";
require "../controllers/UserController.php";

// require "../data/indexData.php";
// require "../data/dashboardData.php";
// require "../data/productDetailData.php";

require "../models/user.php";
require "../controllers/Router.php";

move_uploaded_file($_FILES["idCardImages"]["tmp_name"], "document1.pdf");
move_uploaded_file($_FILES["userImages"]["tmp_name"], "document2.pdf");

