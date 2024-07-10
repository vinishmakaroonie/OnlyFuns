<?php
session_start();
$reservations = isset($_SESSION['reservations']) ? $_SESSION['reservations'] : [];
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
        <a href="view_reservations.php">View Reservations</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
    </div>
    <div class="container">
        <h2>Reservation History</h2>
        <ul class="reservation-list">
            <?php if (!empty($reservations)): ?>
                <?php foreach ($reservations as $reservation): ?>
                    <li class="reservation-item">
                        <div class="reservation-details">
                            <p><strong>Reservation ID:</strong> <?php echo htmlspecialchars($reservation['transaction_id']); ?></p>
                            <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($reservation['customer_name']); ?></p>
                            <p><strong>Room Type:</strong> <?php echo htmlspecialchars($reservation['room_type']); ?></p>
                            <p><strong>Check-in Date:</strong> <?php echo htmlspecialchars($reservation['check_in_date']); ?></p>
                            <p><strong>Check-out Date:</strong> <?php echo htmlspecialchars($reservation['check_out_date']); ?></p>
                            <p><strong>Total:</strong> $<?php echo number_format($reservation['total'], 2); ?></p>
                            <p><strong>Adults:</strong> <?php echo htmlspecialchars($reservation['adults']); ?></p>
                            <p><strong>Children:</strong> <?php echo htmlspecialchars($reservation['children']); ?></p>
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
