<?php
include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>Task Manager | <?php echo $login_session; ?></title>
<link href="style.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
function showfield(uniqueId, name){
  if (uniqueId == 0) 
  {
  	alert("Select a proper task!");
  }
  else
  {
  	if(name)document.getElementById('editTaskDiv').innerHTML='<input type="hidden" name="uniqueId" value="'+uniqueId+'"><input type="text" name="taskName" value="'+name+'"><input type="text" name="taskDescription" placeholder="Task Description"><input type="submit" value="Submit">';
  else document.getElementById('editTaskDiv').innerHTML='';
  }
}

function showfield_delete(uniqueId, name){
  if (uniqueId == 0) 
  {
    alert("Select a proper task!");
  }
  else
  {
    if(name)document.getElementById('deleteTaskDiv').innerHTML='<input type="hidden" name="uniqueId" value="'+uniqueId+'"><input type="hidden" name="taskName" value="'+name+'"><input type="submit" value="DELETE TASK">';
  else document.getElementById('deleteTaskDiv').innerHTML='';
  }
}
</script>

<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>

</head>
<body>
<div id="profile">
<b id="welcome">Welcome : <i><?php
echo $login_session;
?></i></b>
<b id="logout"><a href="logout.php">Log Out</a></b>
<!-- <?php
// echo $_SESSION['login_user'];
?>
<?php
// echo $_SESSION['userHash'];
?>
<?php
// echo $_SESSION['userId'];
?> -->

<hr>
<h1> Add A New Task </h1>
<form action="newTask.php" method="post">
  <input type="text" name="taskName" placeholder="Task Name">
  
  <input type="text" name="taskDescription" placeholder="Task Description">
  
  <input type="submit" value="Submit">
</form> 

<hr>
&nbsp;
<h1>Your Tasks</h1>

<?php
$userHash = $_SESSION['userHash'];
$userName = $_SESSION['login_user'];
$userId = $_SESSION['userId'];

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

else 
{
    $sql = "select * from sodingTasks where uId = '$userId' and secret = '$userHash';";
    $res = mysqli_query($con, $sql);

    if ($res)
    {
        if ($res->num_rows === 0) {
            echo "No Tasks Yet...";
        }
        else
        {
        	echo "<table>";
        	echo "<tr>
    <th>Task Name</th>
    <th>Task Description</th>
    <th>Date Of Creation</th>
    <th>Date Of Updation</th>
  </tr>";
            while ($row = $res->fetch_assoc()) {
            	echo "<tr>
    <td>".$row["taskName"]."</td>
    <td>".$row["taskDescription"]."</td>
    <td>".$row["dateCreated"]."</td>
    <td>".$row["dateUpdated"]."</td>
  </tr>";
            
        }
        echo "</table>";
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

// $con->close();


?>

<hr>
&nbsp;
<h1>Edit Tasks</h1>

<form action="taskEdit.php" method="post">
	<select name="listOfTasks" id="listOfTasks" onchange="showfield(this.options[this.selectedIndex].id, this.options[this.selectedIndex].value)">
	<option id="0" value="--Select A Value --">Select A Value</option>
  <?php
  $sql = "select taskName, tId from sodingTasks where uId = '$userId' and secret = '$userHash';";
    $res = mysqli_query($con, $sql);

    if ($res)
    {
        if ($res->num_rows === 0) {
            echo "No Tasks Yet...";
        }
        else
        {
        	while ($row = $res->fetch_assoc()) {
            	echo "<option id=\"".$row["tId"]."\" value=\"".$row["taskName"]."\">".$row["taskName"]."</option>";            
        }
    }
        
    }
    else
    {
        echo json_encode(array(
                'error_code' => "1",
                'message' => "Some Error Occurred."
            ));
    }
  ?>

</select>
&nbsp;
<div id="editTaskDiv">
	
</div>
</form>

<hr>
&nbsp;
<h1>Delete Tasks</h1>

<form action="taskDelete.php" method="post">
  <select name="listOfTasks" id="listOfTasks" onchange="showfield_delete(this.options[this.selectedIndex].id, this.options[this.selectedIndex].value)">
  <option id="0" value="--Select A Value --">Select A Value</option>
  <?php
  $sql = "select taskName, tId from sodingTasks where uId = '$userId' and secret = '$userHash';";
    $res = mysqli_query($con, $sql);

    if ($res)
    {
        if ($res->num_rows === 0) {
            echo "No Tasks Yet...";
        }
        else
        {
          while ($row = $res->fetch_assoc()) {
              echo "<option id=\"".$row["tId"]."\" value=\"".$row["taskName"]."\">".$row["taskName"]."</option>";            
        }
    }
        
    }
    else
    {
        echo json_encode(array(
                'error_code' => "1",
                'message' => "Some Error Occurred."
            ));
    }
  ?>

</select>
&nbsp;
<div id="deleteTaskDiv">
  
</div>
</form>
&nbsp;
</div>
</body>
</html>