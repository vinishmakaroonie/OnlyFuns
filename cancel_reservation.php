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
    <title>Cancel Reservation</title>
    <link rel="stylesheet" href="cancel_reservations.css">
    <style>
        /* Your CSS styles can also be embedded here for testing */
    </style>
</head>
<body>
    <h1>Cancel Reservation</h1>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="view_reservations.php">View Reservations</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
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
