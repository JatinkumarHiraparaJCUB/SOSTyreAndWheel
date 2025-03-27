<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoeHub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include 'connection_db.php';
    include "header.php";

    // Start the session
    $orderid = $_SESSION['order_id'] ?? 1;
    $service_type = $_SESSION['service_type'] ?? 1;

    $sql = "SELECT * FROM `orderdetails` WHERE order_id= $orderid";
    $result = $conn->query($sql);
    $totalPrice = 0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            // Get the product ID from the order details
            $productId = htmlspecialchars($row['tyre_id']);
            $quantity = htmlspecialchars($row['quantity']);
            $serviceType = htmlspecialchars($row['service_type']);

            if ($productId > 0) {
                // Fetch product details based on the product ID
                $productSql = "SELECT * FROM `tyres` WHERE tyre_id=$productId";
                $productResult = $conn->query($productSql);

                if ($productResult->num_rows > 0) {
                    while ($productRow = $productResult->fetch_assoc()) {
                        $productName = htmlspecialchars($productRow['title']);
                        $productPrice = number_format($productRow['price'], 2);
                        $description = htmlspecialchars($productRow['description']);
                        $fittingChargesAmount = htmlspecialchars($productRow['fitting_charges_amount']);
                        $totalPrice += ($quantity * $productPrice);

                        switch ($serviceType) {
                            case '1':
                                $service = 'Store Fitting';
                                break;
                            case '2':
                                $service = 'Pick Up';
                                break;
                            default:
                                $service = 'Mobile Fitting';
                        }

                        $finalAmount = $productPrice * $quantity;
                        if ($serviceType == '1') {
                            $finalAmount += $fittingChargesAmount;
                            $totalPrice += $fittingChargesAmount;
                        }
                        if ($serviceType == '3') {
                            $finalAmount += 120;
                            $totalPrice += 120;
                        }

    ?>

                        <div style="margin: 50px 10%">
                            <div class="row" style="padding-left: 1%; padding-top: 1%; padding-bottom: 2%;">
                                <div class="col-12 col-lg-4">
                                    <img src="./image/tyre.png" alt="" style="width: 350px; height: 350px;">
                                </div>
                                <div class="col-12 col-lg-5">
                                    <h5><?= $productName ?> </h5>
                                    <p>$ <?= $productPrice ?></p>
                                    <p>Quantity : <?= $quantity ?></p>
                                    <p>Service Type : <?= $service ?></p>
                                    <?php
                                    if ($serviceType == '1') {
                                        echo "<p>Store Fitting charges : $fittingChargesAmount </p>";
                                    }
                                    if ($serviceType == '3') {
                                        echo "<p>Mobile Fitting charges : $ 120 </p>";
                                    }

                                    ?>
                                    <div class="total-line">
                                        <span class="label total-label">Total:</span>
                                        <span class="value total-value">$ <?= $finalAmount ?></span>
                                    </div>
                                    <br />
                                    <p><?= $description ?></p>

                                    <p>Available to ship. 3-5 business days.</p>
                                </div>

                            </div>
                        </div>
        <?php
                    }
                } else {
                    echo "<p>No products found for this category.</p>";
                }
            } else {
                echo "<p>Invalid product ID.</p>";
            }
        }
    } else {
        ?>
        <div class="container" style="padding-bottom: 22%;">
            <p style="text-align: center; padding-top: 10%;">It looks like your Basket is empty!</p>
            <form method="post" accept="">

                <a href="./index.php" class="btn btn-primary" style="position: absolute; left: 50%; transform: translateX(-50%);" type="submit">Browse Now!</a>
            </form>
        </div><?php } ?>



    <!-- Add More, Checkout and Empty Basket Button -->
    <section class="card text-center p-4" style="display: table; margin: 0 auto;">
        <h4 style="font-weight: bold; color: #966c43;">Total = $ <?= $totalPrice ?></h4>
    </section>

    <section style="display: table; margin: 0 auto;">
        </br>
        <form method="post" action="payment.php">

            <input type="hidden" name="orderid" id="orderid" value=<?= $orderid ?>>
            <input type="hidden" name="final_amount" id="final_amount" value=<?= $totalPrice ?>>

            <button type="submit">Checkout</button>

        </form>
    </section>

    <!-- <?php include "footer.php"; ?> -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>

</html>