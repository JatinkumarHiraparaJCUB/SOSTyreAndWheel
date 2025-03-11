<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST)) {
        // Get values from POST request
        $width = isset($_POST['width']) ? $_POST['width'] : '';
        $profile = isset($_POST['profile']) ? $_POST['profile'] : '';
        $rim = isset($_POST['rim']) ? $_POST['rim'] : '';
    } else {
        echo "No data received!";
    }
} else {
    echo "Invalid request!";
}


if($width=='' || $rim=='' || $profile=='') {
    $sql = "SELECT * FROM tyres";
} else {
    $sql = "SELECT * FROM tyres WHERE width = $width AND `profile` = $profile AND rim = $rim";
}


include 'connection_db.php';
// Retrieve search query from the URL
$result = $conn->query($sql);

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
<?php include "header.php"; ?>
    <main>
        <section class="container">
            <!-- <div class="filter-bar">
                <h2>Filter</h2>

                <select id="brand">
                    <option value="">Tyre Brand</option>
                    <option value="brand1">Hankook</option>
                    <option value="brand2">Bridgestone</option>
                </select>

                <select id="model">
                    <option value="">Tyre Model</option>
                    <option value="model1">Model 1</option>
                    <option value="model2">Model 2</option>
                </select>

                <select id="type">
                    <option value="">Tyre Type</option>
                    <option value="type1">Type 1</option>
                    <option value="type2">Type 2</option>
                </select>

                <select id="vehicle-type">
                    <option value="">Vehicle Type</option>
                    <option value="type1">Car</option>
                    <option value="type2">Truck</option>
                </select>

                <select id="car-make">
                    <option value="">Car Make</option>
                    <option value="make1">Toyota</option>
                    <option value="make2">Ford</option>
                </select>


                <select id="speed-rating">
                    <option value="">Min Speed Rating</option>
                    <option value="H">H</option>
                    <option value="V">V</option>
                    <option value="W">W</option>
                </select>

                <select id="run-flat">
                    <option value="">Run Flat</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>

                <button>Search</button>
            </div> -->


            <div class="product-grid-container">
                <?php
                // Check if there's any data to display
                if ($result->num_rows > 0) {
                    while ($data = $result->fetch_assoc()) {
                ?>
                        <div class="product-card">
                            <img src="./image/tyre.png" alt="<?= htmlspecialchars($data['title']) ?>" class="product-image">
                            <div class="product-info">
                                <h3 class='product-title'><?= htmlspecialchars($data['title']) ?></h3>
                                <p class="product-model"><?= htmlspecialchars($data['model']) ?></p>
                                <div class="price-box">
                                    Pickup Price <br>
                                    $<?= htmlspecialchars(number_format($data['price'], 2)) ?>
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <a href="mode_of_purchase.php" class="view-details">View Details</a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No data found.</p>";
                }
                ?>
            </div>

        </section>
    </main>
   
    <?php include "footer.php"; ?>
</body>

</html>