
<!DOCTYPE html>     
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - SOS Tyres and Wheels</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
   <?php include "header.php"; ?>
    <main>
        <div class="contact-us-container">
            <div class="contact-container">
                <div class="contact-image">
                </div>
                <div class="contact-form">
                    <h2>Contact Us</h2>
                    <form id="contactForm" action="#" method="post">
                        <label for="fullName">Full Name:</label>
                        <input type="text" id="fullName" name="fullName" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="5" required></textarea>

                        <button type="submit">Submit</button>
                    </form>
                </div>
                <div class="contact-details">
                    <h2>Contact Information</h2>
                    <p><i class="fas fa-phone"></i> 0403237317</p>
                    <p><i class="fas fa-envelope"></i> sostyres@gmail.com</p>

                    <h3>Address</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 41 Lensworth st, Coopers plains, QLD 4108</p>

                    <h3>Follow Us:</h3>
                    <div class="social-icons">
                        <a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a>
                        <a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook"></i></a>
                        <a href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-google"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>