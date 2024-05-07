<?php

session_start();
include('connection.php');

if (!isset($_POST['email']) || !isset($_POST['upassword'])) {
    echo "<h1>Invalid request.</h1>";
    exit;
}

$uemail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
if ($uemail === false) {
    echo "<h1>Invalid email address.</h1>";
    exit;
}

$upassword = $_POST['upassword'];  // Get the plain password from POST

// Use prepared statements to avoid SQL injection
$sql = "SELECT uname, upassword, is_admin FROM reg_user WHERE uemail = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $uemail);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    // Verify the password using MD5
    if (md5($upassword) === $row['upassword']) {
        $_SESSION['uemail'] = $uemail;
        $_SESSION['uname'] = $row['uname'];
        session_regenerate_id(true);
        setcookie('session_id', session_id(), time() + 3600, '/');

        // Redirect based on the user type
        if ($row['is_admin']) {
            header('Location: admin_dashboard.php');
            exit();
        } else {
            header('Location: Products.php');
            exit();
        }
    } else {
        echo "<h1>Login failed. Incorrect password.</h1>";
    }
} else {
    echo "<h1>Login failed. User does not exist.</h1>";
}
?>
