<?php
session_start();
include 'connection.php';

// Verify that the user is logged in and is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    exit('Access Denied: You do not have permission to access this page.');
}

// Handle adding an item
if (isset($_POST['addItem']) && isset($_FILES['itemPhoto'])) {
    $itemName = $_POST['itemName'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["itemPhoto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an image
    $check = getimagesize($_FILES["itemPhoto"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["itemPhoto"]["size"] > 5000000) { // 5MB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["itemPhoto"]["tmp_name"], $target_file)) {
            // Insert the new item into the database
            $sql = "INSERT INTO items (name, photo) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $itemName, $target_file);
            if ($stmt->execute()) {
                echo "Item added successfully!";
            } else {
                echo "Error adding item: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Handle deleting an item
if (isset($_POST['deleteItem'])) {
    $itemId = $_POST['itemId'];
    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $itemId);
    if ($stmt->execute()) {
        echo "Item deleted successfully!";
    } else {
        echo "Error deleting item: " . $conn->error;
    }
}

// Handle deleting a user (additional functionality)
if (isset($_POST['deleteUser'])) {
    $userEmail = $_POST['userEmail'];
    $sql = "DELETE FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    if ($stmt->execute()) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?>
