<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'include/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['paymentMethod'];

    $card_number = $_POST['cardNumber'] ?? null;
    $expiry_date = $_POST['expiryDate'] ?? null;
    $cvv = $_POST['cvv'] ?? null;
    $paypal_email = $_POST['paypalEmail'] ?? null;
    $account_number = $_POST['accountNumber'] ?? null;
    $bank_name = $_POST['bankName'] ?? null;
    $routing_number = $_POST['routingNumber'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO payments (user_id, amount, payment_method, card_number, expiry_date, cvv, paypal_email, account_number, bank_name, routing_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $amount, $payment_method, $card_number, $expiry_date, $cvv, $paypal_email, $account_number, $bank_name, $routing_number]);


    header('Location: confirmation.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .payment-method {
            display: none;
        }
    </style>
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
            <h2>Payment</h2>
            <form action="payment.php" method="POST" id="paymentForm">
                <label for="paymentMethod">Payment Method</label>
                <select id="paymentMethod" name="paymentMethod" onchange="showPaymentMethodFields()" required>
                    <option value="" disabled selected>Select Payment Method</option>
                    <option value="card">Debit/Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank">Bank Transfer</option>
                </select>

                <div id="cardFields" class="payment-method">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" name="cardNumber" pattern="\d{16}" title="Enter a valid 16-digit card number">
                    <label for="expiryDate">Expiry Date</label>
                    <input type="text" id="expiryDate" name="expiryDate" pattern="\d{2}/\d{2}" title="Enter a valid expiry date in MM/YY format">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" pattern="\d{3}" title="Enter a valid 3-digit CVV">
                </div>

                <div id="paypalFields" class="payment-method">
                    <label for="paypalEmail">PayPal Email</label>
                    <input type="email" id="paypalEmail" name="paypalEmail">
                </div>

                <div id="bankFields" class="payment-method">
                    <label for="accountNumber">Account Number</label>
                    <input type="text" id="accountNumber" name="accountNumber">
                    <label for="bankName">Bank Name</label>
                    <input type="text" id="bankName" name="bankName">
                    <label for="routingNumber">Routing Number</label>
                    <input type="text" id="routingNumber" name="routingNumber">
                </div>

                <input type="hidden" name="amount" value="<?php echo htmlspecialchars($_GET['amount']); ?>">
                <button type="submit">Pay Now</button>
            </form>
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
        function showPaymentMethodFields() {
            const paymentMethod = document.getElementById('paymentMethod').value;
            const cardFields = document.getElementById('cardFields');
            const paypalFields = document.getElementById('paypalFields');
            const bankFields = document.getElementById('bankFields');

            cardFields.style.display = 'none';
            paypalFields.style.display = 'none';
            bankFields.style.display = 'none';

            if (paymentMethod === 'card') {
                cardFields.style.display = 'block';
            } else if (paymentMethod === 'paypal') {
                paypalFields.style.display = 'block';
            } else if (paymentMethod === 'bank') {
                bankFields.style.display = 'block';
            }
        }

        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
