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
        $db_password   = "";
        $dbname        = "";
        
        $con = mysqli_connect($servername, $database_user, $db_password, $dbname);
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);

        }
        
        else {
            $secret_code = base64_encode($username);
            $sql         = "insert into sodingUser (Name, password, userSecret) values ('$username', '$password', '$secret_code');";
            
            if ($con->query($sql) === TRUE) 
                {
                    $sql2 = "select * from sodingUser where Name = '$username' and password = '$password' ;";
                    // echo $sql2;
                    $res2 = mysqli_query($con, $sql2);
                    if ($res2) {
                        while ($row2 = $res2->fetch_assoc()) 
                        {
                            $_SESSION['login_user'] = $username; // Initializing Session
                            $_SESSION['userHash']   = $row2["userSecret"]; // User's Hash
                            $_SESSION['userId']     = $row2["uId"]; // User's ID
                        }

                    }
                    header("location: profile.php");
                } else 
                {
                    // echo "Error: " . $sql . "<br>" . $conn->error;
                    $error = "Username already exists!";
		            $_SESSION["signUpError"] = "Username already exists!";

                    header("location: index.php");
                }
        }
        
        $con->close();
        
    }
}
?>