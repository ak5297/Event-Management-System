<?php
    //Call the DB class
    require_once "DB.class.php";
    
    $db = new DB();
    
    //Create a new session
    session_start();

    //At the top of the page check to see whether the user is logged in or not
    if(empty($_SESSION['username'])) {
        
        // If they are not, redirect them to the login page.
        echo("<!DOCTYPE html><html lang=\"en\"><title>ERROR!</title><body>ERROR: You must be logged in to view this page.<br><br>");
        echo("Click here to <a href='login.php'>Login</a></body></html>");

        die();
    }
    
    echo 'Hi, ' . $_SESSION["username"] .'';

?>
<html>
<body>
    <title>Registrations Page</title>
    <h3>Registrations Page</h3>
    <link rel="stylesheet" href="css/style.css" />
    <form>
<label for="tables"> Select a table to view:</label>
<select name="tables" onchange="this.form.submit()">
  <option value="events"<?php if(isset($_GET['tables']) && $_GET['tables'] == "events"){echo "selected='selected'"; } ?>>Events</option>
  <option value="sessions"<?php if(isset($_GET['tables']) && $_GET['tables'] == "sessions"){echo "selected='selected'"; } ?>>Sessions</option>
</select>
    <br><br>
</form>
</body>
<a href="javascript:history.back()">Go Back</a>
| <a href="logout.php">Logout</a><br><br>
</html>

<?php

    //if select table wasn't picked yet, display the default - events table
    if(!isset($_GET["tables"])){
         echo $db->getAllEventsAsTable();
    }

    if(isset($_GET["tables"])){
           $tables=$_GET["tables"];

      if($tables == "events") {
            echo $db->getAllEventsAsTable();
        } 
    if($tables == "sessions") {
            echo $db->getAllSessionsAsTable();
        } 
    }

?>
