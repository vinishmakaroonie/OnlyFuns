<?php
// Ensure the 'data' directory and 'rooms.json' file exist
if (!is_dir('data')) {
    mkdir('data', 0777, true);
}
if (!file_exists('data/rooms.json')) {
    file_put_contents('data/rooms.json', json_encode([]));
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $newRoom = [
        'name' => $_POST['room_name'],
        'type' => $_POST['room_type'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price'],
        'description' => $_POST['description']
    ];

    // Read existing rooms data
    $rooms = json_decode(file_get_contents('data/rooms.json'), true);

    // Generate unique ID for the new room
    $newRoom['id'] = uniqid();

    // Add new room to the array
    $rooms[] = $newRoom;

    // Write updated rooms data back to the file
    file_put_contents('data/rooms.json', json_encode($rooms));

    // Redirect to the view rooms page
    header("Location: view_rooms.php");
    exit;
}

// If not submitted or after adding new room, display existing rooms
$rooms = json_decode(file_get_contents('data/rooms.json'), true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>View Rooms</title>
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
        <h2>View Rooms</h2>
        <ul>
            <?php foreach ($rooms as $room): ?>
                <li>
                    <div class="room-info">
                        <h3><?php echo htmlspecialchars($room['name']); ?></h3>
                        <p>Type: <?php echo htmlspecialchars($room['type']); ?></p>
                        <p>Price: $<?php echo htmlspecialchars($room['price']); ?> per night</p>
                        <p>Quantity: <?php echo htmlspecialchars($room['quantity']); ?></p>
                        <p>Description: <?php echo htmlspecialchars($room['description']); ?></p>
                    </div>
                    <div class="room-actions">
                        <a href="view_single_room.php?id=<?php echo htmlspecialchars($room['id']); ?>">View</a>
                        <a href="edit_room.php?id=<?php echo htmlspecialchars($room['id']); ?>">Edit</a>
                        <a href="delete_room.php?id=<?php echo htmlspecialchars($room['id']); ?>">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
