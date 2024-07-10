<?php
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reservation_id'])) {
        $reservation_id = $_POST['reservation_id'];
        
        // Sanitize input to prevent SQL injection
        $reservation_id = intval($reservation_id);

        $sql = "DELETE FROM reservations WHERE id = $reservation_id";

        if ($conn->query($sql) === TRUE) {
            $message = "Reservation canceled successfully.";
        } else {
            $message = "Error canceling reservation: " . $conn->error;
        }
    } else {
        $message = "Reservation ID not provided.";
    }
}

$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>OnlyFuns Hotel Reservation</title>
</head>
<body>
    <div class="hero">
        <div class="hero-content">
            <h1>Welcome to OnlyFuns Hotel</h1>
        </div>
    </div>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="view_reservations.php">View Reservation</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
    </div>
    <div class="intro">
    <p>Welcome to OnlyFuns Hotel, your perfect getaway destination for an unforgettable stay. Nestled in the heart of the city, our luxurious retreat offers a haven of relaxation and indulgence.</p>
        <a href="view_rooms.php" class="button">Book a Room</a>
    </div>
        <div class="about">
        <h2>About Our Hotel</h2>
        <p class="hotel-description">OnlyFuns Hotel is a luxurious retreat located in the heart of the city. We offer top-notch amenities and services to make your stay unforgettable. Enjoy our world-class spa, gourmet restaurants, and spacious rooms with stunning views.</p>

        <p><strong class="feature-heading">Our hotel features:</strong></p>
        <ul class="features-list">
            <li>A state-of-the-art fitness center equipped with the latest exercise machines and free weights</li>
            <li>An indoor swimming pool and hot tub for relaxation</li>
            <li>A business center with high-speed internet access and meeting rooms</li>
            <li>Concierge services to assist with your travel plans and local attractions</li>
            <li>Free Wi-Fi throughout the hotel</li>
            <li>24-hour room service to cater to your needs at any time</li>
            <li>Pet-friendly accommodations</li>
            <li>Complimentary breakfast with a variety of options to suit all tastes</li>
        </ul>
    </div>

        <div class="gallery">
            <img src="images/homehotel1.jpg" alt="Hotel Image 1">
            <img src="images/homehotel2.jpg" alt="Hotel Image 2">
            <img src="images/homehotel3.jpg" alt="Hotel Image 3">
        </div>
    </div>
</body>
</html>
