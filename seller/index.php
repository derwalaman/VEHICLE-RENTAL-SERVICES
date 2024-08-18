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
    <title>Seller - Rent-a-Rev</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <main>
        <nav class="navbar">
            <div class="navbar-brand">
                <img src="../images/logo1.png" alt="Logo">
                Rent-a-Rev
            </div>
            <button class="navbar-toggler" onclick="toggleNavbar()">&#9776;</button>
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../about.html">About</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="orders/index.php">Orders</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_vehicle.php">Add Vehicle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="loginSignup.php">Login/Signup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">Contact us</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Hamburger Menu -->
        <div class="hamburger-menu" id="hamburgerMenu">
            <button class="close-btn" onclick="toggleNavbar()">&times;</button>
            <ul class="hamburger-nav">
                <li><a class="nav-link" href="../about.html">About</a></li>
                <li><a class="nav-link" href="add_vehicle.php">Add Vehicle</a></li>
                <li><a class="nav-link" href="about.html">About</a></li>
                <li><a class="nav-link" href="orders/index.php">Orders</a></li>
                <li><a class="nav-link" href="loginSignup.php">Login/Signup</a></li>
                <li><a class="nav-link" href="logout.php">Logout</a></li>
                <li><a class="nav-link" href="#contact">Contact us</a></li>
            </ul>
        </div>

        <!-- Content of the page -->
        <div class="container1">
            <div class="shade-box"></div>
            <div class="container-info">
                <h1>My Rental Vehicles</h1>
                <p>Manage your vehicles here!</p>
            </div>
        </div>

        <div class="table-container">
            <table id="vehicle-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Fuel</th>
                        <th>Delivery</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="vehicle-table-body">
                    <!-- Vehicle rows will be inserted here by JavaScript -->
                </tbody>
            </table>
            <p id="no-vehicles-message" style="display:none;">No rental cars available</p>
        </div>

        <!-- Edit Vehicle Modal -->
        <div id="edit-vehicle-modal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Edit Vehicle</h2>
                <form id="edit-vehicle-form">
                    <input type="hidden" id="vehicle-id">
                    <label for="vehicle-name">Name:</label>
                    <input type="text" id="vehicle-name" name="vehicle-name" required>

                    <label for="vehicle-price">Price:</label>
                    <input type="number" id="vehicle-price" name="vehicle-price" step="0.01" required>

                    <label for="vehicle-type">Type:</label>
                    <select name="vehicle-type" id="vehicle-type" required>
                        <option value="car">Car</option>
                        <option value="bike">Bike</option>
                        <option value="scooty">Scooty</option>
                    </select>

                    <label for="fuel-type">Fuel:</label>
                    <select name="fuel-type" id="fuel-type" required>
                        <option value="electric">Electric</option>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                    </select>

                    <label for="delivery-type">Delivery:</label>
                    <select name="delivery-type" id="delivery-type" required>
                        <option value="all">All</option>
                        <option value="home">Home Delivery</option>
                        <option value="pickup">Pick Up</option>
                    </select>

                    <button type="submit">Update Vehicle</button>
                </form>
            </div>
        </div>


    </main>
    <!-- <script src="script.js"></script> -->
    <script>
    function toggleNavbar() {
        const navbarMenu = document.getElementById('hamburgerMenu');
        navbarMenu.classList.toggle('active');
    }

    function showEditPopup(vehicle) {
        document.getElementById('vehicle-id').value = vehicle.id;
        document.getElementById('vehicle-name').value = vehicle.name;
        document.getElementById('vehicle-price').value = vehicle.price;
        document.getElementById('vehicle-type').value = vehicle.vehicle_type;
        document.getElementById('fuel-type').value = vehicle.fuel_type;
        document.getElementById('delivery-type').value = vehicle.delivery_types;

        const modal = document.getElementById('edit-vehicle-modal');
        modal.style.display = 'block';
    }

    function closeEditPopup() {
        const modal = document.getElementById('edit-vehicle-modal');
        modal.style.display = 'none';
    }

    function deleteVehicle(vehicleId) {
        if (confirm('Are you sure you want to delete this vehicle?')) {
            fetch('delete_vehicle.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${vehicleId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Vehicle deleted successfully!');
                        loadVehicles(); // Reload vehicles to reflect changes
                    } else {
                        alert('Error deleting vehicle.');
                    }
                });
        }
    }

    function loadVehicles() {
        fetch('get_seller_vehicles.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('vehicle-table-body');
                tableBody.innerHTML = '';

                if (data.error) {
                    document.getElementById('no-vehicles-message').style.display = 'block';
                    return;
                }

                document.getElementById('no-vehicles-message').style.display = 'none';

                data.forEach(vehicle => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${vehicle.name}</td>
                        <td>₹${vehicle.price}</td>
                        <td>${vehicle.vehicle_type}</td>
                        <td>${vehicle.fuel_type}</td>
                        <td>${vehicle.delivery_types}</td>
                        <td>
                            <button onclick='showEditPopup(${JSON.stringify(vehicle)})'>Edit</button>
                            <button onclick='deleteVehicle(${vehicle.id})'>Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    document.getElementById('edit-vehicle-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const id = document.getElementById('vehicle-id').value;
        const name = document.getElementById('vehicle-name').value;
        const price = document.getElementById('vehicle-price').value;
        const type = document.getElementById('vehicle-type').value;
        const fuel = document.getElementById('fuel-type').value;
        const delivery = document.getElementById('delivery-type').value;

        fetch('update_vehicle.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&name=${name}&price=${price}&vehicle_type=${type}&fuel_type=${fuel}&delivery_types=${delivery}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeEditPopup();
                    alert('Vehicle updated successfully!');
                    loadVehicles(); // Reload vehicles to reflect changes
                } else {
                    alert('Error updating vehicle.');
                }
            });
    });

    document.querySelector('.close-modal').addEventListener('click', closeEditPopup);

    // Load vehicles on page load
    window.onload = loadVehicles;
    </script>
</body>

</html>