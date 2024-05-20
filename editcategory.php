<?php
include('conn.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $Category_ID = $_GET['category'];
    $Category_Name = $_POST['CategoryName'];

    // Update query
    $sql = "UPDATE category SET CategoryName=? WHERE CategoryID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $Category_Name, $Category_ID);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to category page after update
        header('Location: category.php');
        exit();
    } else {
        // Handle update error
        echo "Error updating record: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>