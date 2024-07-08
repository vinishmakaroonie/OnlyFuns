<?php
session_start();

// Function to generate transaction ID
function generateTransactionID($customerName, $checkInDate, $roomType) {
    $shortCustomerName = strtoupper(substr($customerName, 0, 2));
    $month = strtoupper(date('M', strtotime($checkInDate)));
    $day = date('d', strtotime($checkInDate));
    $year = date('Y', strtotime($checkInDate));
    $roomTypeCode = strtoupper(substr($roomType, 0, 3));

    // Example format: THFEB100222-FIC00001
    return "{$shortCustomerName}{$month}{$day}{$year}-{$roomTypeCode}00001"; // Replace with actual logic
}

// Initialize reservation saved status
$reservationSaved = false;
$message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $customerName = htmlspecialchars($_POST['customer_name']);
    $checkInDate = htmlspecialchars($_POST['check_in_date']);
    $checkOutDate = htmlspecialchars($_POST['check_out_date']);
    $roomType = htmlspecialchars($_POST['room_type']);
    $adults = (int)$_POST['adults'];
    $children = (int)$_POST['children'];

    // Generate transaction ID
    $transactionID = generateTransactionID($customerName, $checkInDate, $roomType);

    // Calculate total cost (for simplicity, using a fixed rate per room type)
    $roomPrices = [
        'Single' => 100,
        'Double' => 150,
        'Suite' => 200,
        'Deluxe' => 250,
        'Presidential' => 500,
    ];
    $total = $roomPrices[$roomType] * (strtotime($checkOutDate) - strtotime($checkInDate)) / (60 * 60 * 24);

    // Save reservation to session
    $newReservation = [
        'customer_name' => $customerName,
        'check_in_date' => $checkInDate,
        'check_out_date' => $checkOutDate,
        'room_type' => $roomType,
        'adults' => $adults,
        'children' => $children,
        'total' => $total,
        'transaction_id' => $transactionID
    ];

    if (!isset($_SESSION['reservations'])) {
        $_SESSION['reservations'] = [];
    }
    $_SESSION['reservations'][] = $newReservation;

    $reservationSaved = true;
    $message = "Reservation confirmed! Transaction ID: $transactionID";
}
?>

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
                <select id="room_type" name="room_type" required>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Suite">Suite</option>
                    <option value="Deluxe">Deluxe</option>
                    <option value="Presidential">Presidential</option>
                </select>

                <label for="adults">Number of Adults:</label>
                <input type="number" id="adults" name="adults" required>

                <label for="children">Number of Children:</label>
                <input type="number" id="children" name="children" required>

                <input type="submit" value="Confirm Reservation">
            </form>
        </div>

        <?php if ($reservationSaved): ?>
            <div class="reservation-result">
                <h2>Reservation Status</h2>
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
    </div>

    <a href="index.php">Go Back</a>
</body>
</html>
