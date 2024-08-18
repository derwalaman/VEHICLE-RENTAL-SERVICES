<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get product ID from query parameters and sanitize it
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($productId <= 0) {
    echo json_encode(["error" => "Invalid product ID"]);
    $conn->close();
    exit;
}

// Prepare and execute SQL query
$query = "SELECT * FROM rentvehicles WHERE id = $productId";
$result = $conn->query($query);

// Check if query was successful
if (!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    $conn->close();
    exit;
}

// Fetch and return the product data
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Convert image from BLOB to base64-encoded string
    if ($row['image']) {
        $row['image'] = 'data:image/jpeg;base64,' . base64_encode($row['image']);
    }

    echo json_encode($row);
} else {
    echo json_encode(["error" => "No product found"]);
}

// Close connection
$conn->close();
?>
