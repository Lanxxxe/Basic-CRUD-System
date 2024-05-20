<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $CategoryID = $_POST['CategoryID'];
    $ProductName = $_POST['ProductName'];
    $Price = $_POST['Price'];

    // Handle file upload
    $ImagePath = "";
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
    $sql = "INSERT INTO product (CategoryID, ProductName, Price, ImagePath) VALUES (?, ?, ?, ?)";
    $statement = $conn->prepare($sql);

    // Check if the preparation was successful
    if ($statement) {
        // Bind the parameters
        $statement->bind_param('isds', $CategoryID, $ProductName, $Price, $ImagePath);

        // Execute the statement
        if ($statement->execute()) {
            // Redirect to product page after successful insertion
            header('Location: product.php');
            exit();
        } else {
            // Handle execution error
            echo "Error inserting new product: " . $statement->error;
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
