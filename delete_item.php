<?php
session_start();
include 'connection.php';  // Ensures a secure and consistent database connection

// Verify that the user is logged in and is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    exit('Access Denied: You do not have the appropriate permissions to perform this action.');
}

// Check for CSRF token here if implemented in your forms

// Check if the request method is POST and if the item ID is present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemId'])) {
    $itemId = intval($_POST['itemId']);  // Convert to integer for safety

    // Prepare SQL statement to prevent SQL injection
    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Item deleted successfully!";
        header("Location: manage_products.php"); // Redirect back to product management page to prevent re-submissions
        exit();
    } else {
        echo "Error deleting item: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request or missing item ID.";
}
?>
