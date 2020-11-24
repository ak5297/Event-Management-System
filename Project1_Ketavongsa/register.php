<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
    
<div class="form">
<h1>Registration</h1>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<input type="password" name="password" placeholder="Password" required />
    <br/> <br/>
<label for="role">Select a role:</label>
  <select id="role" name="role">
    <option value="2">Event Manager</option>
    <option value="3">Attendee</option>
  </select>
<input type="submit" name="submit" value="Register" />
</form>
<br /><br />
</div>
</body>
</html>
    
<?php
        require_once "DB.class.php";
        $db = new DB();
    
        if (isset($_POST['name'], $_POST['password'], $_POST['role'], $_POST['submit'])) {
           echo $db->validateRegistration();
       }

?>
