<?php
// Enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $phone = $conn->real_escape_string($_POST['phone']);
    $rentalDate = $conn->real_escape_string($_POST['rentalDate']);
    $returnDate = $conn->real_escape_string($_POST['returnDate']);
    $startTime = $conn->real_escape_string($_POST['startTime']);
    $endTime = $conn->real_escape_string($_POST['endTime']);
    $productId = $_GET['id']; // Product ID from URL
    $deliveryOption = $conn->real_escape_string($_POST['deliveryOption']);

    // Start the session and fetch user ID
    session_start();
    if (!isset($_SESSION['useremail'])) {
        echo "<script>alert('User not logged in.'); window.location.href = '../loginSignup.php';</script>";
        exit();
    }
    $useremail = $conn->real_escape_string($_SESSION['useremail']);
    
    // Fetch user ID from email
    $userIdQuery = "SELECT `s.no.` FROM users WHERE email = '$useremail'";
    $userResult = $conn->query($userIdQuery);

    if ($userResult && $userRow = $userResult->fetch_assoc()) {
        $userId = $userRow['s.no.'];
    } else {
        echo "<script>alert('User not found.'); window.location.href = '../index.php';</script>";
        exit();
    }

    // Fetch seller ID and product name from product
    $productQuery = "SELECT sellerid, name FROM rentvehicles WHERE id = '$productId'";
    $productResult = $conn->query($productQuery);

    if ($productResult && $productRow = $productResult->fetch_assoc()) {
        $sellerId = $productRow['sellerid'];
        $productName = $productRow['name'];
    } else {
        echo "<script>alert('Product not found.'); window.location.href = '../index.php';</script>";
        exit();
    }

    // Fetch the total amount from form
    $totalAmount = isset($_POST['totalAmount']) ? $conn->real_escape_string($_POST['totalAmount']) : '₹0.00';

    // Check if total amount is zero
    if ($totalAmount == '₹0.00') {
        echo "<script>alert('Wrong request, please review your request.'); window.location.href = 'index.php?id=$productId';</script>";
        exit();
    }

    // Insert data into orders table
    $query = "INSERT INTO orders (phone, userid, sellerid, name, rental_date, return_date, start_time, end_time, product_id, delivery_option, price, status) 
              VALUES ('$phone', '$userId', '$sellerId', '$productName', '$rentalDate', '$returnDate', '$startTime', '$endTime', '$productId', '$deliveryOption', '$totalAmount', 'pending')";

    if ($conn->query($query) === TRUE) {
        // Update product availability
        $usql = "UPDATE rentvehicles SET `availability` = 'no' WHERE id = '$productId'";
        $ures = $conn->query($usql);

        if ($ures) {
            echo "<script>alert('Rental request submitted successfully!'); window.location.href = '../index.php';</script>";
        } else {
            echo "<script>alert('Error updating product availability: " . $conn->error . "'); window.location.href = '../index.php';</script>";
        }
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href = '../index.php';</script>";
    }

    // Close the connection
    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = 'index.php?id=$productId';</script>";
}
?>
