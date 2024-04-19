<?php
include("soy.php");
?>
<?php

define('DB_USERNAME', 'Username');
define('DB_PASSWORD', 'Password');
define('DB_NAME', 'DatabaseName');
define('DB_SERVER', 'Server');

/* Attempt to connect to MySQL database */
/** @var mysqli $mysqli */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


// Check connection
if($mysqli->connect_errno){
    die("ERROR: Could not connect. (" .$mysqli->connect_errno. ") " . $mysqli->connect_error);
}
