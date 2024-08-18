<?php
    $pid = $_GET['id'];
    error_reporting(0);
    session_start();

    if (!isset($_SESSION['useremail'])) {
        $url = "../loginSignup.php";
        header("Location: " . $url);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="product-details.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <img src="../images/logo1.png" alt="Logo">
            Rent-a-Rev
        </div>
        <button class="navbar-toggler" onclick="toggleNavbar()">&#9776;</button>
        <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../about.html">About</a></li>
                <li class="nav-item"><a class="nav-link" href="../booking/booking_history.php">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="../loginSignup.php">Login/Signup</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                <li class="nav-item"><a class="nav-link" href="../index.php#contact">Contact us</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hamburger Menu -->
    <div class="hamburger-menu" id="hamburgerMenu">
        <button class="close-btn" onclick="toggleNavbar()">&times;</button>
        <ul class="hamburger-nav">
            <li><a class="nav-link" href="../index.php">Home</a></li>
            <li><a class="nav-link" href="../about.html">About</a></li>
            <li><a class="nav-link" href="../booking/booking_history.php">Booking</a></li>
            <li><a class="nav-link" href="../loginSignup.php">Login/Signup</a></li>
            <li><a class="nav-link" href="../logout.php">Logout</a></li>
            <li><a class="nav-link" href="../index.php#contact">Contact us</a></li>
        </ul>
    </div>

    <main>
        <div class="product-details-container">
            <div class="product-image">
                <img id="product-image" src="" alt="Product Image">
            </div>
            <div class="product-info">
                <h1 id="product-name"></h1>
                <p id="product-price"></p>
                <p><strong>Type:</strong> <span id="product-vehicle-type"></span></p>
                <p><strong>Fuel:</strong> <span id="product-fuel-type"></span></p>
                <p><strong>Delivery:</strong> <span id="product-delivery-types"></span></p>
                <p><strong>Distance:</strong> <span id="product-distance"></span> (far away)</p>
                <p><strong>Availability:</strong> <span id="product-avail"></span></p>
                <p><strong>Provider Contact:</strong> <span id="product-mob"></span></p>
                <p><strong>Provider Email:</strong> <span id="product-email"></span></p>
                <p><strong>Payment Mode:</strong> <span id="product-payment">Cash On Delivery/Pickup</span></p>
            </div>
            <!-- This will be used to display either the embedded map or fallback map -->
            <div id="map-container" style="margin: 20px;">
                <iframe id="map-frame" width="100%" height="200" style="border: 0;" loading="lazy" allowfullscreen
                    src=""></iframe>
            </div>

        </div>

        <div class="rental-form-container">
            <h2>Request to Rent</h2>
            <form id="rental-form" method="post" action="submit_rental_request.php?id=<?php echo $pid; ?>">
                <label for="phone">Your Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="rental-date">Date of Rental:</label>
                <input type="date" id="rental-date" name="rentalDate" required>

                <label for="return-date">Date of Return:</label>
                <input type="date" id="return-date" name="returnDate" required>

                <label for="start-time">Start Time:</label>
                <input type="time" id="start-time" name="startTime" required>

                <label for="end-time">End Time:</label>
                <input type="time" id="end-time" name="endTime" required>
                
                <!-- <input style="display: none;" type="hidden" id="productid" name="productid" value=""> -->
                <!-- <p id="total-amount" style="margin-bottom: 10px;">Total Amount: ₹0</p> -->
                <label for="total-amount">Total Amount:</label>
                <input type="text" id="total-amount" name="totalAmount" readonly>

                <!-- Add a container for delivery options -->
                <div id="delivery-options-container" style="display: none; margin-bottom: 10px;">
                    <label for="delivery-option">Select Delivery Option:</label>
                    <select id="delivery-option" name="deliveryOption"
                        style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                        <option value="home">Home Delivery</option>
                        <option value="pickup">Pickup</option>
                    </select>
                </div>

                <button type="submit">Submit Request</button>
            </form>
        </div>

    </main>
    
    <script src="product-details.js"></script>
</body>

</html>