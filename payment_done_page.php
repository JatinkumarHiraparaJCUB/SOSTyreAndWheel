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

        div.payment-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        img.payment-image {
            width: 60%;
        }

    </style>
</head>

<body>

    <?php include "header.php"; ?>
    <main>
        <div class="payment-container">
            <img class="payment-image" src="./image/order_confirm.png" alt="Order Confirm">
            <button class="confirm-button" onclick="window.location.href='index.php'">Back To Home</button>
        </div>
    </main>
    <?php include "footer.php"; ?>
</body>

</html>