<?php
// Define constants for connection info
define("HOSTNAME", "127.0.0.1:3306");
define("MYSQLUSER", "jc968757");
define("MYSQLPASS", "Password757");
define("MYSQLDB", "sos_tyre");

// Create connection
$conn = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Critical: Stop execution if connection fails
}

?>