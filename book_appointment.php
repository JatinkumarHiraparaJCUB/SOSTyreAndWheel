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

        .booking-form button {
            text-align: center;
            text-decoration: none;
            font-size: 16px;

            background-color: #001f3f;
            color: #ffc107;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .booking-form button:hover {
            background-color: #001529;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include "header.php";
    $date = "";
    $time = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['date'], $_POST['time'])) {
        if (
            isset($_POST['date']) && !empty($_POST['date'])
            && isset($_POST['time']) && !empty($_POST['time'])
        ) {

            header("Location: payment_done_page.php");
        } else {
            echo "<script>alert('Please select a date and time first.');</script>";
        }
    } else {
        echo "<script>alert('Please select a date and time first.');</script>";
    }

    ?>

    <main>

        <div class="schedule-container">
            <form method="post">
                <div class="schedule-container">
                    <div class="schedule-section">
                        <h2>Schedule your Appointment</h2>
                        <div class="datetime-selection">
                            <label for="date">Date :</label>
                            <input type="date" id="date" name="date" value="date">
                            <label for="time">Time :</label>
                            <select id="time" name="time">
                                <option value="">Select Time</option>
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
                        <div class="booking-form">
                            <button type="submit">Booking</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </main>

    <?php include "footer.php"; ?>
</body>

</html>