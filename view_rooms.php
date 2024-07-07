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
    <div class="container">
        <h1>View Rooms</h1>
        <ul>
            <?php foreach ($rooms as $room): ?>
                <li>
                    <?php echo htmlspecialchars($room['name']); ?> - 
                    $<?php echo htmlspecialchars($room['price']); ?> per night - 
                    Quantity: <?php echo htmlspecialchars($room['quantity']); ?>
                    [<a href="view_single_room.php?id=<?php echo htmlspecialchars($room['id']); ?>">View</a>]
                    [<a href="edit_room.php?id=<?php echo htmlspecialchars($room['id']); ?>">Edit</a>]
                    [<a href="delete_room.php?id=<?php echo htmlspecialchars($room['id']); ?>">Delete</a>]
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
