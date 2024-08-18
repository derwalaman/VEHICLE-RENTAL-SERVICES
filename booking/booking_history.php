<?php
    
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
    <title>Booking History</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
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
                <li><a class="nav-link" href="booking/booking_history.php">Booking</a></li>
                <li><a class="nav-link" href="../loginSignup.php">Login/Signup</a></li>
                <li><a class="nav-link" href="../logout.php">Logout</a></li>
                <li><a class="nav-link" href="../index.php#contact">Contact us</a></li>
            </ul>
        </div>
    </header>
    <main>
        <section id="live-bookings">
            <h2>Live Bookings</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Rental Date</th>
                            <th>Return Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="live-bookings-body">
                        <!-- Live bookings will be populated here -->
                    </tbody>
                </table>
            </div>
        </section>
        <section id="completed-bookings">
            <h2>Completed Bookings</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Rental Date</th>
                            <th>Return Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="completed-bookings-body">
                        <!-- Completed bookings will be populated here -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script src="booking_history.js"></script>
    <script>
    function toggleNavbar() {
        const navbarMenu = document.getElementById('hamburgerMenu');
        navbarMenu.classList.toggle('active');
    }
    </script>
</body>

</html>
