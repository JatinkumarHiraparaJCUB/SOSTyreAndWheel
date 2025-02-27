<?php
// authentication.php (Create this file in the same directory as your login.php)

function checkUser($email, $password) {
    // Database connection details (Make sure these are correct!)
    define("HOSTNAME", "127.0.0.1:3307");
    define("MYSQLUSER", "jd153574");
    define("MYSQLPASS", "Password574");
    define("MYSQLDB", "sos_tyre");

    $conn = @new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Critical: Stop execution if connection fails
    }

    $sql = "SELECT id, password FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];  // Fetch the stored *hashed* password

        // Verify the entered password against the stored hash
        if (password_verify($password, $hashed_password)) {
             // Password is correct. Store user data in the session for later use
            session_start(); // Ensure session is started before setting variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = true;
            $conn->close();
            return true; // Indicate successful login
        }
    }
     $conn->close(); // Close the connection outside the if statement
    return false; // Indicate failed login
}
?>