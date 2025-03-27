<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST)) {
        // Get values from POST request
        $width = isset($_POST['width']) ? $_POST['width'] : '';
        $profile = isset($_POST['profile']) ? $_POST['profile'] : '';
        $rim = isset($_POST['rim']) ? $_POST['rim'] : '';
        $model = isset($_POST['model']) ? $_POST['model'] : '';
    } else {
        echo "No data received!";
    }
} else {
    echo "Invalid request!";
}


if ($width == '' || $rim == '' || $profile == '') {
    if ($model == '') {
        $sql = "SELECT * FROM tyres";
    } else {
        $sql = "SELECT * FROM tyres WHERE model = '$model'";
    }
} else {
    if ($model == '') {
        $sql = "SELECT * FROM tyres WHERE width = $width AND `profile` = $profile AND rim = $rim";
    } else {
        $sql = "SELECT * FROM tyres WHERE width = $width AND `profile` = $profile AND rim = $rim AND model = '$model'";
    }
}


include 'connection_db.php';
// Retrieve search query from the URL
$result = $conn->query($sql);

include "header.php";

// session_start();

// MODEL LIST
$models = array();
$products = array();


if ($result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        $products[] = $data;
        if (isset($_SESSION['models'])) {
            $models = $_SESSION['models'];
        } else {
            $models[] = $data['model'];
        }
    }
    $models = array_unique($models); // Remove duplicates
    sort($models); // Sort the array alphabetically

    $_SESSION['models'] = $models;
} else {
    echo "<p>No data found.</p>";
}
// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyre Search Results - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to CSS file -->

    <style>
        .product-card {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            position: relative;
            border: 1px solid #ddd;
            /* Add a border */
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .budget-tag {
            position: absolute;
            top: 0;
            left: 0;
            background-color: #dc3545;
            color: white;
            padding: 5px 8px;
            font-size: 0.8em;
            border-radius: 4px 0 4px 0;
            z-index: 1;
        }

        .product-image {
            width: 100%;
            height: 220px;
            object-fit: contain;
            /* Make sure the image fits within the area */
            background-color: #f9f9f9;
            /* Add a background color */
            padding: 10px;
            /* Add some padding around the image */
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 1.2em;
            color: #333;
            font-weight: bold;
        }

        .product-model {
            font-style: italic;
            color: #777;
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        .pay-on-fitting {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75em;
            margin-bottom: 10px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-rating .star {
            color: #ffc107;
            font-size: 1.1em;
            margin-right: 3px;
        }

        .product-rating .rating-value {
            font-size: 0.9em;
            color: #777;
        }

        .price-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 15px;
        }

        .price-box {
            background-color: #ffc107;
            color: #222;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            font-size: 0.85em;
            font-weight: bold;
        }

        .price-box .price {
            font-size: 1.1em;
            margin-top: 5px;
        }

        .price-grid .price-box i {
            margin-left: 5px;
        }

        .view-details {
            display: block;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
            padding: 10px;
        }

        .view-details:hover {
            color: #0056b3;
        }

        /*Responsive Layout*/
        @media (max-width: 600px) {
            .price-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 567px) {

            .product-image {
                height: auto;
            }
        }

        .product-grid-container {
            display: grid;
            /* grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); */
            grid-template-columns: auto auto auto auto;
            gap: 20px;
            padding: 20px;
            background-color: transparent;
        }

        .product-card {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 100%;
            height: 200px;
            /* Fixed height for consistent image display */
            /* object-fit: fit; */
            border-bottom: 1px solid #eee;
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 1.2em;
            color: #333;
            font-weight: bold;
        }

        .product-model {
            font-style: italic;
            color: #777;
            margin-bottom: 10px;
        }

        .price-box {
            background-color: #ffc107;
            color: #222;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            font-size: 0.85em;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .price-box i {
            margin-left: 5px;
        }

        .view-details {
            display: block;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
            padding: 10px;
            border-top: 1px solid #eee;
        }

        .view-details:hover {
            color: #0056b3;
        }

        .form-container {
            display: flex;
            gap: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-grid-container {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                /* Adjust minmax width as needed */
            }

            .product-image {
                height: 150px;
                /* Adjust image height for smaller screens */
            }
        }
    </style>
</head>

<body>

    <!-- <?php include "header.php"; ?> -->
    <main>
        <div class="container">

            <form method="post" action="#" class="form-container">
                <label for="width">Model:</label>
                <select id="model" name="model">
                    <option value="">Select Model</option>
                    <?php
                    foreach ($models as $model) {
                        echo "<option value='$model'>$model</option>";
                    }
                    ?>
                </select>
                <button type="submit">Search</button>
            </form>

        </div>
        <section class="container">

            <div class="product-grid-container">

                <?php if (count($products) > 0): ?>
                    <!-- <select id="model">
                <option value="">Tyre Model</option>
                <?php foreach ($models as $model) {
                        echo '<option value="model1">' . htmlspecialchars($model) . '</option>';
                    }
                ?>
            </select> -->
                    <?php foreach ($products as $product):
                        $availableStock = htmlspecialchars($product['available_stock_count']);
                        $title = htmlspecialchars($product['title']);
                        $model = htmlspecialchars($product['model']);
                        $price = htmlspecialchars($product['price']);
                        $tyreId = htmlspecialchars($product['tyre_id']);

                    ?>

                        <div class="product-card">
                            <img src="./image/tyre.png" alt="<?= $title ?>" class="product-image">
                            <div class="product-info">
                                <h3 class='product-title'><?= $title ?></h3>
                                <p class="product-model"><?= $model ?></p>
                                <div class="price-box">
                                    Pickup Price <br>
                                    $<?= htmlspecialchars(number_format($product['price'], 2)) ?>
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <!-- Hidden inputs and a Submit Button (Styled like a Link) -->

                                <form method="post" action="mode_of_purchase.php">

                                    <input type="hidden" name="product_id" value="<?= $tyreId ?>">
                                    <input type="hidden" name="price" value="<?= $price ?>">
                                    <label style="color: black;" for="quantity">Select Quantity : </label>
                                    <select name="quantity" id="quantity" class="form-select">
                                        <?php for ($i = 1; $i <= $availableStock; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        } ?>
                                    </select>
                                    <span class="product-model"> / <?= $availableStock ?> Available</span>
                                    <button type="submit" class="buy-now">Buy Now</button>
                                </form>

                            </div>
                        </div>

                    <?php endforeach; ?>

                <?php else: ?>
                    <p>No data found.</p>
                <?php endif; ?>
            </div>

        </section>

    </main>

    <?php include "footer.php"; ?>
</body>

</html>