<?php
include('session.php');
?>
<?php
$userId = $_SESSION['userHash'];
$userHash = $_SESSION['userId'];
$nameOfTask = $_POST["taskName"];
$taskId = $_POST["uniqueId"];
$descriptionOfTask = $_POST["taskDescription"];


// Database Connection Information
$servername    = "127.0.0.1";
$database_user = "";
$password      = "";
$dbname        = "";

$con = mysqli_connect($servername, $database_user, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    echo json_encode(array(
        'error_code' => "1",
        'message' => "$conn->connect_error"
    ));
}

else {
	$updateTime = date("Y-m-d h:i");
	// echo $updateTime;
    $sql = "update sodingTasks set taskName = '$nameOfTask', taskDescription = '$descriptionOfTask', dateUpdated = '$updateTime' where uId = '$userHash' and secret = '$userId' and tId = $taskId;";
    // echo $sql;
    $res = mysqli_query($con, $sql);

    if ($res)
    {
        if ($res->num_rows === 0) {
        	echo "Error Occurred!";
        }
        else
        {
            header('Location: profile.php'); // Redirecting To Home Page
    }
        
    }
    else
    {
        echo json_encode(array(
                'error_code' => "1",
                'message' => "Some Error Occurred."
            ));
    }
}

$con->close();
?>