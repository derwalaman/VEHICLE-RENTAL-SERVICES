<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Database connection
    $database = "ydwqrfyj_rentalServices";
    $username = "root";
    $server = "localhost";
    $pass = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        header('Location: add_vehicle.php?status=error&message=' . urlencode('Connection failed: ' . $conn->connect_error));
        exit();
    }

    // Retrieve form data
    $vehicle_name = $conn->real_escape_string($_POST['vehicle-name']);
    $vehicle_price = $conn->real_escape_string($_POST['vehicle-price']);
    $vehicle_con = $conn->real_escape_string($_POST['vehicle-con']);
    $vehicle_type = $conn->real_escape_string($_POST['vehicle-type']);
    $fuel_type = $conn->real_escape_string($_POST['fuel-type']);
    $delivery_type = $conn->real_escape_string($_POST['delivery-type']);
    $availability = $conn->real_escape_string($_POST['availability']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);

    // Handle file upload
    $imageContent = null;
    if (isset($_FILES['vehicle-image']) && $_FILES['vehicle-image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['vehicle-image']['tmp_name'];
        $imageContent = $conn->real_escape_string(file_get_contents($image));
    }

    session_start();
    if (!isset($_SESSION['selleremail'])) {
        header('Location: add_vehicle.php?status=error&message=' . urlencode('Seller not logged in'));
        exit();
    }
    $selleremail = $conn->real_escape_string($_SESSION['selleremail']);

    // Fetch user ID from email
    $userIdQuery = "SELECT `s.no.` FROM sellers WHERE email = '$selleremail'";
    $userResult = $conn->query($userIdQuery);

    if ($userResult && $userRow = $userResult->fetch_assoc()) {
        $sellerId = $userRow['s.no.'];
    } else {
        header('Location: add_vehicle.php?status=error&message=' . urlencode('Seller not found'));
        exit();
    }

    // Create SQL query
    $sql = "INSERT INTO rentvehicles (name, price, mob, email, vehicle_type, fuel_type, delivery_types, availability, latitude, longitude, image, distance, sellerid) 
            VALUES ('$vehicle_name', '$vehicle_price', '$vehicle_con', '$selleremail','$vehicle_type', '$fuel_type', '$delivery_type', '$availability', '$latitude', '$longitude', '$imageContent', '0', '$sellerId')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect to index.php on success
        header('Location: index.php');
        exit();
    } else {
        header('Location: add_vehicle.php?status=error&message=' . urlencode('Error: ' . $conn->error));
        exit();
    }

    // Close connection
    $conn->close();
} else {
    header('Location: add_vehicle.php?status=error&message=' . urlencode('Invalid request method.'));
    exit();
}
?>
