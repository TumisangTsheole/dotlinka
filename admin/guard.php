<?php
session_start();

if (!isset($_SESSION["userId"])) {
    header("Location: /loginPage.php");
    exit;
}

if (($_SESSION["userRole"] ?? "user") !== "admin") {
    header("Location: /dashboard.php");
    exit;
}

$sessionUserId = $_SESSION["userId"];