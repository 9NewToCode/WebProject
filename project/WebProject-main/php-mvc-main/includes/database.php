<?php

$hostname = 'gonggang.net';
$dbName = 'u910454988_demacia';
$username = 'u910454988_demacia';
$password = '9#[Q92sBKO^NsJqV';
$conn = new mysqli($hostname, $username, $password, $dbName);

function getConnection(): mysqli
{
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// database functions ต่างๆ
require_once DATABASES_DIR . '/User.php';
// require_once DATABASES_DIR . '/courses.php';
//require_once DATABASES_DIR . '/enrollment.php';