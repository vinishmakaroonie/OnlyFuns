<?php
session_start();

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

// Simulated rooms data array with individual room IDs
$rooms = [
    ['id' => 'room1', 'name' => 'Room 1', 'type' => RoomType::SINGLE, 'price' => 100, 'image_url' => 'images/room1.jpg'],
    ['id' => 'room2', 'name' => 'Room 2', 'type' => RoomType::DOUBLE, 'price' => 150, 'image_url' => 'images/room2.jpg'],
    ['id' => 'room3', 'name' => 'Room 3', 'type' => RoomType::SUITE, 'price' => 300, 'image_url' => 'images/room3.jpg'],
    ['id' => 'room4', 'name' => 'Room 4', 'type' => RoomType::DELUXE, 'price' => 400, 'image_url' => 'images/room4.jpg'],
    ['id' => 'room5', 'name' => 'Room 5', 'type' => RoomType::PRESIDENTIAL, 'price' => 800, 'image_url' => 'images/room5.jpg'],
    ['id' => 'room6', 'name' => 'Room 6', 'type' => RoomType::SINGLE, 'price' => 100, 'image_url' => 'images/room6.jpg'],
    ['id' => 'room7', 'name' => 'Room 7', 'type' => RoomType::DOUBLE, 'price' => 150, 'image_url' => 'images/room7.jpg'],
    ['id' => 'room8', 'name' => 'Room 8', 'type' => RoomType::SUITE, 'price' => 300, 'image_url' => 'images/room8.jpg'],
    ['id' => 'room9', 'name' => 'Room 9', 'type' => RoomType::DELUXE, 'price' => 400, 'image_url' => 'images/room9.jpg'],
    ['id' => 'room10', 'name' => 'Room 10', 'type' => RoomType::PRESIDENTIAL, 'price' => 800, 'image_url' => 'images/room10.jpg'],
    ['id' => 'room11', 'name' => 'Room 11', 'type' => RoomType::SINGLE, 'price' => 100, 'image_url' => 'images/room11.jpg'],
    ['id' => 'room12', 'name' => 'Room 12', 'type' => RoomType::DOUBLE, 'price' => 150, 'image_url' => 'images/room12.jpg'],
    ['id' => 'room13', 'name' => 'Room 13', 'type' => RoomType::SUITE, 'price' => 300, 'image_url' => 'images/room13.jpg'],
    ['id' => 'room14', 'name' => 'Room 14', 'type' => RoomType::DELUXE, 'price' => 400, 'image_url' => 'images/room14.jpg'],
    ['id' => 'room15', 'name' => 'Room 15', 'type' => RoomType::PRESIDENTIAL, 'price' => 800, 'image_url' => 'images/room15.jpg'],
    ['id' => 'room16', 'name' => 'Room 16', 'type' => RoomType::SINGLE, 'price' => 100, 'image_url' => 'images/room16.jpg'],
    ['id' => 'room17', 'name' => 'Room 17', 'type' => RoomType::DOUBLE, 'price' => 150, 'image_url' => 'images/room17.jpg'],
    ['id' => 'room18', 'name' => 'Room 18', 'type' => RoomType::SUITE, 'price' => 300, 'image_url' => 'images/room18.jpg'],
    ['id' => 'room19', 'name' => 'Room 19', 'type' => RoomType::DELUXE, 'price' => 400, 'image_url' => 'images/room19.jpg'],
    ['id' => 'room20', 'name' => 'Room 20', 'type' => RoomType::PRESIDENTIAL, 'price' => 800, 'image_url' => 'images/room20.jpg'],
    ['id' => 'room21', 'name' => 'Room 21', 'type' => RoomType::SINGLE, 'price' => 100, 'image_url' => 'images/room21.jpg'],
    ['id' => 'room22', 'name' => 'Room 22', 'type' => RoomType::DOUBLE, 'price' => 150, 'image_url' => 'images/room22.jpg'],
    ['id' => 'room23', 'name' => 'Room 23', 'type' => RoomType::SUITE, 'price' => 300, 'image_url' => 'images/room23.jpg'],
    ['id' => 'room24', 'name' => 'Room 24', 'type' => RoomType::DELUXE, 'price' => 400, 'image_url' => 'images/room24.jpg'],
    ['id' => 'room25', 'name' => 'Room 25', 'type' => RoomType::PRESIDENTIAL, 'price' => 800, 'image_url' => 'images/room25.jpg'],
    ['id' => 'room26', 'name' => 'Room 26', 'type' => RoomType::SINGLE, 'price' => 100, 'image_url' => 'images/room26.jpg'],
    ['id' => 'room27', 'name' => 'Room 27', 'type' => RoomType::DOUBLE, 'price' => 150, 'image_url' => 'images/room27.jpg'],
    ['id' => 'room28', 'name' => 'Room 28', 'type' => RoomType::SUITE, 'price' => 300, 'image_url' => 'images/room28.jpg'],
    ['id' => 'room29', 'name' => 'Room 29', 'type' => RoomType::DELUXE, 'price' => 400, 'image_url' => 'images/room29.jpg'],
    ['id' => 'room30', 'name' => 'Room 30', 'type' => RoomType::PRESIDENTIAL, 'price' => 800, 'image_url' => 'images/room30.jpg'],
];

