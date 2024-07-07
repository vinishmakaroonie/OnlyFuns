<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Hotel Reservation System</title>
</head>
<body>
    <h1>Welcome to Hotel Reservation System</h1>
    <div>
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="make_reservation.php">Make Reservation</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
    </div>
    <div>
        <h2>Make Reservation</h2>
        <form action="make_reservation.php" method="POST">
            <label for="customer_name">Customer Name:</label><br>
            <input type="text" id="customer_name" name="customer_name" required><br>
            
            <label for="check_in_date">Check-in Date:</label><br>
            <input type="date" id="check_in_date" name="check_in_date" required><br>
            
            <label for="check_out_date">Check-out Date:</label><br>
            <input type="date" id="check_out_date" name="check_out_date" required><br>
            
            <label for="room_type">Room Type:</label><br>
            <input type="text" id="room_type" name="room_type" required><br>
            
            <label for="adults">Number of Adults:</label><br>
            <input type="number" id="adults" name="adults" min="1" required><br>
            
            <label for="children">Number of Children:</label><br>
            <input type="number" id="children" name="children" min="0" required><br>
            
            <input type="submit" value="Make Reservation">
        </form>
    </div>
</body>
</html>