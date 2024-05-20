<?php
include('conn.php');
session_start();

if(isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the posted form data
        $adminID = $_SESSION['accountID'];
        $TransactionType = $_POST['TransactionType'];
        $DateofTransaction = $_POST['TransactionDate'];
        $CustomerName = $_POST['CustomerName'];
        $cartData = json_decode($_POST['cart_data'], true);

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Insert into PurchaseDetails table
            $stmt = $conn->prepare("INSERT INTO PurchaseDetails (CustomerName, TransactionType, AccountID) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $CustomerName, $TransactionType, $adminID);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $orderId = $stmt->insert_id;
            $stmt->close();

            // Insert into ProductPurchaseDetails table
            $stmt = $conn->prepare("INSERT INTO ProductPurchaseDetails (ProductID, PurchaseDetailsID, Quantity, Subtotal) VALUES (?, ?, ?, ?)");
            $TotalBill = 0;
            foreach ($cartData as $productId => $item) {
                $quantity = $item['quantity'];
                $price = $item['price'];
                $subtotal = $price * $quantity;
                $TotalBill += $subtotal;
                $stmt->bind_param("iiid", $productId, $orderId, $quantity, $subtotal);
                if (!$stmt->execute()) {
                    throw new Exception($stmt->error);
                }
            }
            $stmt->close();

            // Insert into PurchaseBill table
            $stmt = $conn->prepare("INSERT INTO purchasebill (PurchaseDetailsID, DatePurchase, TotalBill) VALUES (?, ?, ?)");
            $stmt->bind_param("isd", $orderId, $DateofTransaction, $TotalBill);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();

            // Commit the transaction
            $conn->commit();
            ?>
            <script>
            window.alert("Purchase Successfully");
            </script>
            <?php
            header('Location: sales.php');
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            $conn->rollback();
            echo '<script>window.alert("Error: ' . $e->getMessage() . '");</script>';
        }
    } else {
        echo '<script>window.alert("Please select a product"); window.location.href="order.php";</script>';
    }
}
?>
