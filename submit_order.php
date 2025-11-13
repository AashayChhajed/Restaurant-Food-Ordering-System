<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) { echo json_encode(["success"=>false]); exit; }

$conn = new mysqli("localhost","root","","food_orders");

$items = $data["items"];

$total = 0;
foreach ($items as $i) $total += $i["price"];

/* Create order */
$stmt = $conn->prepare("INSERT INTO orders (total_price) VALUES (?)");
$stmt->bind_param("i",$total);
$stmt->execute();
$order_id = $stmt->insert_id;

/* Insert each item */
$stmt2 = $conn->prepare("INSERT INTO order_items (order_id, item_name, price) VALUES (?,?,?)");

foreach ($items as $i){
    $stmt2->bind_param("isi", $order_id, $i["name"], $i["price"]);
    $stmt2->execute();
}

echo json_encode(["success"=>true]);
?>
