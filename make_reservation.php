<?php
session_start();

// Function to generate transaction ID
function generateTransactionID($customerName, $checkInDate, $roomType) {
    $shortCustomerName = strtoupper(substr($customerName, 0, 2));
    $month = strtoupper(date('M', strtotime($checkInDate)));
    $day = date('d', strtotime($checkInDate));
    $year = date('Y', strtotime($checkInDate));
    $roomTypeCode = strtoupper(substr($roomType, 0, 3));

    // Example format: THFEB100222-FIC00001
    return "{$shortCustomerName}{$month}{$day}{$year}-{$roomTypeCode}00001"; // Replace with actual logic
}

// Initialize reservation saved status
$reservationSaved = false;
$message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $customerName = htmlspecialchars($_POST['customer_name']);
    $checkInDate = htmlspecialchars($_POST['check_in_date']);
    $checkOutDate = htmlspecialchars($_POST['check_out_date']);
    $roomName = htmlspecialchars($_POST['room_name']);
    $roomType = htmlspecialchars($_POST['room_type']);
    $roomPrice = (float)htmlspecialchars($_POST['room_price']);
    $adults = (int)$_POST['adults'];
    $children = (int)$_POST['children'];

    // Fee per head
    $feePerHead = 10;

    // Generate transaction ID
    $transactionID = generateTransactionID($customerName, $checkInDate, $roomType);

    // Calculate total cost based on room price and duration
    $totalBaseCost = $roomPrice * (strtotime($checkOutDate) - strtotime($checkInDate)) / (60 * 60 * 24);

    // Calculate additional fee for adults and children
    $totalAdditionalFee = ($adults + $children) * $feePerHead;

    // Apply discount for children
    if ($children > 0) {
        $discountPercentage = 10; // Example discount percentage
        $discountAmount = $totalBaseCost * ($discountPercentage / 100);
        $totalBaseCost -= $discountAmount;
    }

    // Total cost including additional fee
    $total = $totalBaseCost + $totalAdditionalFee;

    // Save reservation to session
    $newReservation = [
        'customer_name' => $customerName,
        'check_in_date' => $checkInDate,
        'check_out_date' => $checkOutDate,
        'room_name' => $roomName,
        'room_type' => $roomType,
        'room_price' => $roomPrice,
        'adults' => $adults,
        'children' => $children,
        'total' => $total,
        'transaction_id' => $transactionID // Ensure transaction ID is stored
    ];
    
    if (!isset($_SESSION['reservations'])) {
        $_SESSION['reservations'] = [];
    }
    $_SESSION['reservations'][] = $newReservation;

    $reservationSaved = true;
    $message = "Reservation confirmed! Transaction ID: $transactionID";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Reservation</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function calculateTotal() {
        const checkInDate = document.getElementById('check_in_date').value;
        const checkOutDate = document.getElementById('check_out_date').value;
        const roomPrice = parseFloat(document.getElementById('room_price').value);

        if (checkInDate && checkOutDate && !isNaN(roomPrice)) {
            const checkIn = new Date(checkInDate);
            const checkOut = new Date(checkOutDate);
            const diffTime = Math.abs(checkOut - checkIn);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            let totalBaseCost = roomPrice * diffDays;

            // Fetch number of children and adults
            const children = parseInt(document.getElementById('children').value);
            const adults = parseInt(document.getElementById('adults').value);

            // Calculate total additional fee
            const feePerHead = 10;
            const totalAdditionalFee = (children + adults) * feePerHead;

            // Apply discount for children
            if (children > 0) {
                const discountPercentage = 10; // Example discount percentage
                const discountAmount = totalBaseCost * (discountPercentage / 100);
                totalBaseCost -= discountAmount;
            }

            // Total cost including additional fee
            const totalCost = totalBaseCost + totalAdditionalFee;

            // Update the displayed total with formatted currency
            const formattedTotal = totalCost.toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD'
            });

            document.getElementById('total').innerText = `Total: ${formattedTotal}`;
        } else {
            document.getElementById('total').innerText = '';
        }
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        calculateTotal();
        document.getElementById('check_in_date').addEventListener('change', calculateTotal);
        document.getElementById('check_out_date').addEventListener('change', calculateTotal);
        document.getElementById('children').addEventListener('change', calculateTotal);
        document.getElementById('adults').addEventListener('change', calculateTotal);
    });
</script>
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

    <div class="container">
        <div class="reservation-form">
            <form method="POST">
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" required>

                <label for="check_in_date">Check-in Date:</label>
                <input type="date" id="check_in_date" name="check_in_date" required>

                <label for="check_out_date">Check-out Date:</label>
                <input type="date" id="check_out_date" name="check_out_date" required>

                <label for="room_name">Room Number:</label>
                <input type="text" id="room_name" name="room_name" value="<?php echo htmlspecialchars($_GET['room_name'] ?? ''); ?>" readonly>

                <label for="room_type">Room Type:</label>
                <input type="text" id="room_type" name="room_type" value="<?php echo htmlspecialchars($_GET['room_type'] ?? ''); ?>" readonly>

                <label for="room_price">Room Price:</label>
                <input type="text" id="room_price" name="room_price" value="<?php echo htmlspecialchars($_GET['room_price'] ?? ''); ?>" readonly>

                <label for="adults">Number of Adults:</label>
                <input type="number" id="adults" name="adults" required>

                <label for="children">Number of Children:</label>
                <input type="number" id="children" name="children" required>

                <div id="total"></div>

                <input type="submit" value="Confirm Reservation">
            </form>
        </div>

        <?php if ($reservationSaved): ?>
            <div class="reservation-result">
                <h2>Reservation Status</h2>
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>
    </div>

    <a href="index.php">Go Back</a>
</body>
</html>
