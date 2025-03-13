<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode of Purchase - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include "header.php"; ?>
    <main>
        <section class="mode-of-purchase">
            <div class="container">
                <h1>MODE OF PURCHASE</h1>
                <form method="post" action="payment.php">
                    <div class="purchase-options">
                        <a href="<?= $base_url . '&services_type=1' ?>">
                            <div class="purchase-option">
                                <img src="./image/store_fitting.png" alt="Store Fitting">
                                <p>STORE FITTING</p>
                            </div>
                        </a>
                        <a href="<?= $base_url . '&services_type=2' ?>">
                            <div class="purchase-option">
                                <img src="./image/pick_up.png" alt="Pick Up">
                                <p>PICK UP</p>
                            </div>
                        </a>

                        <div class="purchase-option">
                            <!-- <input type="hidden" name="services_type" value="3"> -->
                            <button type="submit" name="service_type" value="2" class="purchase-option-button">
                                <img src="./image/mobile_fitting.png" alt="Mobile Fitting">
                                <p>MOBILE FITTING</p>
                            </button>
                        </div>
                        <div class="purchase-option">
                            <!-- <input type="hidden" name="services_type" value="3"> -->
                            <button type="submit" name="service_type" value="3" class="purchase-option-button">
                                <img src="./image/mobile_fitting.png" alt="Mobile Fitting">
                                <p>MOBILE FITTING</p>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <?php include "footer.php"; ?>
</body>

</html>