<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer = $_POST['customer'];
    $cartData = json_decode($_POST['cart_data'], true); // Decode the JSON data

    // Process the order
    foreach ($cartData as $productId => $quantity) {
        // Here you can insert each item into your orders table or handle the order as needed
        $statement = $conn->prepare("INSERT INTO orders (CustomerName, ProductID, Quantity) VALUES (?, ?, ?)");
        $statement->bind_param("sii", $customer, $productId, $quantity);
        $statement->execute();
    }

    echo "Order placed successfully!";
}

