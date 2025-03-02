<?php
session_start();

define('HOSTNAME', '127.0.0.1:3307');
define('MYSQLUSER', 'jd153574');
define('MYSQLPASS', 'Password574');
define('MYSQLDB', 'sos_tyre');

$conn = @new mysqli(HOSTNAME, MYSQLUSER, MYSQLPASS, MYSQLDB);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tyre_sizes";
$result = $conn->query($sql);
$rim_sizes = [];
$tyre_sizes = [];
$profiles = [];



if ($result->num_rows > 0) {
    // Fetch all rows
    while ($data = $result->fetch_assoc()) {
        $rim_sizes[] = $data['rim'];
        $tyre_sizes[] = $data['width'];
        $profiles[] = $data['profile'];
    }

    $profiles = array_unique($profiles);
    sort($profiles);

    $tyre_sizes = array_unique($tyre_sizes);
    sort($tyre_sizes);
    
    $rim_sizes = array_unique($rim_sizes);
    sort($rim_sizes);
    
} else {
    echo "<h1>NO DATA FOUND... </h1>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header class="navbar">
        <div class="logo">SOS Tyres and Wheels</div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contactus.html">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
                <div class="dropdown">
                    <button type="dropdown">
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
                        session_start();
                        $isLogin = isset($_SESSION['user_id']); // Adjust according to your session variable

                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signout'])) {
                            session_unset();
                            session_destroy();
                            header("Location: index.php");
                            exit();
                        }

                        if ($isLogin):
                        ?>
                            <a href="./profile.php">Profile</a>
                            <form method="post">
                                <button type="submit" name="signout">Signout</button>
                            </form>
                        <?php else: ?>
                            <a href="./signin.php">Signin</a>
                            <a href="./signup.html">Signup</a>
                        <?php endif; ?>
                    </div>
                </div>
            </ul>
        </nav>
    </header>
    <section class="hero">
        <div class="container">
            <h1 class="hero-title">ARE YOU LOOKING FOR?</h1>
            <div class="services">
                <button class="service-item open-select-tyre-dialog">
                    <img src="./image/tyres.png" alt="Tyres">
                    <div class="service-item-title">TYRES</div>

                </button>
                <div class="service-item">
                    <img src="./image/wheels.png" alt="Wheels">
                    <div class="service-item-title">WHEELS</div>
                </div>
                <div class="service-item">
                    <img src="./image/services.png" alt="Services">
                    <div class="service-item-title">SERVICES</div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 SOS Tyres and Wheels. All rights reserved.</p>
    </footer>
</body>

</html>

<div id="selectTyreDialog" class="modal">
    <div class="modal-content">
        <span class="close-button">×</span>
        <h2>Select Tyre Size</h2>

        <div class="tyre-info">
            <img src="./image/sosTyres.png" alt="Tyre Size Explanation">
        </div>

        <div class="tyre-form">
            <form id="tyreSizeForm" action="productlist.php" method="POST">
                <label for="width">Width:</label>
                <select id="width" name="width">
                    <option value="">Select Width</option>

                    <?php
                    foreach ($tyre_sizes as $width) {
                        echo "<option value='$width'>$width</option>";
                    }
                    ?>
                </select>

                <label for="profile">Profile:</label>
                <select id="profile" name="profile">
                    <option value="">Select Profile</option>
                    <?php
                    foreach ($profiles as $profile) {
                        echo "<option value='$profile'>$profile</option>";
                    }
                    ?>
                </select>

                <label for="rim">Rim:</label>
                <select id="rim" name="rim">
                    <option value="">Select Rim</option>
                    <?php
                    foreach ($rim_sizes as $rim) { // Ensure $rims array is defined
                        echo "<option value='$rim'>$rim</option>";
                    }
                    ?>
                </select>
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</div>

<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
    }

    .dropdown svg {
        width: 30px;
        height: 30px;
        fill: #fff;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background: white;
        min-width: 150px;
        border-radius: 5px;
        padding: 10px 0;
        right: 0;
        z-index: 10;
    }

    .dropdown-menu a,
    .dropdown-menu form button {
        display: block;
        width: 100%;
        padding: 10px;
        text-align: left;
        text-decoration: none;
        color: black;
        border: none;
        background: none;
        cursor: pointer;
    }

    .dropdown-menu a:hover,
    .dropdown-menu form button:hover {
        background: #f1f1f1;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Modal Styles */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    .modal-content {
        background-color: #111;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
        max-width: 900px;
        /* Limit the maximum width */
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        position: relative;
        display: flex;
        /* Flex for the layout inside the modal */
        color: white;
    }

    .tyre-info {
        width: 50%;
        padding: 20px;
        box-sizing: border-box;
        background-color: #333;
        /* Image container background */
    }

    .tyre-info img {
        max-width: 100%;
        height: auto;
        display: block;
        border-radius: 8px;
    }

    .tyre-form {
        width: 50%;
        padding: 30px;
        box-sizing: border-box;
        text-align: left;
    }

    .tyre-form label {
        display: block;
        margin-bottom: 5px;
        color: #ddd;
    }

    .tyre-form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #555;
        border-radius: 5px;
        background-color: #444;
        color: #fff;
        box-sizing: border-box;
    }

    .tyre-form button {
        background-color: #ffc107;
        color: black;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .dropdown {
        width: 200px;
        position: relative;
        z-index: 5;
        margin: 0 10px;
    }

    .tyre-form button:hover {
        background-color: #ffda64;
    }

    /* The Close Button */
    .close-button {
        position: absolute;
        top: 10px;
        right: 20px;
        color: #f1f1f1;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-button:hover,
    .close-button:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }


    /* Responsive Design */
    @media (max-width: 768px) {
        .modal-content {
            flex-direction: column;
            margin-top: 5%;
        }

        .tyre-info,
        .tyre-form {
            width: 100%;
            text-align: center;
        }
    }
</style>

<script>
    // JavaScript to open and close the modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('selectTyreDialog');
        const openModalButtons = document.querySelectorAll('.open-select-tyre-dialog'); // Use a class to identify the trigger
        const closeButton = document.querySelector('.close-button');

        // Function to open the modal
        function openModal() {
            modal.style.display = "block";
        }

        // Attach click event to each open button
        openModalButtons.forEach(button => {
            button.addEventListener('click', openModal);
        });

        // Close the modal when the close button is clicked
        closeButton.addEventListener('click', function() {
            modal.style.display = "none";
        });

        // Close the modal if the user clicks outside of it
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    });

    function handleSearch(event) {
        event.preventDefault(); // Prevent the default form submission

        const width = document.getElementById('width').value;
        const profile = document.getElementById('profile').value;
        const rim = document.getElementById('rim').value;

        // Construct the URL with the selected values
        const url = `productlist.php`;
        // `?width=${encodeURIComponent(width)}&profile=${encodeURIComponent(profile)}&rim=${encodeURIComponent(rim)}`;

        // Navigate to the new URL
        window.location.href = url;
    }
</script>