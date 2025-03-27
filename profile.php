<?php
include 'connection_db.php';

$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $fullName = htmlspecialchars($user['name']);
    $name = explode(' ', $fullName);

    $firstName = $name[0];
    $lastName = $name[1];
    $email = htmlspecialchars($user['email']);
    $contactNumber = htmlspecialchars($user['contact']);
    $postcode = htmlspecialchars($user['postcode']);
} else {
    // Handle user not found or other errors
    echo "User not found or error fetching profile.";
    exit();
}

// Handle Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_firstName = $_POST['firstName'];
    $new_lastName = $_POST['lastName'];

    $new_fullName = $new_firstName . ' ' . $new_lastName;
    $new_contactNumber = $_POST['contactNumber'];
    $new_postcode = $_POST['postcode'];

    // Prepare and execute update query
    $update_sql = "UPDATE users SET `name` = ?, contact = ?, postcode = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $new_fullName, $new_contactNumber, $new_postcode, $user_id);

    if ($update_stmt->execute()) {
        // Update successful: Fetch updated data
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $fullName = htmlspecialchars($user['name']);
            $name = explode(' ', $fullName);

            $firstName = $name[0];
            $lastName = $name[1];
            $email = htmlspecialchars($user['email']);
            $contactNumber = htmlspecialchars($user['contact']);
            $postcode = htmlspecialchars($user['postcode']);
        }

        $successMessage = "Profile updated successfully!";
    } else {
        $errorMessage = "Error updating profile: " . $update_stmt->error;
    }

    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* Yellow background */
            background-color: #ffc107;
            position: relative;
            /* For the overlay */
            overflow: hidden;
            /* To prevent scrollbar in main section */
        }

        
        /* Main Content Styling */
        main {
            flex: 1;
            /* Allow main to grow and fill the remaining space */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0px;
            /* Yellow background */
            /*  background-color: #ffc107;*/

        }


        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.2);
            /* Yellow background */
            z-index: -1;
        }

        .signup-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            /* Wider container */
            max-width: 90%;
            /* Ensure it doesn't overflow on smaller screens */
            text-align: center;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .signup-container h1 {
            margin-bottom: 20px;
            color: #001f3f;
        }

        .signup-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            /* Include padding and border in the element's total width */
        }

        .signup-container button {
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

        .signup-container button:hover {
            background-color: #333;
        }

        .signup-container p {
            margin-top: 20px;
            font-size: 14px;
        }

        .signup-container p a {
            color: #001f3f;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-container p a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .login-container {
                flex-direction: column;
                /* Stack login box and logo on smaller screens */
                align-items: center;
            }

            .login-box,
            .logo-box {
                width: 90%;
                /* Adjust width for smaller screens */
                max-width: 400px;
                /* Limit the width */
            }
        }

        /*Main code body*/
        main {
            padding: 0px;
            background-color: #ffc107;
            position: relative;
            /* Needed to make z-index work on the logo container */
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Centers content horizontally */
            justify-content: center;
            /* Centers content vertically */
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .editMode .form-control {
            border: 1px solid #007bff;
            /* Highlight the input field */
        }

        edit-button {
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

        #profileForm {
            display: none;
            /* Hide the form by default */
        }

        body.editMode #profileForm {
            display: block;
            /* Show the form when in edit mode */
        }

        body.editMode .profile-details {
            display: none;
        }

        .edit-button {
            margin-top: 20px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            /* Green */
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-button:hover {
            background-color: #43A047;
            /* Darker green */
        }

        /* Logo Box Styles */
        .logo-box {
            width: 400px;
            /* Fixed width */
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-box img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editButton = document.getElementById("editButton");
            var profileForm = document.getElementById("profileForm");
            editButton.addEventListener("click", function() {
                document.body.classList.toggle('editMode'); // TOGGLE a class to the element
            });
        });
    </script>
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <!--  <div class="login-container">

        

        For now, keep the same general design, to simplify assist in any problems that may arise-->

        <div class="signup-container">

            <h1>My Profile</h1>
            <?php if (isset($successMessage)) { ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php } ?>
            <?php if (isset($errorMessage)) { ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php } ?>
            <div class="profile-details">
                <div class="detail-item">
                    <strong>First Name:</strong> <?= $firstName ?>
                </div>
                <div class="detail-item">
                    <strong>Last Name:</strong> <?= $lastName ?>
                </div>
                <div class="detail-item">
                    <strong>Email:</strong> <?= $email ?>
                </div>
                <div class="detail-item">
                    <strong>Contact Number:</strong> <?= $contactNumber ?>
                </div>
                <div class="detail-item">
                    <strong>Postcode:</strong> <?= $postcode ?>
                </div>
            </div>
            <button type="button" class="edit-button" id="editButton" onclick="editMode">Edit profile</button>

            <form method="post" action="" id="profileForm">
                <label><b>* First Name</b></label>
                <input type="text" id="firstName" class="form-control" name="firstName" value="<?= $firstName ?>" placeholder="First Name" required>

                <label><b>* Last Name</b></label>
                <input type="text" id="lastName" class="form-control" name="lastName" value="<?= $lastName ?>" placeholder="Last Name" required>

                <label><b>* Email</b></label>
                <input type="email" id="email" class="form-control" name="email" value="<?= $email ?>" placeholder="Email" readonly>

                <label><b>* Contact Number</b></label>
                <input type="tel" id="contactNumber" class="form-control" name="contactNumber" value="<?= $contactNumber ?>" placeholder="Contact Number" required>

                <label><b>* Postcode</b></label>
                <input type="postcode" id="postcode" class="form-control" name="postcode" value="<?= $postcode ?>" placeholder="Postcode" required>
                <button type="submit" name="update_profile">Update Profile</button>

            </form>

        </div>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>