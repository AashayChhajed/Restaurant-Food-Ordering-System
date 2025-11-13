<?php
$conn = new mysqli("localhost", "root", "", "food_orders");
if ($conn->connect_error) {
    die("DB Error");
}

$orders = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel - Orders</title>
<style>
    body { font-family: Arial; background:#f5f5f5; padding:20px; }
    h1 { text-align:center; }
    table { width:100%; background:white; border-collapse:collapse; margin-top:20px; }
    th, td {
        padding:12px; border-bottom:1px solid #ddd; text-align:left;
    }
    th { background:#4CAF50; color:white; }
    tr:hover{ background:#f1f1f1; }
    .btn {
        padding:8px 12px; border:none; border-radius:4px; cursor:pointer; 
        color:white;
    }
    .delete { background:#ff5722; }
    .refresh { background:#ff9800; }
    .clear { background:#9c27b0; }
</style>
</head>
<body>

<h1>Admin Panel - Orders</h1>

<div style="text-align:center; margin-bottom:20px;">
    <button class="btn refresh" onclick="location.reload()">Refresh</button>
    <form method="POST" action="clear_all.php" style="display:inline;">
        <button class="btn clear">Clear All Orders</button>
    </form>
</div>

<table>
    <tr>
        <th>Order ID</th>
        <th>Items</th>
        <th>Total (₹)</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while ($o = $orders->fetch_assoc()): ?>

    <?php
    // Fetch items for this order
    $oid = $o['id'];
    $items_res = $conn->query("SELECT item_name, price FROM order_items WHERE order_id = $oid");

    $itemList = "";
    while($it = $items_res->fetch_assoc()) {
        $itemList .= $it['item_name'] . " (₹" . $it['price'] . ")<br>";
    }
    ?>

    <tr>
        <td><?= $o['id'] ?></td>
        <td><?= $itemList ?></td>
        <td><strong><?= $o['total_price'] ?></strong></td>
        <td><?= $o['status'] ?></td>
        <td>
            <form method="POST" action="delete_order.php">
                <input type="hidden" name="id" value="<?= $o['id'] ?>">
                <button class="btn delete">Delete</button>
            </form>
        </td>
    </tr>

<?php endwhile; ?>

</table>

</body>
</html>
