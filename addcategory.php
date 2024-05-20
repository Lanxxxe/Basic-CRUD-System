<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $Category_Name = trim($_POST['categoryname']);

    // Prepare the SQL statement
    $query = "INSERT INTO category (CategoryName) VALUES (?)";
    $statement = $conn->prepare($query);

    // Check if the preparation was successful
    if ($statement) {
        // Bind the parameter
        $statement->bind_param('s', $Category_Name);

        // Execute the statement
        if ($statement->execute()) {
            // Redirect to category page after successful insertion
            header('Location: category.php');
            exit();
        } else {
            // Handle execution error
            echo "Error inserting new category: " . $statement->error;
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
