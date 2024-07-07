<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>OnlyFuns Hotel Reservation</h1>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="make_reservation.php">Make Reservation</a>
        <a href="view_reservations.php">View Reservation</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
    </div>

    <div class="container">
        <div class="reservation-form">
            <form method="POST">
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" required>

                <label for="check_in_date">Check-in Date:</label>
                <input type="date" id="check_in_date" name="check_in_date" required>

                <label for="check_out_date">Check-out Date:</label>
                <input type="date" id="check_out_date" name="check_out_date" required>

                <label for="room_type">Room Type:</label>
                <input type="text" id="room_type" name="room_type" required>

                <label for="adults">Number of Adults:</label>
                <input type="number" id="adults" name="adults" required>

                <label for="children">Number of Children:</label>
                <input type="number" id="children" name="children" required>

                <input type="submit" value="Confirm Reservation">
            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle form submission here as per your existing PHP logic
            // Display reservation result or error message
            // Example output:
            if (isset($message)) {
                echo "<div class='reservation-result'>";
                echo "<h2>Reservation Status</h2>";
                echo "<p>$message</p>";
                echo "</div>";
            }
        }
        ?>
    </div>

    <a href="index.php">Go Back</a>
</body>
</html>
