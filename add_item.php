<?php
session_start();
include 'connection.php';  // Ensure this includes the correct database connection setup

// Display debugging information
echo "Debugging Info:<br>";
echo "Request Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
echo "POST Data: ";
print_r($_POST);
echo "<br>FILES Data: ";
print_r($_FILES);
echo "<br>";

// Check if the form submission is via POST and the necessary elements are present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["itemPhoto"]) && isset($_POST['productName'])) {
    $productName = htmlspecialchars($_POST['productName']); // Sanitize the input to prevent XSS
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["itemPhoto"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate that the file is an actual image
    $check = getimagesize($_FILES["itemPhoto"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size - limit to 5MB
        if ($_FILES["itemPhoto"]["size"] > 5000000) {
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        // Attempt to upload the file if all checks pass
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
        } else {
            if (move_uploaded_file($_FILES["itemPhoto"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO products (product_name, product_img) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    die("SQL Error: " . $conn->error);
                }
                $stmt->bind_param("ss", $productName, $target_file);
                if ($stmt->execute()) {
                    echo "The product has been added successfully!<br>";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    } else {
        echo "File is not an image.<br>";
    }
} else {
    echo "Invalid request method or no file uploaded.<br>";
}
?>
