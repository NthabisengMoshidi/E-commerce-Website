<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar_container">
                <a href="index.html" id="navbar_logo">Bongani and Beauty</a>
                <div class="navbar_toggle" id="mobile-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Add to Cart</h2>
            <section id="products" class="section">
                <form id="cartForm">
                    <div class="product">
                        <img src="images/african.png" alt="African Print Bonnet">
                        <div class="product-info">
                            <input type="hidden" name="product_id" value="bonnet4">
                            <label for="bonnet4">African Print Bonnet (R100)</label>
                            <input type="number" id="bonnet4" name="quantity" value="0" data-price="100" min="0" required>
                        </div>
                    </div>
                    <div class="product">
                        <img src="images/cotton.png" alt="Cotton Bonnet">
                        <div class="product-info">
                            <input type="hidden" name="product_id" value="bonnet3">
                            <label for="bonnet3">Cotton Bonnet (R80)</label>
                            <input type="number" id="bonnet3" name="quantity" value="0" data-price="80" min="0" required>
                        </div>
                    </div>
                    <div class="product">
                        <img src="images/satin.png" alt="Satin Bonnet">
                        <div class="product-info">
                            <input type="hidden" name="product_id" value="bonnet1">
                            <label for="bonnet1">Satin Bonnet (R120)</label>
                            <input type="number" id="bonnet1" name="quantity" value="0" data-price="120" min="0" required>
                        </div>
                    </div>
                    <div class="product">
                        <img src="images/silk.png" alt="Silk Bonnet">
                        <div class="product-info">
                            <input type="hidden" name="product_id" value="bonnet2">
                            <label for="bonnet2">Silk Bonnet (R150)</label>
                            <input type="number" id="bonnet2" name="quantity" value="0" data-price="150" min="0" required>
                        </div>
                    </div>
                    <div class="product">
                        <img src="images/ch67t5ua.png" alt="Coffee Body Scrub">
                        <div class="product-info">
                            <input type="hidden" name="product_id" value="scrub2">
                            <label for="scrub2">Coffee Body Scrub (R140)</label>
                            <input type="number" id="scrub2" name="quantity" value="0" data-price="140" min="0" required>
                        </div>
                    </div>
                    <div class="product">
                        <img src="images/lavender.png" alt="Lavender Body Scrub">
                        <div class="product-info">
                            <input type="hidden" name="product_id" value="scrub1">
                            <label for="scrub1">Lavender Body Scrub (R140)</label>
                            <input type="number" id="scrub1" name="quantity" value="0" data-price="140" min="0" required>
                        </div>
                    </div>
                    <div class="product">
                        <img src="images/scrub.png" alt="Strawberry Body Scrub">
                        <div class="product-info">
                            <input type="hidden" name="product_id" value="scrub4">
                            <label for="scrub4">Strawberry Body Scrub (R140)</label>
                            <input type="number" id="scrub4" name="quantity" value="0" data-price="140" min="0" required>
                        </div>
                    </div>
                    <div class="product">
                        <img src="images/tumeric.png" alt="Tumeric Body Scrub">
                        <div class="product-info">
                            <input type="hidden" name="product_id" value="scrub3">
                            <label for="scrub3">Tumeric Body Scrub (R140)</label>
                            <input type="number" id="scrub3" name="quantity" value="0" data-price="140" min="0" required>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['username'])): ?>
                        <button type="button" onclick="proceedToPayment()">Proceed to Payment</button>
                    <?php else: ?>
                        <p>Please <a href="login.php">log in</a> to proceed to payment.</p>
                    <?php endif; ?>
                </form>
            </section>
        </div>
    </main>
    <div class="button">
        <button onclick="goBack()">Go Back</button>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 Bongani and Beauty. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.product input[type="number"]').forEach(input => {
                const quantity = parseInt(input.value);
                const price = parseFloat(input.dataset.price);
                total += quantity * price;
            });
            return total;
        }

        document.querySelectorAll('.product input[type="number"]').forEach(input => {
            input.addEventListener('input', () => {
                const total = calculateTotal();
                document.getElementById('totalPrice').textContent = total.toFixed(2);
            });
        });

        function proceedToPayment() {
            const total = calculateTotal();
            const form = document.getElementById('cartForm');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);
            params.append('amount', total);
            window.location.href = `payment.php?${params.toString()}`;
        }

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
