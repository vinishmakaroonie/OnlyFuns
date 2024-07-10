<?php
session_start();

// Retrieve reservations from session
$reservations = isset($_SESSION['reservations']) ? $_SESSION['reservations'] : [];

// Function to calculate total cost based on room price, adults, and children
function calculateTotalCost($roomPrice, $checkInDate, $checkOutDate, $adults, $children) {
    // Calculate number of days of stay
    $days = (strtotime($checkOutDate) - strtotime($checkInDate)) / (60 * 60 * 24);

    // Calculate base total cost
    $baseTotal = $roomPrice * $days;

    // Calculate additional fee per adult and child
    $additionalFeePerPerson = 10; // $10 per head

    // Calculate total cost with additional fees
    $total = $baseTotal + ($adults * $additionalFeePerPerson) + ($children * $additionalFeePerPerson);

    return $total;
}

// Check if transaction_id is provided in URL
if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];

    // Find the reservation with the given transaction_id
    $reservation = array_filter($reservations, function ($res) use ($transaction_id) {
        return $res['transaction_id'] == $transaction_id;
    });

    // If reservation found, retrieve details
    if (!empty($reservation)) {
        $reservation = reset($reservation); // Get the first element (should be only one)

        // Handle form submission to update reservation
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Update reservation details
            $reservation['check_in_date'] = htmlspecialchars($_POST['check_in_date']);
            $reservation['check_out_date'] = htmlspecialchars($_POST['check_out_date']);
            $reservation['adults'] = (int)$_POST['adults'];
            $reservation['children'] = (int)$_POST['children'];

            // Calculate updated total cost
            $roomPrice = $reservation['room_price'];
            $checkInDate = $reservation['check_in_date'];
            $checkOutDate = $reservation['check_out_date'];
            $adults = $reservation['adults'];
            $children = $reservation['children'];
            $total = calculateTotalCost($roomPrice, $checkInDate, $checkOutDate, $adults, $children);

            // Update the reservation with new total and other details
            $reservation['total'] = $total;

            // Update the reservation in the session
            foreach ($reservations as &$res) {
                if ($res['transaction_id'] == $transaction_id) {
                    $res = $reservation;
                    break;
                }
            }
            $_SESSION['reservations'] = $reservations; // Save updated reservations to session

            // Redirect back to view reservations page after update
            header('Location: view_reservations.php');
            exit;
        }
    } else {
        // If reservation not found, handle error (redirect or display message)
        header('Location: view_reservations.php'); // Redirect to view reservations page
        exit;
    }
} else {
    // If transaction_id not provided, handle error (redirect or display message)
    header('Location: view_reservations.php'); // Redirect to view reservations page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function calculateTotal() {
            const checkInDate = document.getElementById('check_in_date').value;
            const checkOutDate = document.getElementById('check_out_date').value;
            const roomPrice = parseFloat(document.getElementById('room_price').value);
            const adults = parseInt(document.getElementById('adults').value);
            const children = parseInt(document.getElementById('children').value);

            if (checkInDate && checkOutDate && !isNaN(roomPrice)) {
                const checkIn = new Date(checkInDate);
                const checkOut = new Date(checkOutDate);
                const diffTime = Math.abs(checkOut - checkIn);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                // Calculate additional fee per adult and child
                const additionalFeePerPerson = 10; // $10 per head
                const totalAdultFee = adults * additionalFeePerPerson;
                const totalChildFee = children * additionalFeePerPerson;

                let totalCost = roomPrice * diffDays + totalAdultFee + totalChildFee;

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
            document.getElementById('adults').addEventListener('change', calculateTotal);
            document.getElementById('children').addEventListener('change', calculateTotal);
        });
    </script>
</head>
<body>
    <h1>Edit Reservation</h1>
    <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="view_reservations.php">View Reservations</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
    </div>
    <div class="container">
        <h2>Edit Reservation Details</h2>
        <form action="" method="post">
            <input type="hidden" name="transaction_id" value="<?php echo htmlspecialchars($reservation['transaction_id']); ?>">
            <label for="check_in_date">Check-in Date:</label>
            <input type="date" id="check_in_date" name="check_in_date" value="<?php echo htmlspecialchars($reservation['check_in_date']); ?>" required>
            <br><br>
            <label for="check_out_date">Check-out Date:</label>
            <input type="date" id="check_out_date" name="check_out_date" value="<?php echo htmlspecialchars($reservation['check_out_date']); ?>" required>
            <br><br>
            <label for="adults">Adults:</label>
            <input type="number" id="adults" name="adults" value="<?php echo htmlspecialchars($reservation['adults']); ?>" required>
            <br><br>
            <label for="children">Children:</label>
            <input type="number" id="children" name="children" value="<?php echo htmlspecialchars($reservation['children']); ?>" required>
            <br><br>
            <button type="submit" class="button">Update Reservation</button>
        </form>
        <div id="total"></div>
    </div>
</body>
</html>
