<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderData = json_decode(file_get_contents('php://input'), true);

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "orders";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit();
    }

    // Insert order data into database
    $stmt = $conn->prepare("INSERT INTO orders (item_name, item_price, order_time) VALUES (?, ?, NOW())");

    foreach ($orderData['items'] as $item) {
        $stmt->bind_param("sd", $item['name'], $item['price']);
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to place order']);
            $stmt->close();
            $conn->close();
            exit();
        }
    }

    $stmt->close();
    $conn->close();

    echo json_encode(['success' => true]);
}
?>