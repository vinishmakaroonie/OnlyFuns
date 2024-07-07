<?php
// Ensure the 'data' directory and 'reservations.json' file exist
if (!is_dir('data')) {
    mkdir('data', 0777, true);
}
if (!file_exists('data/reservations.json')) {
    file_put_contents('data/reservations.json', json_encode([]));
}

// Read reservations data
$reservations = json_decode(file_get_contents('data/reservations.json'), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>OnlyFuns Hotel Reservation</h1>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="make_reservation.php">Make Reservation</a>
        <a href="view_reservations.php">View Reservations</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
    </div>
    <div class="container">
        <h1>Reservation History</h1>
        <ul class="reservation-list">
            <?php if (!empty($reservations)): ?>
                <?php foreach ($reservations as $reservation): ?>
                    <li class="reservation-item">
                        <div class="reservation-details">
                            <p><strong>Reservation ID:</strong> <?php echo htmlspecialchars($reservation['id']); ?></p>
                            <p><strong>Room Type:</strong> <?php echo htmlspecialchars($reservation['room_type']); ?></p>
                            <p><strong>Check-in Date:</strong> <?php echo htmlspecialchars($reservation['check_in_date']); ?></p>
                            <p><strong>Check-out Date:</strong> <?php echo htmlspecialchars($reservation['check_out_date']); ?></p>
                            <p><strong>Total:</strong> $<?php echo number_format($reservation['total'], 2); ?></p>
                        </div>
                        <div class="reservation-actions">
                            <a class="button view" href="view_single_reservation.php?id=<?php echo htmlspecialchars($reservation['id']); ?>">View</a>
                            <a class="button delete" href="cancel_reservation.php?id=<?php echo htmlspecialchars($reservation['id']); ?>">Cancel</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No reservations found</li>
            <?php endif; ?>
        </ul>
        <a href="index.php" class="button">Back to Home</a>
    </div>
</body>
</html>
