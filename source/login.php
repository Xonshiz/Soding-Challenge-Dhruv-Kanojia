<?php
session_start(); // Starting Session
$error = ''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    } else {
        // Define $username and $password
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Database Connection Information
        $servername    = "127.0.0.1";
        $database_user = "";
        $db_password      = "";
        $dbname        = "";
        
        $con = mysqli_connect($servername, $database_user, $db_password, $dbname);
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        else {
            $sql = "select * from sodingUser where password='$password' AND Name ='$username';";
            // echo $sql;
            $res = mysqli_query($con, $sql);
            
            if ($res) {
                if ($res->num_rows === 0) {
                    $error = "Username or Password is invalid";
                    
                } else {
                    while ($row = $res->fetch_assoc()) {
                        $_SESSION['login_user'] = $username; // Initializing Session
                        $_SESSION['userHash'] = $row["userSecret"]; // User's Hash
                        $_SESSION['userId'] = $row["uId"]; // User's ID
                    }
                }
                
            } else {
                echo json_encode(array(
                    'error_code' => "1",
                    'message' => "Some Error Occurred."
                ));
            }
        }
        
        $con->close();
    }
}
?>