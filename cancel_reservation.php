<?php
// Include your database connection file
include 'db.php';

$message = '';


// Function to calculate cancellation penalty based on days difference
function calculateCancellationPenalty($check_in_date, $check_out_date, $room_price) {
    $checkIn = new DateTime($check_in_date);
    $checkOut = new DateTime($check_out_date);
    $diff = $checkIn->diff($checkOut);
    $numOfDays = $diff->days;

    if ($numOfDays >= 5) {
        return $room_price * 0.10; // 10% penalty for 5 days or more
    } elseif ($numOfDays >= 4) {
        return $room_price * 0.15; // 15% penalty for 4 days
    } elseif ($numOfDays >= 2) {
        return $room_price * 0.20; // 20% penalty for 2 days
    } else {
        return 0; // No penalty if less than 2 days
    }
}

// Handle POST request to cancel reservation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reservation_id'])) {
        $reservation_id = $_POST['reservation_id'];

        // Fetch reservation details from database
        $sql = "SELECT * FROM reservations WHERE id = $reservation_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $check_in_date = $row['check_in_date'];
            $check_out_date = $row['check_out_date'];
            $room_price = $row['room_price'];

            // Calculate penalty
            $penalty = calculateCancellationPenalty($check_in_date, $check_out_date, $room_price);

            // Apply cancellation and update reservation status
            $sql = "DELETE FROM reservations WHERE id = $reservation_id";

            if ($conn->query($sql) === TRUE) {
                $message = "Reservation canceled successfully. Penalty applied: $" . number_format($penalty, 2);
            } else {
                $message = "Error canceling reservation: " . $conn->error;
            }
        } else {
            $message = "Reservation not found.";
        }
    } else {
        $message = "Reservation ID not provided.";
    }
}

// Query all reservations for display
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Reservation</title>
    <link rel="stylesheet" href="cancel_reservations.css">
</head>
<body>
    <h1>Cancel Reservation</h1>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="view_reservations.php">View Reservation</a>
        <a href="cancel_reservation.php">Cancel Reservations</a>
    </div>

    <div class="container">
        <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Room Name</th>
                    <th>Room Type</th>
                    <th>Room Price</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Cancel</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['check_in_date']; ?></td>
                        <td><?php echo $row['check_out_date']; ?></td>
                        <td><?php echo $row['room_name']; ?></td>
                        <td><?php echo $row['room_type']; ?></td>
                        <td><?php echo $row['room_price']; ?></td>
                        <td><?php echo $row['adults']; ?></td>
                        <td><?php echo $row['children']; ?></td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                <input type="hidden" name="reservation_id" value="<?php echo $row['id']; ?>">
                                <input type="submit" value="Cancel">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No reservations found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
