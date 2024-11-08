<?php
session_start();
include('db.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            echo '<p class="error">The email address is already registered!</p>';
        } else {
            $query = $connection->prepare("INSERT INTO users(username, password, email) VALUES (:username, :password_hash, :email)");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);

            $result = $query->execute();
            if ($result) {
                echo '<p class="success">Your registration was successful!</p>';
            } else {
                echo '<p class="error">Your registration was not successful!</p>';
            }
        }
    } else {
        echo '<p class="error">Passwords do not match!</p>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordError = document.getElementById('password_error');

            const passwordPattern = /^(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*\W).{6,}$/;

            if (!password.match(passwordPattern)) {
                passwordError.textContent = "Password must be at least 6 characters long, contain at least 2 alphabets (one in capital letter), and a special character.";
                return false;
            }

            if (password !== confirmPassword) {
                passwordError.textContent = "Passwords do not match.";
                return false;
            }

            passwordError.textContent = "";
            return true;
        }
    </script>
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
    <h2>Register</h2>
<form method="post" action="" name="signup-form" onsubmit="return validatePassword()">
    <div class="form-element">
        <label>Username</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Email</label>
        <input type="email" name="email" required />
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" id="password" name="password" required />    
    </div>
    <div class="form-element">
        <label>Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required />    
    </div>
    <p id="password_criteria" style="color:grey;">Password must be at least 6 characters long, contain at least 2 alphabets (one in capital letter), and a special character.</p>
    <p id="password_error" style="color:red;"></p>
    <button type="submit" name="register" value="register">Register</button>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</form>
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
            function goBack() {
                window.history.back();
            }
        </script>
</body>
</html>
