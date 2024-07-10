<?php
include 'db.php';

$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <link rel="stylesheet" href="view_reservations.css">
</head>
<body>
    <h1>View Reservations</h1>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="view_reservation.php">View Reservation </a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
    </div>

    <div class="container">
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
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No reservations found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
