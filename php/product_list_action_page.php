<?php

include '../connection_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST)) {
        // Get values from POST request
        $width = isset($_POST['width']) ? $_POST['width'] : '';
        $profile = isset($_POST['profile']) ? $_POST['profile'] : '';
        $rim = isset($_POST['rim']) ? $_POST['rim'] : '';
    } else {
        echo "No data received!";
    }
} else {
    echo "Invalid request!";
}


if ($width == '' || $rim == '' || $profile == '') {
    $sql = "SELECT * FROM tyres";
} else {
    $sql = "SELECT * FROM tyres WHERE width = $width AND `profile` = $profile AND rim = $rim";
}


include 'connection_db.php';
// Retrieve search query from the URL
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['data'] = $result;
    echo "<script>
                window.location.href = '../productList.php';
              </script>";
} else {
    echo "<script>
                alert('Error: " . $stmt->error . "');
                window.history.back();
              </script>";
}

// Close the database connection
$conn->close();
