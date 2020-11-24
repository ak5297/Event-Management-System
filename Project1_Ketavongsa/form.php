<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Form</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
    
<div class="form">
<h1>Form</h1>

<!-- users/attendees -->
<?php if(isset($_POST['addUser']) || if(isset($_POST['editUser']) { ?>
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
<?php } ?>

<!-- venue -->
<?php if(isset($_POST['addVenue']) || if(isset($_POST['editVenue']) { ?>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<input type="text" name="capacity" placeholder="Capacity" required />
    <br/> <br/>
<input type="submit" name="submit" value="Register" />
</form>
<?php } ?>

<!-- events -->
<?php if(isset($_POST['addEvent']) || if(isset($_POST['editEvent']) { ?>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<input type="datetime-local" name="datestart" placeholder="Date Start" required />
    <br/> <br/>
 <input type="datetime-local" name="dateend" placeholder="Date End" required />
 <input type="text" name="numberallowed" placeholder="Number Allowed" required />
 <input type="text" name="venue" placeholder="Venue" required />
<input type="submit" name="submit" value="Register" />
</form>
<?php } ?>

<!-- session -->
<?php if(isset($_POST['addSession']) || if(isset($_POST['editSession']) { ?>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<input type="text" name="numberallowed" placeholder="Number Allowed" required />
    <br/> <br/>
 <input type="text" name="event" placeholder="Event" required />
 <input type="datetime-local" name="startdate" placeholder="Start Date" required />
 <input type="datetime-local" name="enddate" placeholder="End Date" required />
<input type="submit" name="submit" value="Register" />
</form>
<?php } ?>



<br /><br />
</div>
</body>
</html>
    
<?php
        require_once "DB.class.php";
        $db = new DB();
    
        if (isset($_POST['name'], $_POST['password'], $_POST['role'], $_POST['submit'])) {
           echo $db->addUsers();
       }

       if (isset($_POST['name'], $_POST['password'], $_POST['role'], $_POST['submit'])) {
        echo $db->addUsers();
    }

?>
