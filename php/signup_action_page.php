<?php

include '../connection_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $fullName = $firstName . ' ' . $lastName;
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact = isset($_POST['contactNumber']) ? $_POST['contactNumber'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $postcode = isset($_POST['postcode']) ? $_POST['postcode'] : '';

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Use prepared statements for security
    $stmt = $conn->prepare("INSERT INTO users (name, email, contact, password, postcode) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullName, $email, $contact, $hashedPassword, $postcode);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = '../login.php';
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
