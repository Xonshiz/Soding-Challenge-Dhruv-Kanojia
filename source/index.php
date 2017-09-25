<?php
include('login.php'); // Includes Login Script

if(isset($_SESSION['login_user'])){
header("location: profile.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Soding : Individual Assessment | Xonshiz</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main">
<div id="login">
<h2>Login Form</h2>
<form action="" method="post">
<label>UserName :</label>
<input id="name" name="username" placeholder="username" type="text" required >
<label>Password :</label>
<input id="password" name="password" placeholder="**********" type="password" required >
<input name="submit" type="submit" value=" Login ">
<span><?php echo $error; ?></span>
</form>
</div>
</div>

<div id="signUp">
<h2>Sign Up Form</h2>
<form action="signUp.php" method="post">
<label>UserName :</label>
<input id="name" name="username" placeholder="username" type="text" required >
<label>Password :</label>
<input id="password" name="password" placeholder="**********" type="password" required >
<input name="submit" type="submit" value="SignUp">
<span><?php echo $_SESSION["signUpError"]; ?></span>
</form>
</div>
</div>
</body>
</html>