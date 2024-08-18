<?php

error_reporting(0);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session and fetch user ID
session_start();
if (!isset($_SESSION['selleremail'])) {
    echo json_encode(['error' => 'Seller not logged in']);
    exit();
}
$selleremail = $conn->real_escape_string($_SESSION['selleremail']);

// Fetch user ID from email
$userIdQuery = "SELECT `s.no.` FROM sellers WHERE email = '$selleremail'";
$userResult = $conn->query($userIdQuery);

if ($userResult && $userRow = $userResult->fetch_assoc()) {
    $sellerId = $userRow['s.no.'];
} else {
    echo json_encode(['error' => 'Seller not found']);
    exit();
}

// Fetch vehicles listed by the seller
$query = "SELECT id, name, price, vehicle_type, fuel_type, delivery_types FROM rentvehicles WHERE sellerid = '$sellerId'";
$result = $conn->query($query);

$vehicles = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {

        $vehicles[] = $row;
    }
}

// Return vehicles as JSON
echo json_encode($vehicles);

// Close the connection
$conn->close();
?>
