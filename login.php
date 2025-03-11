<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['password'])) {
    include('authentication.php'); // Include the authentication function

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (checkPassword($email, $password)) { // The actual function is in "authentication.php"
        // Set the session variable to indicate the user is logged in

        header("Location: index.php"); // Redirect after login
        exit(); // Ensure that the script stops executing after the redirect
    } else {
        $errorMessage = "Login failed. Invalid email or password.";
    }
}

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
        <?php if (isset($errorMessage)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
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