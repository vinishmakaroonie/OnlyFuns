<?php
// Ensure the 'data' directory and 'reservations.json' file exist
$dataDir = 'data';
$reservationsFile = $dataDir . '/reservations.json';

if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

if (!file_exists($reservationsFile)) {
    file_put_contents($reservationsFile, json_encode([]));
}

// Read reservations data
$reservations = json_decode(file_get_contents($reservationsFile), true);

// Check if a reservation ID is provided for cancellation
$message = '';
if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];

    // Validate or sanitize $reservationId if needed
    $found = false;
    foreach ($reservations as $index => $reservation) {
        if ($reservation['id'] == $reservationId) {
            // Calculate penalty based on cancellation date
            $reservationDate = strtotime($reservation['check_in_date']);
            $currentDate = time();
            $daysDifference = floor(($reservationDate - $currentDate) / (60 * 60 * 24));

            if ($daysDifference >= 5) {
                $penalty = 0.10 * $reservation['room_rate'];
            } elseif ($daysDifference >= 4) {
                $penalty = 0.15 * $reservation['room_rate'];
            } elseif ($daysDifference >= 2) {
                $penalty = 0.20 * $reservation['room_rate'];
            } else {
                $penalty = 0.0;
            }

            // Remove the reservation from the array
            unset($reservations[$index]);

            // Write updated reservations data back to the file
            file_put_contents($reservationsFile, json_encode(array_values($reservations)));

            // Display cancellation confirmation with penalty
            $message = "Reservation cancelled successfully. Penalty: $" . number_format($penalty, 2);
            $found = true;
            break;
        }
    }

    if (!$found) {
        $message = "Reservation not found.";
    }
} else {
    $message = "No reservation ID provided for cancellation.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancel Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navigation">
        <h1>OnlyFuns Hotel Reservation</h1>
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="make_reservation.php">Make Reservation</a>
        <a href="view_reservations.php">View Reservations</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
    </div>
    <div class="container">
        <h2>Cancel Reservation</h2>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="view_reservations.php" class="button">Back to Reservations</a>
        <a href="index.php" class="button">Home</a>
    </div>
</body>
</html>
