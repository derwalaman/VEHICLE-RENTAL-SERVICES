<?php
// update_vehicle.php
error_reporting(0);
$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$vehicle_type = $_POST['vehicle_type'];
$fuel_type = $_POST['fuel_type'];
$delivery_types = $_POST['delivery_types'];

$query = "UPDATE rentvehicles SET name='$name', price='$price', vehicle_type='$vehicle_type', fuel_type='$fuel_type', delivery_types='$delivery_types' WHERE id='$id'";
$result = $conn->query($query);

echo json_encode(['success' => $result]);
$conn->close();
?>
