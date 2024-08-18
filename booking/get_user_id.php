<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['useremail'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Retrieve email from session
$useremail = $_SESSION['useremail'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user ID from email
$sql = "SELECT `s.no.` FROM users WHERE email = '$useremail'";
$result = $conn->query($sql);

$userId = null;
if ($result && $row = $result->fetch_assoc()) {
    $userId = $row['s.no.'];
}

$conn->close();

// Output the user ID as JSON
echo json_encode(['userId' => $userId]);
?>
