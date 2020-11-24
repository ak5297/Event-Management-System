<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<h1>Log In</h1>
<form method="POST" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" />
</form>
<p>Not registered yet? <a href='register.php'>Register Here</a></p>
<br /><br />
</div>
</body>
</html>  
    
<?php
    require_once "DB.class.php";
    $db = new DB();
    // If form submitted, insert values into the database.
    if (isset($_POST['username'], $_POST['password'], $_POST['submit'])){
        echo $db->validateLogin();
    }
    
?>



    


