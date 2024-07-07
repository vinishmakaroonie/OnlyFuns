<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>OnlyFuns Hotel Reservation</title>
    <style>
        /* Resetting default margins and paddings */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Centering main content and providing a container */
        .container {
            width: 60%;
            margin: auto;
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        /* Styling for headings */
        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Styling for navigation links */
        .navigation {
            text-align: center;
            margin-top: 30px;
        }

        .navigation a {
            display: inline-block;
            margin: 10px;
            padding: 12px 24px;
            text-decoration: none;
            color: #333;
            background-color: #f0f0f0;
            border-radius: 30px;
            transition: background-color 0.3s, color 0.3s;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navigation a:hover {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to OnlyFuns Hotel Reservation</h1>
        <div class="navigation">
        <a href="index.php">Home</a>
        <a href="view_rooms.php">View Rooms</a>
        <a href="make_reservation.php">Make Reservation</a>
        <a href="view_reservations.php">View Reservation</a>
        <a href="cancel_reservation.php">Cancel Reservation</a>
        <a href="change_room.php">Change Room</a>
        </div>
    </div>
</body>
</html>
