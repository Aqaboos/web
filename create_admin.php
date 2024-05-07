<?php
include 'connection.php';  // Ensures you have database connection

// Admin credentials
$adminName = "Admin";
$adminEmail = "admin@saudiclothes.com";
$adminPassword = "Admin$2024!";  // Strong password recommended
$isAdmin = 1;  // Boolean or similar flag indicating admin status

// Hashing the password (using MD5 for compatibility as discussed, not recommended for production)
$hashedPassword = md5($adminPassword);

// SQL to insert new admin
$sql = "INSERT INTO reg_user (uname, uemail, upassword, is_admin) VALUES (?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sssi", $adminName, $adminEmail, $hashedPassword, $isAdmin);

// Execute the query and check for success
if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Error creating admin user: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
