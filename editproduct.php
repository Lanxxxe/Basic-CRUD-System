<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $ProductID = $_GET['ProductID'];
    $ProductName = $_POST['ProductName'];
    $CategoryID = $_POST['CategoryID'];
    $Price = $_POST['Price'];

    // Initialize the image path variable
    $ImagePath = "";

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $fileinfo = PATHINFO($_FILES["photo"]["name"]);
        $newFilename = $fileinfo['filename'] . "_" . time() . "." . $fileinfo['extension'];
        $ImagePath = "upload/" . $newFilename;

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $ImagePath)) {
            echo "Error uploading file.";
            exit();
        }
    }

    // Prepare the SQL statement
    if ($ImagePath != "") {
        // Update all fields including the photo
        $sql = "UPDATE product SET ProductName=?, CategoryID=?, Price=?, ImagePath=? WHERE ProductID=?";
        $statement = $conn->prepare($sql);
        $statement->bind_param('sidsi', $ProductName, $CategoryID, $Price, $ImagePath, $ProductID);
    } else {
        // Update all fields except the photo
        $sql = "UPDATE product SET ProductName=?, CategoryID=?, Price=? WHERE ProductID=?";
        $statement = $conn->prepare($sql);
        $statement->bind_param('sidi', $ProductName, $CategoryID, $Price, $ProductID);
    }

    // Check if the preparation was successful
    if ($statement) {
        // Execute the statement
        if ($statement->execute()) {
            // Redirect to product page after successful update
            header('Location: product.php');
            exit();
        } else {
            // Handle execution error
            echo "Error updating product: " . $statement->error;
        }

        // Close the statement
        $statement->close();
    } else {
        // Handle preparation error
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
