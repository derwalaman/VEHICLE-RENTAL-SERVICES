<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the request method is GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Retrieve user ID from query parameter
    $userId = $conn->real_escape_string($_GET['userId']);

    // Query to fetch live bookings
    $query = "SELECT * FROM orders WHERE sellerid = '$userId' AND status = 'pending'";

    $result = $conn->query($query);
    $bookings = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    $query = "SELECT * FROM orders WHERE sellerid = '$userId' AND status = 'live'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    // Output data as JSON
    header('Content-Type: application/json');
    echo json_encode($bookings);

    // Close connection
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
