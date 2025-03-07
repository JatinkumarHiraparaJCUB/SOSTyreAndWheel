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

session_destroy();
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

    <?php include "header.php"; ?>
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
    <div id="selectTyreDialog" class="tyre-modal modal">
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
                        foreach ($rim_sizes as $rim) {
                            echo "<option value='$rim'>$rim</option>";
                        }
                        ?>
                    </select>
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>

</html>

<style>

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