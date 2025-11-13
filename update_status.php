<?php
$conn = new mysqli("localhost","root","","food_orders");

$id = $_POST["id"];
$status = $_POST["status"];

$conn->query("UPDATE orders SET status='$status' WHERE id=$id");

header("Location: kitchen.php");
exit;
?>
