<?php
session_start();
include 'connection.php';  // Ensures a secure and consistent database connection

// Verify that the user is logged in and is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    exit('Access Denied: You do not have the appropriate permissions to perform this action.');
}

// Check for CSRF token here if implemented in your forms

// Ensure the request method is POST and a user ID has been provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
    $userId = intval($_POST['userId']);  // Convert to integer for safety

    // Prepare SQL statement to prevent SQL injection
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    // Execute the statement and provide feedback
    if ($stmt->execute()) {
        echo "User deleted successfully!";
        header("Location: manage_users.php"); // Redirect to manage users page to avoid resubmission
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request or missing user ID.";
}
?>
