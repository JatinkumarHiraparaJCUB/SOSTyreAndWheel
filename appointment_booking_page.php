
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
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content h2 {
            margin-bottom: 20px;
            color: #001f3f;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal-content label {
            width: 100%;
            font-size: 14px;
        }

        .modal-content button {
            width: 100%;
            padding: 10px;
            background: #000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .modal-content button:hover {
            background-color: #888;
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
                <h2>Schedule</h2>
                <div class="datetime-selection">
                    <label for="date">Date:</label>
                    <input type="date" id="date">
                    <label for="time">Time:</label>
                    <select id="time">
                        <option value="9:00">9:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="13:00">1:00 PM</option>
                        <option value="14:00">2:00 PM</option>
                        <option value="15:00">3:00 PM</option>
                        <option value="16:00">4:00 PM</option>
                        <option value="17:00">5:00 PM</option>
                    </select>
                </div>
            </div>

            <!-- <div class="schedule-section">
                <h2>Price Details</h2>
                <div class="price-details">
                    <div class="price-item">
                        <span class="label">Total Price:</span>
                        <span class="value">$ <?= $price ?></span>
                    </div>
                    <div class="price-item">
                        <span class="label">Quantity:</span>
                        <span class="value">⨯ <?= $quantity ?></span>
                    </div>
                    <div class="price-item">
                        <span class="label">GST (10%):</span>
                        <span class="value">$ <?= $gst ?></span>
                    </div>
                    <?php if ($service_type == 1): ?>
                        <div class="price-item">
                            <span class="label">Fitting Charge:</span>
                            <span class="value">$ <?= $fittingCharge ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($mobileServiceCharge > 0): ?>
                        <div class="price-item">
                            <span class="label">Mobile Service Charge:</span>
                            <span class="value">$ <?= $mobileServiceCharge ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="total-line">
                        <span class="label total-label">Total:</span>
                        <span class="value total-value">$ <?= $finalAmount ?></span>
                    </div>

                    <button class="confirm-button" onclick="window.location.href='payment.php'">Add to Cart</button>
                </div>
            </div> -->
            <button class="confirm-button" onclick="window.location.href='payment_done_page.php'">Confirm Booking</button>
        </div>
    </main>
    <script>
        // Get the modal
        var modal = document.getElementById("addressModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the page loads, show the modal if required
        <?php if ($service_type == 3 && $address == ''): ?>
            modal.style.display = "block"; //Open modal;
        <?php endif; ?>

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function storeAddress() {
            if ($address != '')
                modal.style.display = "none";
        }
    </script>

    <?php include "footer.php"; ?>
</body>

</html>