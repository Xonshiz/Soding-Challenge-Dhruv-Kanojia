<?php
include('session.php');

// Database Connection Information
$servername    = "127.0.0.1";
$database_user = "";
$password      = "";
$dbname        = "";

// stuff we need to add an entry (basic stuff)
$nameOfTask = $_POST["taskName"];
$descriptionOfTask = $_POST["taskDescription"];
$userId = $_SESSION['userId'];
$userHash = $_SESSION['userHash'];

$con = mysqli_connect($servername, $database_user, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    echo json_encode(array(
        'error_code' => "1",
        'message' => "$con->connect_error"
    ));
}

else {
    $sql = "insert into sodingTasks (taskName, taskDescription, uId, secret) values ('$nameOfTask', '$descriptionOfTask', $userId, '$userHash');";
    // echo $sql;
    if ($con->query($sql) === TRUE) 
                {
                	header("location: profile.php"); // Redirecting To Other Page
                } else 
                {
                    // echo "Error: " . $sql . "<br>" . $conn->error;
                    echo json_encode(array(
                        'error_code' => '1',
                        'message' => 'Record Exists already.'
                        
                    ));
                }
}

$con->close();

?>