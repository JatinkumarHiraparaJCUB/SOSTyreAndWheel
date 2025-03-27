<?php
// get_address.php

session_start();
if (!isset($_SESSION['service_type'])|| !isset($_SESSION['product_id']) || !isset($_SESSION['quantity'])) {
    // Handle any case where product not posted correctly.
    echo "You did not get to this stage by a correct action, please check";
       //Kill script to avoid problems to follow
        exit;
    }
//Store and Sanitize to verify and secure input for address page.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $address = $_POST['address']; //Not using this, but good to define.
          $_SESSION['address'] = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
          // All data now is set so pass to payment.php
          header("Location: payment.php");
          //Kill script
           exit;
      }
//Always kill script to avoid problems after the header()

?>

<!DOCTYPE html>
<html>
<head>
    <title>Address Information</title>
    <!--Add here code for CSS etc, as you'll want from other pages! !-->
</head>
<body>

<form method="post">
    <h1>Confirm Information</h1>
    <p>Provide the information for shipping your new Tyres: <p/>
    <label for="firstName">Address:</label><br>
    <input type="text" id="address" name="address"><br><br>
   <input type="submit" value="Submit">
</form>
</body>
</html>