<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'ydwqrfyj_rentalServices');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user location from the request
$lat = isset($_GET['lat']) ? (float)$_GET['lat'] : 0;
$lon = isset($_GET['lon']) ? (float)$_GET['lon'] : 0;

// Validate user location
if ($lat == 0 || $lon == 0) {
    echo json_encode(['error' => 'Invalid location coordinates.']);
    $conn->close();
    exit();
}

// Calculate the distance between two lat/lon points
function distance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; // Earth radius in km
    $lat_diff = deg2rad($lat2 - $lat1);
    $lon_diff = deg2rad($lon2 - $lon1);
    $a = sin($lat_diff / 2) * sin($lat_diff / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($lon_diff / 2) * sin($lon_diff / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earth_radius * $c;
}

$max_distance = 50; // max distance in km

// Prepare to fetch vehicle data
$sql = "SELECT id, name, image, mob, email, price, sellerid, vehicle_type, fuel_type, delivery_types, availability, latitude, longitude, datetime
        FROM rentvehicles";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Database query failed.']);
    $conn->close();
    exit();
}

// Prepare for batch updates
$update_queries = [];
$vehicles = [];

while ($row = $result->fetch_assoc()) {
    $vehicle_lat = (float)$row['latitude'];
    $vehicle_lon = (float)$row['longitude'];
    $distance = distance($lat, $lon, $vehicle_lat, $vehicle_lon);

    if ($distance <= $max_distance) {
        // Add update query for distance
        $update_queries[] = "UPDATE rentvehicles SET distance = $distance WHERE id = " . $row['id'];

        // Convert binary image data to base64
        if ($row['image']) {
            $row['image'] = 'data:image/jpeg;base64,' . base64_encode($row['image']);
        } else {
            // Set a default image if none is provided
            $row['image'] = 'https://via.placeholder.com/150';
        }

        $row['distance'] = $distance;
        $vehicles[] = $row;
    }
}

// Execute batch updates
foreach ($update_queries as $query) {
    if (!$conn->query($query)) {
        echo json_encode(['error' => 'Failed to update distance in the database.']);
        $conn->close();
        exit();
    }
}

echo json_encode($vehicles);

$conn->close();
?>
