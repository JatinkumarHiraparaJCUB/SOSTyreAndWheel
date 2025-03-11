<?php
session_start(); // Start session BEFORE any output!
?>

<header class="navbar">
    <div class="logo">SOS Tyres and Wheels</div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="contactUs.php">Contact Us</a></li>
            <div class="login-dropdown dropdown">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <path d="M0 0h48v48H0z" fill="none" />
                        <g id="Shopicon">
                            <path d="M33.843,26.914L24,36l-9.843-9.086C8.674,30.421,5,36.749,5,44h38C43,36.749,39.326,30.421,33.843,26.914z" />
                            <path d="M24,28c3.55,0,6.729-1.55,8.926-4C34.831,21.876,36,19.078,36,16c0-6.627-5.373-12-12-12S12,9.373,12,16 c0,3.078,1.169,5.876,3.074,8C17.271,26.45,20.45,28,24,28z" />
                        </g>
                    </svg>
                </button>
                <div class="dropdown-menu">
                    <?php
                    // Check if user is logged in based on session
                    $isLogin = isset($_SESSION['user_id']);

                    if ($isLogin) {
                        // User is logged in - SHOW: Profile, Signout
                        echo '<a href="./profile.php">Profile</a>';
                        echo '<form method="post" action="">'; // Add an action to the form
                        echo '    <button type="submit" name="signout">Sign Out</button>';
                        echo '</form>';
                    } else {
                        // User is NOT logged in - SHOW: Login, Signup
                        echo '<a href="./login.php">Login</a>';
                        echo '<a href="./signup.php">Signup</a>';
                    }

                    // Handle Signout (Correct Placement - within header.php)
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signout'])) {
                        session_unset(); // Clear all session variables
                        session_destroy(); // Destroy the session
                        header("Location: index.php"); // Redirect to the home page after signout
                        exit();
                    }
                    ?>
                </div>
            </div>
        </ul>
    </nav>
</header>