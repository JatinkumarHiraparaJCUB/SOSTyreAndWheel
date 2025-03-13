<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'?>
    <main>
        <div class="logo-box">
            <img src="./image/sosTyres.png" alt="SOS Tyres and Wheels">
        </div>
        <div class="signup-container">
            <div class="signup-box">
                <h1>Create an Account</h1>
                <form action="./php/signup_action_page.php" method="post" id="signupForm" onsubmit="return validateForm()">

                    <label><b>* First Name</b></label>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required>

                    <label><b>* Last Name</b></label>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>

                    <label><b>* Email</b></label>
                    <input type="email" id="email" name="email" placeholder="Email" required>

                    <label><b>* Contact Number</b></label>
                    <input type="tel" id="contactNumber" name="contactNumber" placeholder="Contact Number" required>

                    <label><b>* Postcode</b></label>
                    <input type="postcode" id="postcode" name="postcode" placeholder="Postcode" required>

                    <label><b>* Password</b></label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <button type="submit">Sign Up</button>
                </form>
                <p>Already have an account? <a href="login.php">Log In</a></p>
            </div>
        </div>
    </main>
    <?php include 'footer.php' ?>
    <script src="./js/script.js"></script>
</body>
</html>