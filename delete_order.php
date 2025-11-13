<?php
$conn = new mysqli("localhost", "root", "", "food_orders");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Delete from orders (order_items will auto-delete via CASCADE)
    $conn->query("DELETE FROM orders WHERE id = $id");
}

header("Location: admin.php");
exit;
?>
