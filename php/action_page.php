<?php

include 'connection_db.php';

// define("HOSTNAME", "127.0.0.1:3307");
// define("MYSQLUSER", "jd153574");
// define("MYSQLPASS", "Password574");
// define("MYSQLDB", "sos_tyre");

// // Enable error reporting
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// // Connect to the database
// function db_connect()
// {
//     $conn = @new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);
//     if ($conn->connect_error) {
//         die('Connect Error: ' . $conn->connect_error);
//     }
//     return $conn;
// }

// $conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $fullName = $firstName . ' ' . $lastName;
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact = isset($_POST['contactNumber']) ? $_POST['contactNumber'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Use prepared statements for security
    $stmt = $conn->prepare("INSERT INTO users (name, email, contact, password, postcode) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullName, $email, $contact, $hashedPassword, $postcode);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Redirecting to the login page.');
                window.location.href = '../login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
}
