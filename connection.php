
<?php      
    $host = "localhost";  
    $user = "root";  
    $password = '';  
    $db_name ="store_db";
      
    $con = mysqli_connect($host, $user, $password, $db_name);  
    
    if (mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  

    // Set the default character set to utf8mb4
    if (!mysqli_set_charset($con, "utf8mb4")) {
        die("Error loading character set utf8mb4: ". mysqli_error($con));
    }
?>  
