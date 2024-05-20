<?php
include('conn.php');

// Check if the category ID is set and valid
if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $id = $_GET['category'];

    // Prepare the SQL statement
    $sql = "DELETE FROM category WHERE CategoryID = ?";
    $statement = $conn->prepare($sql);

    if ($statement) {
        // Bind the parameter
        $statement->bind_param('i', $id);

        // Execute the statement
        if ($statement->execute()) {
            // Redirect to category page after successful deletion
            header('Location: category.php');
            exit();
        } else {
            // Handle execution error
            echo "Error deleting category: " . $statement->error;
        }

        // Close the statement
        $statement->close();
    } else {
        // Handle preparation error
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    // Handle invalid category ID
    echo "Invalid category ID.";
}

// Close the connection
$conn->close();
?>
