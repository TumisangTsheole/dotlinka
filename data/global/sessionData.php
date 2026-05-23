<?php
// TODO: If session exists, automatically route to dashboard.
// TODO: Make sure to include session checking on every page

$sessionData;
$verificationId = "opentokenforeveryuser"; // string used to create hash

// values fetched from cookie storage
$cookieSessionId= $_COOKIE["sessionId"];
$cookieUserId = $_COOKIE["userId"];

if (!isset($cookieUserId) || $cookieSessionId != $verificationId){
    header("Location: /loginPage.php");
    exit;
}

    $sessionData = $cookieUserId;
    
if ($path == "/formHandlers/authenticate.php")
{
    header("Location: /dashboard.php");
    exit;
}



