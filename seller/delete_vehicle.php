<?php
// delete_vehicle.php
error_reporting(0);
$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$query = "DELETE FROM rentvehicles WHERE id='$id'";
$result = $conn->query($query);

echo json_encode(['success' => $result]);
$conn->close();
?>
