<?php
include '../connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
  $productId = isset($_POST['product_id']) ? $_POST['product_id'] : '';
  $service_type = isset($_POST['service_type']) ? $_POST['service_type'] : '';

  session_start();
  $_SESSION['service_type'] = $service_type;

  // Check if an order ID exists in the session
  if (!isset($_SESSION['order_id'])) {
    // Insert a new order
    $stmt = $conn->prepare("INSERT INTO orders (total_cost) VALUES (?)");
    $stmt->bind_param("s", $totalPrice);

    if ($stmt->execute()) {
      $insertedId = $conn->insert_id;
      $_SESSION['order_id'] = $insertedId;

      // Add product to order details
      $stmt = $conn->prepare("INSERT INTO orderdetails (order_id, quantity, tyre_id, service_type) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $_SESSION['order_id'], $quantity, $productId, $_SESSION['service_type']);
      $stmt->execute();

      echo "<script>
                    alert('Product added to cart successfully.');
                    window.location.href = '../cart.php';
                  </script>";
    } else {
      echo "<script>
                    alert('Error: " . addslashes($stmt->error) . "');
                    window.history.back();
                  </script>";
    }
    $stmt->close();
  } else {
    // Use existing order ID
    $insertedId = $_SESSION['order_id'];
    $stmt = $conn->prepare("INSERT INTO orderdetails (order_id, quantity, tyre_id, service_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $insertedId, $quantity, $productId, $_SESSION['service_type']);

    if ($stmt->execute()) {
      echo "<script>
                    alert('Product added to existing order.');
                    window.location.href = '../cart.php';
                  </script>";
    } else {
      echo "<script>
                    alert('Error: " . addslashes($stmt->error) . "');
                    window.history.back();
                  </script>";
    }
    $stmt->close();
  }
}
