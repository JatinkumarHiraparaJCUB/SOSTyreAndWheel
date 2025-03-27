<?php

// Check if the form was submitted correctly
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $orderId = isset($_POST['orderid']) ? $_POST['orderid'] : '';
    $finalAmount = isset($_POST['final_amount']) ? $_POST['final_amount'] : '';
    $finalAmount = floatval($finalAmount);

    $gst = 0;
    $gst += $finalAmount * 0.10;


    // echo '<h1>'.$orderId.'</h1>';
    // echo '<h1>'.$finalAmount.'</h1>';

    include 'connection_db.php';

    $stmt = $conn->prepare("UPDATE orders SET total_cost = ? WHERE id = ?");
    $stmt->bind_param("ss", $finalAmount, $orderId);

    if ($stmt->execute()) {
        $insertedId = $conn->insert_id;
        $_SESSION['order_id'] = $insertedId;
    } else {
        echo "<script>
                    alert('Error: " . addslashes($stmt->error) . "');
                    window.history.back();
                  </script>";
    }
    $stmt->close();
} else {
    //Handle what happened if session or POST wasn't working.
    echo "No product selected!. Please return to homepage, and repeat operation";
    exit();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule & Payment - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            color: black;
            border-radius: 5px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        label {
            display: block;
            /* Make labels display on their own line */
            margin-bottom: 5px;
            /* Add spacing below labels */
        }

        .confirm-button {
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10%;
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>
    <main>
        <div id="addressModal" class="modal">
            <form method="post" action="">
                <div class="modal-content">
                    <span class="close">×</span>
                    <h2>Enter Delivery Address</h2>
                    <p>Please enter your delivery address to proceed</p>
                    <label for="address">Address: </label>
                    <input type="text" id="address" name="address" placeholder="Address" required>
                    <br />

                    <button type="submit" onclick="return storeAddress()">Submit</button>
                </div>
            </form>
        </div>
        <div class="schedule-container">
            <div class="schedule-section">
                <h2>Price Details</h2>
                <div class="price-details">
                    <div class="price-item">
                        <span class="label">Total Price :</span>
                        <span class="value">$ <?= $finalAmount ?></span>
                    </div>

                    <div class="price-item">
                        <span class="label">GST (10%) :</span>
                        <span class="value">$ <?= $gst ?></span>
                    </div>

                    <div class="total-line">
                        <span class="label total-label">Total :</span>
                        <span class="value total-value">$ <?= $finalAmount + $gst ?></span>
                    </div>

                </div>
                <button class="confirm-button" onclick="window.location.href='payment_done_page.php'">Payment</button>
                <div id="paypal-button-container"></div>

            </div>

        </div>
    </main>
    <?php include "footer.php"; ?>
</body>

</html>

<script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&currency=AUD"></script>
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $finalAmount; ?>' // Use your dynamic PHP variable
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Optional: You can send a confirmation to your backend here
                alert('Transaction completed by ' + details.payer.name.given_name);
                window.location.href = 'payment_success.php?orderid=<?php echo $orderId; ?>';
            });
        }
    }).render('#paypal-button-container');
</script>

