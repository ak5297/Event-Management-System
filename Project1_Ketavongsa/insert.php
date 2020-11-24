<?php
   session_start();

   require_once "DB.class.php";
   $db = new DB();

//checks the form boxes for valid data before processing 

//user form
   if (isset($_POST['name'], $_POST['password'], $_POST['role'], $_POST['submit'])){
    echo $db->addUsers();
}

//venue form
if (isset($_POST['name'], $_POST['capacity'], $_POST['submit'])){
    echo $db->addVenues();
}

//event form
if (isset($_POST['name'], $_POST['datestart'], $_POST['dateend'], $_POST['numberallowed'], $_POST['venue'], $_POST['submit'])){
    echo $db->addEvents();
}

//session form
if (isset($_POST['name'], $_POST['numberallowed'], $_POST['event'], $_POST['startdate'], $_POST['enddate'], $_POST['submit'])){
    echo $db->addSessions();
}

//attendee form
if (isset($_POST['name'], $_POST['password'], $_POST['role'], $_POST['submit'])){
    echo $db->addUsers();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<!-- display appropiate form boxes based on the table selected -->
<?php if(!isset($_SESSION["tables"])){ ?>
<title>Insert New User</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p><a href="javascript:history.back()">Go Back</a>
| <a href="logout.php">Logout</a></p>
<div>
<h1>Insert New User</h1>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<input type="password" name="password" placeholder="Password" required />
    <br/> <br/>
<label for="role">Select a role:</label>
  <select id="role" name="role">
    <option value="2">Event Manager</option>
    <option value="3">Attendee</option>
  </select>
<input type="submit" name="submit" value="Submit" />
</form>
<?php } ?>

<?php if((isset($_SESSION['tables']) == "users" || isset($_SESSION['tables']) == "attendees") && isset($_SESSION["role"]) == 1)  { ?>
<title>Insert New User</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p><a href="javascript:history.back()">Go Back</a>
| <a href="logout.php">Logout</a></p>
<div>
<h1>Insert New User</h1>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<input type="password" name="password" placeholder="Password" required />
    <br/> <br/>
<label for="role">Select a role:</label>
  <select id="role" name="role">
    <option value="2">Event Manager</option>
    <option value="3">Attendee</option>
  </select>
<input type="submit" name="submit" value="Submit" />
</form>
<?php } ?>

<?php if(isset($_SESSION['tables']) == "venues" && isset($_SESSION["role"]) == 1)  { ?>
<title>Insert New Venue</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p><a href="javascript:history.back()">Go Back</a>
| <a href="logout.php">Logout</a></p>
<div>
<h1>Insert New Venue</h1>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<input type="text" name="capacity" placeholder="Capacity" required />
    <br/> <br/>
<input type="submit" name="submit" value="Submit" />
</form>
<?php } ?>

<?php if(isset($_SESSION['tables']) == "events" && (isset($_SESSION["role"]) == 1 || isset($_SESSION["role"]) == 2))  { ?>
<title>Insert New Event</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p><a href="javascript:history.back()">Go Back</a>
| <a href="logout.php">Logout</a></p>
<div>
<h1>Insert New Event</h1>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<h3>Date Start</h3>
<input type="datetime-local" name="datestart" placeholder="Date Start" required />
    <br/> <br/>
<h3>Date End</h3>
 <input type="datetime-local" name="dateend" placeholder="Date End" required />
 <input type="text" name="numberallowed" placeholder="Number Allowed" required />
 <input type="text" name="venue" placeholder="Venue" required />
<input type="submit" name="submit" value="Submit" />
</form>
<?php } ?>

<?php if(isset($_SESSION['tables']) == "sessions" && (isset($_SESSION["role"]) == 1 || isset($_SESSION["role"]) == 2))  { ?>
<title>Insert New Session</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p><a href="javascript:history.back()">Go Back</a>
| <a href="logout.php">Logout</a></p>
<div>
<h1>Insert New Session</h1>
<form name="registration" method="POST">
<input type="text" name="name" placeholder="Name" required />
<input type="text" name="numberallowed" placeholder="Number Allowed" required />
    <br/> <br/>
 <input type="text" name="event" placeholder="Event" required />
 <h3>Start Date</h3>
 <input type="datetime-local" name="startdate" placeholder="Start Date" required />
 <h3>End Date</h3>
 <input type="datetime-local" name="enddate" placeholder="End Date" required />
<input type="submit" name="submit" value="Submit" />
</form>
<?php } ?>

</div>
</div>
</body>
</html>