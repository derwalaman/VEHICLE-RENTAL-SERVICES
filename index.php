<?php

    error_reporting(0);
    session_start();

    // checking if user is already logged in or not , if not logged in send it to the login page
    if (!isset($_SESSION['useremail'])) {
        $url = "loginSignup.php";
        header("Location: " . $url);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent-a-Rev</title>
    <!-- Link css file -->
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <main>
        <!-- Navbar -->
        <nav class="navbar">
            <div class="navbar-brand">
                <img src="images/logo1.png" alt="Logo">
                Rent-a-Rev
            </div>
            <!-- Hamburger Symbol Conversion using Js -->
            <button class="navbar-toggler" onclick="toggleNavbar()">&#9776;</button>
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#aabout">About</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="booking/booking_history.php">Booking</a></li>
                    <?php
                    if(!isset($_SESSION['useremail'])){
                        echo '<li class="nav-item">
                        <a class="nav-link" href="loginSignup.php">Login/Signup</a>
                    </li>';
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact us</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Hamburger Menu -->
        <div class="hamburger-menu" id="hamburgerMenu">
            <button class="close-btn" onclick="toggleNavbar()">&times;</button>
            <ul class="hamburger-nav">
                <li><a class="nav-link" href="#aabout">About</a></li>
                <li><a class="nav-link" href="booking/booking_history.php">Booking</a></li>
                <li><a class="nav-link" href="loginSignup.php">Login/Signup</a></li>
                <li><a class="nav-link" href="logout.php">Logout</a></li>
                <li><a class="nav-link" href="#contact">Contact us</a></li>
            </ul>
        </div>

        <!-- Content of the page -->
        <div class="container1">
            <div class="shade-box"></div>
            <div class="container-info">
                <h1>Self Drive Car Rentals</h1>
                <p>Book your drive now!</p>
            </div>
        </div>
        <div class="container3">
            <div class="info3">
                <h3>Rental Cars near you</h3>
            </div>
            <div class="filter-button">
                <button class="filter">Filter</button>
            </div>
        </div>
        <div class="filter-container">
            <h2>Filter Products</h2>
            <div class="foptions">
                <!-- Filter options -->
                <div class="finfo">
                    <label for="price-range">Price Range (per hour):</label>
                    <select id="price-range" onchange="filterProducts()">
                        <option value="all">All</option>
                        <option value="100-250">₹100 - ₹250</option>
                        <option value="250-500">₹250 - ₹500</option>
                        <option value="500-1000">₹500 - ₹1000</option>
                        <option value="1000-2000">₹1000-₹2000</option>
                        <option value="2000">₹2000+</option>
                    </select>
                </div>
                <div class="finfo">
                    <label for="ctype">Vehicle Type:</label>
                    <select id="ctype" onchange="filterProducts()">
                        <option value="all">All</option>
                        <option value="car">Car</option>
                        <option value="bike">Bike</option>
                        <option value="scooty">Scooty</option>
                    </select>
                </div>
                <div class="finfo">
                    <label for="ftype">Fuel Type:</label>
                    <select id="ftype" onchange="filterProducts()">
                        <option value="all">All</option>
                        <option value="electric">Electric</option>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                    </select>
                </div>
                <div class="finfo">
                    <label for="dtype">Delivery Type:</label>
                    <select id="dtype" onchange="filterProducts()">
                        <option value="all">All</option>
                        <option value="home">Home Delivery</option>
                        <option value="pickup">Pick Up</option>
                    </select>
                </div>
                <div class="finfo">
                    <label for="availability">Availability:</label>
                    <select id="availability" onchange="filterProducts()">
                        <option value="all">All</option>
                        <option value="yes">Only Available</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="product-container" id="product-container">
            <!-- Product cards will be inserted here by JavaScript Dynamically -->
            <!-- If no rental cars are available nearby , it will show no rental cars -->
        </div>

        <!-- About Section -->
        <div id="aabout" class="about-section">
            <div class="about-content">
                <div class="about-text">
                    <h2>About Rent-a-Rev</h2>
                    <p>Rent-a-Rev is your go-to platform for self-drive car rentals. We offer a wide range of vehicles
                        across various cities to meet your travel needs. Our mission is to provide hassle-free,
                        convenient, and affordable car rental services. Whether you need a car for a day, a week, or
                        longer, Rent-a-Rev has you covered. Explore our verified cars and trusted hosts to find the
                        perfect ride for your next journey.</p>
                </div>
                <div class="about-image">
                    <img src="images/wp8836813.jpg" alt="About Rent-a-Rev" style="width: 100%; border-radius: 8px;">
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div id="contact" class="contact-form" onsubmit="sendWhatsAppMessage(event)">
            <h2>Contact Us</h2>
            <form action="contact.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; 2024 Rent-a-Rev. All Rights Reserved.</p>
            <p>Contact us: info@rentarev.com</p>
        </footer>
    </main>
    <script src="script.js"></script>
    <script>
    // function for hamburger symbol 
    function toggleNavbar() {
        const navbarMenu = document.getElementById('hamburgerMenu');
        navbarMenu.classList.toggle('active');
    }

    // function for sending msg to whatsapp as soon as contact form submited
    function sendWhatsAppMessage(event) {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;
        const whatsappLink =
            `https://wa.me/918238790204?text=Name:%20${encodeURIComponent(name)}%0AEmail:%20${encodeURIComponent(email)}%0AMessage:%20${encodeURIComponent(message)}`;
        window.open(whatsappLink, '_blank');
    }
    </script>
</body>

</html>