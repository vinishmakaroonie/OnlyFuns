<?php
include 'db.php';

$reservationSaved = false;
$message = '';

function calculateTotalCost($check_in_date, $check_out_date, $room_price, $adults, $children) {
    $checkIn = new DateTime($check_in_date);
    $checkOut = new DateTime($check_out_date);
    $diff = $checkIn->diff($checkOut);
    $numOfDays = $diff->days;
    
    // Base cost calculation
    $baseCost = $room_price * $numOfDays;
    
    // Additional fee calculation
    $feePerHead = 10;
    $additionalFee = ($adults + $children) * $feePerHead;
    
    // Total cost calculation
    $totalCost = $baseCost + $additionalFee;
    
    // Apply discount if applicable
    if ($children > 0) {
        $discountPercentage = 10;
        $discountAmount = $totalCost * ($discountPercentage / 100);
        $totalCost -= $discountAmount;
    }
    return $totalCost;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $room_name = $_POST['room_name'];
    $room_type = $_POST['room_type'];
    $room_price = $_POST['room_price'];
    $adults = $_POST['adults'];
    $children = $_POST['children'];

    // Calculate total cost with any applicable discounts
    $total_cost = calculateTotalCost($check_in_date, $check_out_date, $room_price, $adults, $children);

    $sql = "INSERT INTO reservations (customer_name, check_in_date, check_out_date, room_name, room_type, room_price, adults, children, total_cost)
            VALUES ('$customer_name', '$check_in_date', '$check_out_date', '$room_name', '$room_type', '$room_price', '$adults', '$children', '$total_cost')";

    if ($conn->query($sql) === TRUE) {
        $reservationSaved = true;
        $message = "Reservation made successfully.";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Reservation</title>
    <link rel="stylesheet" href="make_reservation.css">
    <script>
    function calculateTotal() {
        const checkInDate = new Date(document.getElementById('check_in_date').value);
        const checkOutDate = new Date(document.getElementById('check_out_date').value);
        const roomPrice = parseFloat(document.getElementById('room_price').value);

        if (!isNaN(checkInDate) && !isNaN(checkOutDate) && !isNaN(roomPrice)) {
            const diffTime = Math.abs(checkOutDate - checkInDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            let totalBaseCost = roomPrice * diffDays;

            const children = parseInt(document.getElementById('children').value) || 0;
            const adults = parseInt(document.getElementById('adults').value) || 0;

            const feePerHead = 10;
            const totalAdditionalFee = (children + adults) * feePerHead;

            if (children > 0) {
                const discountPercentage = 10;
                const discountAmount = totalBaseCost * (discountPercentage / 100);
                totalBaseCost -= discountAmount;
            }

            const totalCost = totalBaseCost + totalAdditionalFee;

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

        <div class="go-back">
            <a href="index.php" class="button">Go Back</a>
        </div>
    </div>
</body>
</html>
