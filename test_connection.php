<?php
require_once 'db.php';

if ($conn) {
    echo "Database connected successfully!";
} else {
    echo "ERROR: Could not connect. " . mysqli_connect_error();
}
?>
