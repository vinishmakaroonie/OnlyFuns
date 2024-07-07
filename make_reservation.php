<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Reservation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $customer_name = $_POST["customer_name"];
        $check_in_date = $_POST["check_in_date"];
        $check_out_date = $_POST["check_out_date"];
        $room_type = $_POST["room_type"];
        $adults = $_POST["adults"];
        $children = $_POST["children"];

        // Example: Generate Transaction ID based on your requirements
        $transaction_id = generateTransactionID($customer_name, $check_in_date, $room_type);

        // Example: Validate input (you may implement more complex validation)
        $is_valid = validateReservation($check_in_date, $check_out_date);

        // Example: Save reservation to database or process further
        if ($is_valid) {
            // Here you would typically save data to your database
            // For demonstration, let's output the reservation details
            echo "<h1>Reservation Successful</h1>";
            echo "<p>Transaction ID: $transaction_id</p>";
            echo "<p>Customer Name: $customer_name</p>";
            echo "<p>Check-in Date: $check_in_date</p>";
            echo "<p>Check-out Date: $check_out_date</p>";
            echo "<p>Room Type: $room_type</p>";
            echo "<p>Adults: $adults</p>";
            echo "<p>Children: $children</p>";
        } else {
            echo "<h1>Reservation Failed</h1>";
            echo "<p>Please check your reservation details and try again.</p>";
        }
    }

    // Function to generate transaction ID (example)
    function generateTransactionID($customer_name, $check_in_date, $room_type) {
        // Example logic to generate transaction ID
        $customer_initials = strtoupper(substr($customer_name, 0, 2));
        $month = date('M', strtotime($check_in_date));
        $day = date('d', strtotime($check_in_date));
        $year = date('Y', strtotime($check_in_date));
        $room_code = strtoupper(substr($room_type, 0, 3));
        $reservation_count = 1; // Example: Replace with actual reservation count logic
        $transaction_id = "{$customer_initials}{$month}{$day}-{$room_code}{$reservation_count}";
        return $transaction_id;
    }

    // Function to validate reservation (example)
    function validateReservation($check_in_date, $check_out_date) {
        // Example validation logic
        $check_in = strtotime($check_in_date);
        $check_out = strtotime($check_out_date);
        $minimum_days = 2 * 24 * 3600; // 2 days in seconds

        if ($check_out - $check_in >= $minimum_days) {
            return true;
        } else {
            return false;
        }
    }
    ?>
 <a href="index.php">Go Back</a>