<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bongani and Beauty</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header>
            <nav class="navbar">
                <div class="navbar_container">
                    <a href="#" id="navbar_logo">
                        <img src="images/bb.png" alt="Logo" />
                    </a>
                    <div class="navbar_toggle" id="mobile-menu">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                    <ul class="navbar_menu">
                        <li class="navbar_item">
                            <a href="#services" class="navbar_links">Services</a>
                        </li>
                        <li class="navbar_item">
                            <a href="#products" class="navbar_links">Products</a>
                        </li>
                        <li class="navbar_item">
                            <a href="#booking" class="navbar_links">Book Appointment</a>
                        </li>
                        <li class="navbar_item">
                            <a href="#pricing" class="navbar_links">Price list</a>
                        </li>
                        <li class="navbar_item">
                            <a href="cart.php" class="navbar_links">Cart</a>
                        </li>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li class="navbar_item">
                                <a href="my_account.php" class="navbar_links">My Account</a>
                            </li>
                            <li class="navbar_btn">
                                <a href="logout.php" class="button">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="navbar_btn">
                                <a href="login.php" class="button">Login</a>
                            </li>
                            <li class="navbar_btn">
                                <a href="register.php" class="button">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
            <section class="welcome">
                <div class="slideshow-container">
                    <div class="mySlides fade" style="background-image: url('images/3haiir.png');">
                        <div class="container">
                            <h1>Welcome to Bongani & Beauty</h1>
                            <p>Your destination for all your beauty needs.</p>
                        </div>
                    </div>
                    <div class="mySlides fade" style="background-image: url('images/nails3.png');">
                        <div class="container">
                            <h1>Book Now or Visit our Cart</h1>
                            <p><a href="#booking" class="link">Book Now</a> or <a href="cart.php" class="link">Go to Cart</a></p>
                        </div>
                    </div>
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
            </section>
        </header>

        <section id="services" class="section">
            <div class="container">
                <h2>Our Services</h2>
                <div id="services-list" class="grid-container"></div>
            </div>
        </section>
        <section id="products" class="section">
            <div class="container">
                <h2>Our Products</h2>
                <div id="products-list" class="grid-container"></div>
            </div>
        </section>
        <section id="booking" class="section">
            <div class="container">
                <h2>Book an Appointment</h2>
            <p>Our operating hours are:</p>
            <p>Monday to Friday: 8 AM to 5 PM<p>
            <p>Saturday: 9 AM to 2 PM</p>
            
                <form id="bookingForm" action="include/book.php" method="POST">
                    <label for="name" class="sr-only">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Name" required>
                    
                    <label for="email" class="sr-only">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    
                    <label for="date" class="sr-only">Date:</label>
                    <input type="date" id="date" name="date" required>
                    
                    <label for="time" class="sr-only">Time:</label>
                    <input type="time" id="time" name="time" required>
                    
                    <label for="service" class="sr-only">Service:</label>
                    <select id="service" name="service" required>
                        <option value="" disabled selected>Select a Service</option>
                        <option value="nail-care">Nail Care</option>
                        <option value="hair-styling">Hair Styling</option>
                        <option value="lash-additions">Lash Additions</option>
                    </select>
                    <?php if (isset($_SESSION['username'])): ?>
                        <button type="submit">Book Now</button>
                    <?php else: ?>
                        <p>Please <a href="login.php">log in</a> to book.</p>
                    <?php endif; ?>
                </form>
            </div>
        </section>

        <section id="pricing" class="section">
            <div class="container">
                <h2>Here are our amazing prices</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Plain Acrylic Tips</td><td>R250</td></tr>
                        <tr><td>Gel Overlay</td><td>R220</td></tr>
                        <tr><td>Buff & Shine</td><td>R100</td></tr>
                        <tr><td>Nail Design</td><td>R10pn</td></tr>
                        <tr><td>Normal Braids/Twists</td><td>R350</td></tr>
                        <tr><td>Knotless Braids</td><td>R400</td></tr>
                        <tr><td>Extensions</td><td>R100</td></tr>
                        <tr><td>Hybrid Lashes</td><td>R300</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
        <footer>
            <div class="container">
                <h2>Get in Touch</h2>
                <p>Lebowakgomo, Midrand, and Centurion, South Africa</p>
                <p>Phone: 067 130 0303</p>
                <p>Email: <a href="mailto:info@bonganiandbeauty.co.za">info@bonganiandbeauty.co.za</a></p>
                <p>&copy; 2024 Bongani and Beauty. All Rights Reserved.</p>
            </div>
        </footer>

        <button onclick="scrollToTop()" id="upBtn" title="Go to top">↑</button>
        <script src="js/script.js"></script>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </body>
</html>
