<?php
// Function to sanitize input data (prevent XSS)
function sanitize_input($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Check if the form was submitted correctly
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'], $_POST['quantity'])) {
    // Sanitize the POST data
    $product_id = sanitize_input($_POST['product_id']);
    $quantity = sanitize_input($_POST['quantity']);

} else {
    echo "Data not found or Invalid Request"; //Show error message
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode of Purchase - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Your CSS Here -->
</head>

<body>
    <?php include "header.php"; ?>

    <main>
        <section class="mode-of-purchase">
            <div class="container">
                <h1>MODE OF PURCHASE</h1>

                <!-- You will not pass "sercvice_type" here, but instead from the submit on the main page -->
                <form method="post" action="payment.php">
                    <div class="purchase-options">
                        <input type="hidden" name="product_id" id="product_id" value=<?= $product_id ?>>
                        <input type="hidden" name="quantity" id="quantity" value=<?= $quantity ?>>
                        <label>
                            <button type="submit" name="service_type" id="service_type" value="1" class="purchase-option">
                                <img src="./image/store_fitting.png" alt="Store Fitting">
                                <p>STORE FITTING</p>
                            </button>
                        </label>

                        <label>
                            <button type="submit" name="service_type" id="service_type" value="2" class="purchase-option">
                                <img src="./image/pick_up.png" alt="Pick Up">
                                <p>PICK UP</p>
                            </button>
                        </label>

                        <label>
                            <button type="submit" name="service_type" id="service_type" value="3" class="purchase-option">
                                <img src="./image/mobile_fitting.png" alt="Mobile Fitting">
                                <p>MOBILE FITTING</p>
                            </button>
                        </label>

                    </div>
                </form>
            </div>
        </section>
    </main>

    <?php include "footer.php"; ?>
</body>

</html>