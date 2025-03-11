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
    </style>
</head>

<body>

    <?php include "header.php"; ?>
    <main>
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

            <div class="schedule-section">
                <h2>Price Details</h2>
                <div class="price-details">
                    <div class="price-item">
                        <span class="label">Tyre Price:</span>
                        <span class="value">$195.00</span>
                    </div>
                    <div class="price-item">
                        <span class="label">Quantity:</span>
                        <span class="value">1</span>
                    </div>
                    <div class="price-item">
                        <span class="label">GST (10%):</span>
                        <span class="value">$19.50</span>
                    </div>
                    <div class="total-line">
                        <span class="label total-label">Total:</span>
                        <span class="value total-value">$214.50</span>
                    </div>
                    <button class="confirm-button" onclick="window.location.href='payment_done_page.php'">Confirm Payment</button>
                </div>
            </div>

        </div>
    </main>

   
    <?php include "footer.php"; ?>
    <script>
        const monthYear = document.querySelector(".month-year");
        const daysContainer = document.querySelector(".days");
        const prev = document.querySelector(".prev");
        const next = document.querySelector(".next");

        let today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();

        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        function updateCalendar() {
            monthYear.textContent = `${months[currentMonth]} ${currentYear}`;

            let days = "";
            let firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
            let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            for (let i = 1; i <= firstDayOfMonth; i++) {
                days += `<div class="day empty"></div>`;
            }

            for (let i = 1; i <= daysInMonth; i++) {
                days += `<div class="day">${i}</div>`;
            }

            daysContainer.innerHTML = days;
        }

        prev.addEventListener("click", () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            updateCalendar();
        });

        next.addEventListener("click", () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            updateCalendar();
        });

        updateCalendar();
        
    </script>

</body>

</html>