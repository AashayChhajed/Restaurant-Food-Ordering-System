<?php
$conn = new mysqli("localhost", "root", "", "food_orders");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Delete child items first
$conn->query("DELETE FROM order_items");

// Delete orders
$conn->query("DELETE FROM orders");

// Reset auto increment
$conn->query("ALTER TABLE orders AUTO_INCREMENT = 1");

header("Location: admin.php");
exit;
?>