// Retrieve reservations from session, initialize to empty array if not set
$reservations = isset($_SESSION['reservations']) ? $_SESSION['reservations'] : [];

// Function to check if a room is available for a given date range
function isRoomAvailable($roomId, $checkInDate, $checkOutDate) {
    global $reservations;
    
    foreach ($reservations as $reservation) {
        // Check if $reservation array has 'room_id' key
        if (isset($reservation['room_id']) && $reservation['room_id'] === $roomId) {
            $reservationCheckIn = strtotime($reservation['check_in_date']);
            $reservationCheckOut = strtotime($reservation['check_out_date']);
            $checkIn = strtotime($checkInDate);
            $checkOut = strtotime($checkOutDate);

            // Check for overlapping dates
            if (($checkIn >= $reservationCheckIn && $checkIn < $reservationCheckOut) ||
                ($checkOut > $reservationCheckIn && $checkOut <= $reservationCheckOut) ||
                ($checkIn <= $reservationCheckIn && $checkOut >= $reservationCheckOut)) {
                return false; // Room is not available
            }
        }
    }

    return true; // Room is available
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Rooms</title>
    <link rel="stylesheet" href="view_rooms.css">
</head>
<body>
    <h1>OnlyFuns Hotel Reservation</h1>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="view_reservations.php">View Reservations</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
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
                <?php
                    $roomId = $room['id'];
                    $roomName = htmlspecialchars($room['name']);
                    $roomType = htmlspecialchars($room['type']);
                    $roomPrice = htmlspecialchars($room['price']);
                    $availability = isRoomAvailable($roomId, date('Y-m-d'), date('Y-m-d', strtotime('+1 day')));
                ?>
                <div class="room">
                    <div class="room-details">
                        <h3><?php echo $roomName; ?></h3>
                        <img src="<?php echo htmlspecialchars($room['image_url']); ?>" alt="<?php echo htmlspecialchars($room['name']); ?>" class="room-image">
                        <p>Type: <?php echo $roomType; ?></p>
                        <p>Price: $<?php echo $roomPrice; ?> per night</p>
                        <?php
                            // Check if room is already reserved
                            $isReserved = false;
                            foreach ($reservations as $reservation) {
                                if (isset($reservation['room_name']) && $reservation['room_name'] === $roomName) {
                                    $isReserved = true;
                                    break;
                                }
                            }
                        ?>
                        <?php if ($availability && !$isReserved): ?>
                            <a href="make_reservation.php?room_id=<?php echo $roomId; ?>&room_name=<?php echo $roomName; ?>&room_type=<?php echo $roomType; ?>&room_price=<?php echo $roomPrice; ?>" class="button">Make Reservation</a>
                        <?php else: ?>
                            <p class="unavailable">Not Available</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
