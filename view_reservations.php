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
<html>
<head>
    <meta charset="UTF-8">
    <title>View Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Reservation History</h1>
        <ul>
            <?php if (!empty($reservations)): ?>
                <?php foreach ($reservations as $reservation): ?>
                    <li>
                        Reservation ID: <?php echo htmlspecialchars($reservation['id']); ?> - 
                        Room Type: <?php echo htmlspecialchars($reservation['room_type']); ?> - 
                        Check-in Date: <?php echo htmlspecialchars($reservation['checkin_date']); ?> - 
                        Check-out Date: <?php echo htmlspecialchars($reservation['checkout_date']); ?> - 
                        Total: $<?php echo htmlspecialchars($reservation['total']); ?>
                        [<a class="view" href="view_single_reservation.php?id=<?php echo htmlspecialchars($reservation['id']); ?>">View</a>]
                        [<a class="delete" href="cancel_reservation.php?id=<?php echo htmlspecialchars($reservation['id']); ?>">Cancel</a>]
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No reservations found.</li>
            <?php endif; ?>
        </ul>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
