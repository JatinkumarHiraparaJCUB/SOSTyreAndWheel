<?php

include '../connection_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $message = isset($_POST['message']) ? $_POST['message'] : '';


  // Use prepared statements for security
  $stmt = $conn->prepare("INSERT INTO inquiry (`name`, email, `message`) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $email, $message);

  if ($stmt->execute()) {
    echo "<script>
                alert('Inquiry successful!, We will contact you soon');
                window.location.href = '../index.php';
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
