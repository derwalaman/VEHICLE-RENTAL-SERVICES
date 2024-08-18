<?php
// update_vehicle.php
error_reporting(0);
$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$status = $_POST['status'];

$query = "UPDATE orders SET status='$status' WHERE id='$id'";
$result = $conn->query($query);

if ($result) {
    if ($status == "completed" || $status == "rejected") {
        $query = "SELECT product_id FROM orders WHERE id='$id'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_id = $row['product_id'];

            $query = "UPDATE rentvehicles SET availability='yes' WHERE id='$product_id'";
            $conn->query($query);
        }
    }
}

echo json_encode(['success' => $result]);
$conn->close();
?>
