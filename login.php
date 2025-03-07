<?php
session_start(); // Start the session for user login tracking

// Database connection details (replace with your actual credentials)
define("HOSTNAME", "127.0.0.1:3307");
define("MYSQLUSER", "jd153574");
define("MYSQLPASS", "Password574");
define("MYSQLDB", "sos_tyre");

// Attempt database connection
$conn = @new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query to fetch user data
    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password']; // Fetch the hashed password from the database

        // Verify the password using password_verify (assuming passwords are hashed)
        if (password_verify($password, $hashed_password)) {
            // Password is correct!

            // Create session variables to track user login
            $_SESSION['user_id'] = $user['id'];  // Store user ID
            $_SESSION['logged_in'] = true;        // Mark user as logged in

            header("Location: index.php"); // Redirect to the dashboard or index
            exit();
        } else {
            $errorMessage = "Login failed. Invalid email or password.";
        }
    } else {
        $errorMessage = "Login failed. Invalid email or password.";
    }

    $stmt->close(); // Close the prepared statement
}

$conn->close(); // Close the database connection
session_destroy(); // Clean
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div>
        <!-- Error Message Display -->
        <?php if (!empty($errorMessage)) { ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php } ?>
    </div>
    <?php include 'header.php'; ?>
    <main>
        <div class="login-container">
            <div class="login-box">
                <h1>Welcome Back!</h1>
                <form id="loginForm" method="post">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <div class="options">
                        <label><input type="checkbox"> Remember Me </label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit">Sign In</button>
                </form>
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
            <div class="logo-box">
                <img src="./image/sosTyres.png" alt="SOS Tyres and Wheels">
            </div>
        </div>
    </main>
    <?php include 'footer.php' ?>
    <script src="./js/script.js"></script>
</body>

</html>