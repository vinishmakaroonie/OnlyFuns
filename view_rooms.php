<?php

// Define a RoomType class to encapsulate room type information
class RoomType {
    public const SINGLE = 'Single';
    public const DOUBLE = 'Double';
    public const SUITE = 'Suite';
    public const DELUXE = 'Deluxe';
    public const PRESIDENTIAL = 'Presidential';

    // Static method to get description based on room type
    public static function getDescription($type) {
        switch ($type) {
            case self::SINGLE:
                return 'A cozy room perfect for solo travelers.';
            case self::DOUBLE:
                return 'A comfortable room with space for two guests.';
            case self::SUITE:
                return 'An elegant suite offering luxury amenities.';
            case self::DELUXE:
                return 'A luxurious room with premium facilities.';
            case self::PRESIDENTIAL:
                return 'An extravagant presidential suite with top-notch services.';
            default:
                return 'Description not available';
        }
    }
}

// Simulated rooms data array
$rooms = [
    ['id' => 'room1', 'name' => 'Room 1', 'type' => RoomType::SINGLE, 'price' => 100],
    ['id' => 'room2', 'name' => 'Room 2', 'type' => RoomType::DOUBLE, 'price' => 150],
    ['id' => 'room3', 'name' => 'Room 3', 'type' => RoomType::SUITE, 'price' => 300],
    ['id' => 'room4', 'name' => 'Room 4', 'type' => RoomType::DELUXE, 'price' => 400],
    ['id' => 'room5', 'name' => 'Room 5', 'type' => RoomType::PRESIDENTIAL, 'price' => 800],
    ['id' => 'room6', 'name' => 'Room 6', 'type' => RoomType::SINGLE, 'price' => 100],
    ['id' => 'room7', 'name' => 'Room 7', 'type' => RoomType::DOUBLE, 'price' => 150],
    ['id' => 'room8', 'name' => 'Room 8', 'type' => RoomType::SUITE, 'price' => 300],
    ['id' => 'room9', 'name' => 'Room 9', 'type' => RoomType::DELUXE, 'price' => 400],
    ['id' => 'room10', 'name' => 'Room 10', 'type' => RoomType::PRESIDENTIAL, 'price' => 800],
    ['id' => 'room11', 'name' => 'Room 11', 'type' => RoomType::SINGLE, 'price' => 100],
    ['id' => 'room12', 'name' => 'Room 12', 'type' => RoomType::DOUBLE, 'price' => 150],
    ['id' => 'room13', 'name' => 'Room 13', 'type' => RoomType::SUITE, 'price' => 300],
    ['id' => 'room14', 'name' => 'Room 14', 'type' => RoomType::DELUXE, 'price' => 400],
    ['id' => 'room15', 'name' => 'Room 15', 'type' => RoomType::PRESIDENTIAL, 'price' => 800],
    ['id' => 'room16', 'name' => 'Room 16', 'type' => RoomType::SINGLE, 'price' => 100],
    ['id' => 'room17', 'name' => 'Room 17', 'type' => RoomType::DOUBLE, 'price' => 150],
    ['id' => 'room18', 'name' => 'Room 18', 'type' => RoomType::SUITE, 'price' => 300],
    ['id' => 'room19', 'name' => 'Room 19', 'type' => RoomType::DELUXE, 'price' => 400],
    ['id' => 'room20', 'name' => 'Room 20', 'type' => RoomType::PRESIDENTIAL, 'price' => 800],
    ['id' => 'room21', 'name' => 'Room 21', 'type' => RoomType::SINGLE, 'price' => 100],
    ['id' => 'room22', 'name' => 'Room 22', 'type' => RoomType::DOUBLE, 'price' => 150],
    ['id' => 'room23', 'name' => 'Room 23', 'type' => RoomType::SUITE, 'price' => 300],
    ['id' => 'room24', 'name' => 'Room 24', 'type' => RoomType::DELUXE, 'price' => 400],
    ['id' => 'room25', 'name' => 'Room 25', 'type' => RoomType::PRESIDENTIAL, 'price' => 800],
    ['id' => 'room26', 'name' => 'Room 26', 'type' => RoomType::SINGLE, 'price' => 100],
    ['id' => 'room27', 'name' => 'Room 27', 'type' => RoomType::DOUBLE, 'price' => 150],
    ['id' => 'room28', 'name' => 'Room 28', 'type' => RoomType::SUITE, 'price' => 300],
    ['id' => 'room29', 'name' => 'Room 29', 'type' => RoomType::DELUXE, 'price' => 400],
    ['id' => 'room30', 'name' => 'Room 30', 'type' => RoomType::PRESIDENTIAL, 'price' => 800],
];

?>

<!DOCTYPE html>
<html lang="en">
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
        <a href="view_reservations.php">View Reservations</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
    </div>
    <div class="room-descriptions">
        <h2>Room Types and Descriptions</h2>
        <ul>
            <li><strong><?php echo RoomType::SINGLE; ?>:</strong> <?php echo RoomType::getDescription(RoomType::SINGLE); ?></li>
            <li><strong><?php echo RoomType::DOUBLE; ?>:</strong> <?php echo RoomType::getDescription(RoomType::DOUBLE); ?></li>
            <li><strong><?php echo RoomType::SUITE; ?>:</strong> <?php echo RoomType::getDescription(RoomType::SUITE); ?></li>
            <li><strong><?php echo RoomType::DELUXE; ?>:</strong> <?php echo RoomType::getDescription(RoomType::DELUXE); ?></li>
            <li><strong><?php echo RoomType::PRESIDENTIAL; ?>:</strong> <?php echo RoomType::getDescription(RoomType::PRESIDENTIAL); ?></li>
        </ul>
    </div>
    <div class="container">
        <h2>Available Rooms</h2>
        <div class="rooms-list">
            <?php foreach ($rooms as $room): ?>
                <div class="room">
                    <div class="room-details">
                        <h3><?php echo htmlspecialchars($room['name']); ?></h3>
                        <p>Type: <?php echo htmlspecialchars($room['type']); ?></p>
                        <p>Price: $<?php echo htmlspecialchars($room['price']); ?> per night</p>
                        <a href="make_reservation.php?room_id=<?php echo htmlspecialchars($room['id']); ?>&room_name=<?php echo htmlspecialchars($room['name']); ?>&room_type=<?php echo htmlspecialchars($room['type']); ?>&room_price=<?php echo htmlspecialchars($room['price']); ?>" class="button">Make Reservation</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
