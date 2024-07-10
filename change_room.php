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

// Ensure the 'data' directory and 'reservations.json', 'rooms.json' files exist
if (!is_dir('data')) {
    mkdir('data', 0777, true);
}
if (!file_exists('data/reservations.json')) {
    file_put_contents('data/reservations.json', json_encode([]));
}
if (!file_exists('data/rooms.json')) {
    file_put_contents('data/rooms.json', json_encode([]));
}

// Function to get room details by ID
function getRoomById($id) {
    $rooms = json_decode(file_get_contents('data/rooms.json'), true);
    foreach ($rooms as $room) {
        if ($room['id'] == $id) {
            return $room;
        }
    }
    return null;
}

// Process room change
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservationId = $_POST['reservation_id'];
    $newRoomId = $_POST['room_id'];
    
    $room = getRoomById($newRoomId);
    
    if ($room) {
        if ($room['availability'] == 0) {
            $message = "Selected room is not available.";
        } else {
            // Update room availability
            $room['availability'] -= 1;
            $rooms = json_decode(file_get_contents('data/rooms.json'), true);
            foreach ($rooms as &$r) {
                if ($r['id'] == $room['id']) {
                    $r['availability'] = $room['availability'];
                    break;
                }
            }
            file_put_contents('data/rooms.json', json_encode($rooms));

            // Update reservation with new room details
            $reservations = json_decode(file_get_contents('data/reservations.json'), true);
            foreach ($reservations as &$reservation) {
                if ($reservation['id'] == $reservationId) {
                    $reservation['room_id'] = $newRoomId;
                    break;
                }
            }
            file_put_contents('data/reservations.json', json_encode($reservations));
            
            $message = "Room change successful!";
        }
    } else {
        $message = "Room not found!";
    }
}

// Display reservations and available rooms
$reservations = json_decode(file_get_contents('data/reservations.json'), true);
$rooms = json_decode(file_get_contents('data/rooms.json'), true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Room</title>
    <link rel="stylesheet" href="change_room.css">
</head>
<body>
    <h1>OnlyFuns Hotel Reservation</h1>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="view_reservations.php">View Reservation</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
    </div>
    <div class="container">
        <h2>Change Room</h2>
        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="reservation_id">Select Reservation:</label>
            <select name="reservation_id" id="reservation_id" required>
                <?php foreach ($reservations as $reservation): ?>
                    <option value="<?php echo htmlspecialchars($reservation['id']); ?>">
                        Reservation ID: <?php echo htmlspecialchars($reservation['id']); ?> - Current Room: <?php echo htmlspecialchars($reservation['room_id']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <label for="room_id">Select New Room:</label>
            <select name="room_id" id="room_id" required>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo htmlspecialchars($room['id']); ?>"><?php echo htmlspecialchars($room['name']); ?> (<?php echo htmlspecialchars($room['availability']); ?> available)</option>
                <?php endforeach; ?>
            </select><br>
            <button type="submit">Confirm Room Change</button>
        </form>
        <a href="view_reservations.php" class="back-button">Back to Reservations</a>
    </div>
</body>
</html>

