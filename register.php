<?php
session_start();
    // print_r($_POST);
    echo "im here 1";
    // if(isset($_POST['submit']))
    // {
        echo "im here 2";
        $uname = $_POST['uname'];
        $uemail = $_POST['uemail'];
        $upassword = $_POST['upassword'];
        $phone = $_POST['phone'];
    // }
    // database details
    $host = "localhost";
    $username = "root";
    $password = "";
    // $dbname = "user_db";
    $dbname = "store_db";

    // creating a connection
    $con = mysqli_connect($host, $username, $password, $dbname);

    // to ensure that the connection is made
    if (!$con)
    {
        die("Connection failed!" . mysqli_connect_error());
    }
$encrypted_password = md5($upassword);
    // using sql to create a data entry query
    $sql = "INSERT INTO reg_user ( uemail, uname, upassword, phone) VALUES ('$uemail', '$uname' , '$encrypted_password', '$phone')";

    // send query to the database to add values and confirm if successful
    $rs = mysqli_query($con, $sql);
    if($rs)
    {
        // Generate a new session ID
               $session_id = bin2hex(random_bytes(32));
               $_SESSION['session_id'] = $session_id;
               setcookie('session_id', $session_id, time() + 3600, '/');

        echo "Entries added!";

        header('Location: Login.html');
        exit;
    }
    // close connection
    mysqli_close($con);
?>
