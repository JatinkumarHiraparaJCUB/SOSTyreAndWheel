<?php

function checkPassword($email, $password) {
    include 'connection_db.php';

    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];

        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = true; // Mark user as logged in
            $conn->close();
            return true;
        }
    }

    $conn->close();
    return false;
}