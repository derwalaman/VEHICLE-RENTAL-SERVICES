<?php

    error_reporting(0);
    session_start();

    if (!isset($_SESSION['selleremail'])) {
        $url = "loginSignup.php";
        header("Location: " . $url);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <main>
        <!-- Navigation bar -->
        <nav class="navbar">
            <div class="navbar-brand">
                <img src="../images/logo1.png" alt="Logo">
                Rent-a-Rev
            </div>
            <button class="navbar-toggler" onclick="toggleNavbar()">&#9776;</button>
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="../about.html">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders/index.php">Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_vehicle.php">Add Vehicle</a></li>
                    <li class="nav-item"><a class="nav-link" href="loginSignup.php">Login/Signup</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact us</a></li>
                </ul>
            </div>
        </nav>

        <!-- Hamburger Menu -->
        <div class="hamburger-menu" id="hamburgerMenu">
            <button class="close-btn" onclick="toggleNavbar()">&times;</button>
            <ul class="hamburger-nav">
                <li><a class="nav-link" href="../about.html">About</a></li>
                <li><a class="nav-link" href="add_vehicle.php">Add Vehicle</a></li>
                <li><a class="nav-link" href="orders/index.php">Orders</a></li>
                <li><a class="nav-link" href="loginSignup.php">Login/Signup</a></li>
                <li><a class="nav-link" href="logout.php">Logout</a></li>
                <li><a class="nav-link" href="#contact">Contact us</a></li>
            </ul>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <h2>Add Vehicle</h2>
            <form action="process_form.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="vehicle-name">Name:</label>
                    <input type="text" id="vehicle-name" name="vehicle-name" required>
                </div>

                <div class="form-group">
                    <label for="vehicle-price">Price:</label>
                    <input type="number" id="vehicle-price" name="vehicle-price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="vehicle-con">Phone Number:</label>
                    <input type="number" id="vehicle-con" name="vehicle-con" step="1" required>
                </div>

                <div class="form-group">
                    <label for="vehicle-type">Type:</label>
                    <select name="vehicle-type" id="vehicle-type" required>
                        <option value="car">Car</option>
                        <option value="bike">Bike</option>
                        <option value="scooty">Scooty</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fuel-type">Fuel:</label>
                    <select name="fuel-type" id="fuel-type" required>
                        <option value="electric">Electric</option>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="delivery-type">Delivery:</label>
                    <select name="delivery-type" id="delivery-type" required>
                        <option value="all">All</option>
                        <option value="home">Home Delivery</option>
                        <option value="pickup">Pick Up</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="availability">Availability:</label>
                    <select name="availability" id="availability" required>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vehicle-image">Image:</label>
                    <input type="file" id="vehicle-image" name="vehicle-image" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="latitude">Latitude:</label>
                    <input type="text" id="latitude" name="latitude" readonly>
                </div>

                <div class="form-group">
                    <label for="longitude">Longitude:</label>
                    <input type="text" id="longitude" name="longitude" readonly>
                </div>

                <button type="submit">Add Vehicle</button>
            </form>
        </div>
    </main>

    <script>
    function toggleNavbar() {
        const navbarMenu = document.getElementById('hamburgerMenu');
        navbarMenu.classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, (error) => {
                console.error('Error getting location:', error);
                alert('Unable to retrieve your location.');
            });
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });
    </script>
</body>

</html>
