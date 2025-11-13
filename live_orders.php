<?php
header("Content-Type: application/json");
$conn = new mysqli("localhost","root","","food_orders");

$orders = [];
$res = $conn->query("SELECT * FROM orders ORDER BY id DESC");

while($row = $res->fetch_assoc()){
    $id = $row["id"];
    $items_res = $conn->query("SELECT item_name, price FROM order_items WHERE order_id=$id");

    $items = [];
    while($i=$items_res->fetch_assoc()) $items[]=$i;

    $row["items"] = $items;
    $orders[] = $row;
}

echo json_encode($orders);
?>
