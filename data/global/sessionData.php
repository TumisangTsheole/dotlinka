<?php
// TODO: If session exists, automatically route to dashboard.
// TODO: Make sure to include session checking on every page

$session;

// Check if broswer contains session data
function CheckSession(){
    // TODO
    return true;
}

// Session Data, retrieved from browser LocalStorage or database on log in
if(CheckSession()){
    $userSession = [
        "firstName" => "Tumisang",
        "lastName" => "Tsheole"
    ];
}