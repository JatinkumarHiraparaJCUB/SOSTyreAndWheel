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

            header("Location: index.html"); // Redirect to the dashboard or index
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffc107;
            /* Yellow background */
            color: #000;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Ensure the body takes up at least the viewport height */
        }

        /* Header and Footer - Assuming from previous files */
        .navbar {
            background-color: black;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar nav ul li {
            margin-left: 20px;
        }

        .navbar nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Main Content Styling */
        main {
            flex: 1;
            /* Allow main to grow and fill the remaining space */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 200px;
            max-width: 1000px;
            width: 100%;
            /* Take up full width */
            margin: 0 auto;
            /* Center the container */
        }

        .login-box {
            background-color: rgba(255, 255, 255, 0.9);
            /* Semi-transparent white */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px;
            /* Fixed width */
        }

        .login-box h1 {
            margin-bottom: 20px;
            color: #001f3f;
        }

        .login-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .options {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-top: 10px;
            /* align-items: center; */
        }

        .options a {
            color: #001f3f;
            text-decoration: none;
        }

        .options a:hover {
            text-decoration: underline;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            background: #000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .login-box button:hover {
            background-color: #333;
        }

        .login-box p {
            margin-top: 20px;
            font-size: 14px;
        }

        .login-box p a {
            color: #001f3f;
            text-decoration: none;
            font-weight: bold;
        }

        .login-box p a:hover {
            text-decoration: underline;
        }

        .logo-box {
            width: 400px;
            /* Fixed width */
            text-align: center;
            /* Center the logo */
        }

        .logo-box img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            width: 350px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .login-container {
                flex-direction: column;
                /* Stack login box and logo on smaller screens */
                align-items: center;
            }

            .login-box,
            .logo-box {
                width: 90%;
                /* Adjust width for smaller screens */
                max-width: 400px;
                /* Limit the width */
            }
        }
        /* Error message styling */
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <div>
        <!-- Error Message Display -->
        <?php if (!empty($errorMessage)) { ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php } ?>
    </div>

    <header class="navbar">
        <div class="logo">SOS Tyres and Wheels</div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contactus.html">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

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
                <p>Don't have an account? <a href="signup.html">Sign Up</a></p>
            </div>
            <div class="logo-box">
                <img src="./image/sosTyres.png" alt="SOS Tyres and Wheels">
            </div>
        </div>
    </main>

    <footer>
        <p>© 2024 SOS Tyres and Wheels. All rights reserved.</p>
    </footer>

    <script src="./js/script.js"></script>
</body>

</html>