<?php
require "../guard.php";
require "../../db/dbconnection.php";

$userId = trim($_POST["userId"] ?? "");
$role   = trim($_POST["role"] ?? "");

// can't modify yourself
if ($userId === $sessionUserId) {
    header("Location: /admin/users.php?error=self");
    exit;
}

if (empty($userId) || !in_array($role, ["user", "admin"])) {
    header("Location: /admin/users.php?error=invalid");
    exit;
}

$statement = $connection->prepare(
    "UPDATE users SET role = :role WHERE id = :userId;"
);
$statement->execute([":role" => $role, ":userId" => $userId]);

$success = $role === "admin" ? "promoted" : "demoted";
header("Location: /admin/users.php?success=" . $success);
exit;