<?php
// Define constants for connection info
define("HOSTNAME", "127.0.0.1:3307");
define("MYSQLUSER", "jd153574");
define("MYSQLPASS", "Password574");
define("MYSQLDB", "sos_tyre");

// Create connection
$conn = new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Critical: Stop execution if connection fails
}

?>