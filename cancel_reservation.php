<?php
session_start();
$reservations = isset($_SESSION['reservations']) ? $_SESSION['reservations'] : [];

// Check if a transaction ID is provided for cancellation
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['transaction_id'])) {
        $transactionId = $_POST['transaction_id'];

        // Validate or sanitize $transactionId if needed
        $found = false;
        foreach ($reservations as $index => $reservation) {
            if ($reservation['transaction_id'] == $transactionId) {
                // Calculate penalty based on cancellation date (example logic)
                $reservationDate = strtotime($reservation['check_in_date']);
                $currentDate = time();
                $daysDifference = floor(($reservationDate - $currentDate) / (60 * 60 * 24));

                if ($daysDifference >= 5) {
                    $penaltyPercentage = 10;
                } elseif ($daysDifference >= 4) {
                    $penaltyPercentage = 15;
                } elseif ($daysDifference >= 2) {
                    $penaltyPercentage = 20;
                } else {
                    $penaltyPercentage = 0;
                }

                $penalty = ($penaltyPercentage / 100) * $reservation['total'];

                // Remove the reservation from $_SESSION
                unset($_SESSION['reservations'][$index]);

                // Display cancellation confirmation with penalty
                $message = "Reservation with Transaction ID: $transactionId cancelled successfully.";
                if ($penalty > 0) {
                    $message .= " Penalty: $" . number_format($penalty, 2);
                    $message .= " (" . $penaltyPercentage . "% of Total)";
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            $message = "Reservation with Transaction ID: $transactionId not found.";
        }
    } else {
        $message = "No Transaction ID provided for cancellation.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancel Reservation</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .penalty-sign {
            font-style: italic;
            color: #ff0000;
            margin-bottom: 10px;
        }
        .penalty-details {
            margin-bottom: 20px;
        }
        .penalty-details li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="navigation">
        <h1>OnlyFuns Hotel Reservation</h1>
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="view_reservations.php">View Reservations</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
    </div>
    <div class="container">
        <h2>Cancel Reservation</h2>
        <p class="penalty-sign">Penalties apply for cancellations made close to check-in date:</p>
        <ul class="penalty-details">
            <li>20% of Room Rate - Cancelling within 2 days</li>
            <li>15% of Room Rate - Cancelling within 4 days</li>
            <li>10% of Room Rate - Cancelling 5 days or more in advance</li>
        </ul>
        <p><?php echo htmlspecialchars($message); ?></p>
        
        <?php if (empty($message)): ?>
        <form method="POST" action="cancel_reservation.php">
            <label for="transaction_id">Select Transaction ID to Cancel:</label>
            <select id="transaction_id" name="transaction_id" required>
                <option value="" disabled selected>Select Transaction ID</option>
                <?php foreach ($reservations as $reservation): ?>
                    <option value="<?php echo htmlspecialchars($reservation['transaction_id']); ?>">
                        <?php echo htmlspecialchars($reservation['transaction_id']); ?> - <?php echo htmlspecialchars($reservation['customer_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Cancel Reservation</button>
        </form>
        <?php endif; ?>
        
        <a href="view_reservations.php" class="button">Back to Reservations</a>
        <a href="index.php" class="button">Home</a>
    </div>
</body>
</html>
