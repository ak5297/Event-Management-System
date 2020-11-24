<?php
    //Create a new session
    session_start();
    
    //Call the DB class
    require_once "DB.class.php";
    
    $db = new DB();

    //At the top of the page check to see whether the user is logged in or not
    if(empty($_SESSION['username'])) {
        
        // If they are not, redirect them to the login page.
        echo("<!DOCTYPE html><html lang=\"en\"><title>ERROR!</title><body>ERROR: You must be logged in to view this page.<br><br>");
        echo("Click here to <a href='login.php'>Login</a></body></html>");

        die();
    }
    
    // echo "<div class='tableDiv'>";
    echo 'Hi, ' . $_SESSION["username"] .'';
    // echo "</div>";
?>

<html>
<body>
    <title>Admin Page</title>
    <h3>Admin Page</h3>
    <link rel="stylesheet" href="css/style.css" />
    <br>
    <!-- <div class="tableDiv"> -->
        <a href="admin.php">Admin</a> | <a href="events.php">Events</a> | <a href="registrations.php">Registrations</a> | <a href="logout.php">Logout</a>
        <br><br>
        <a href="insert.php">Insert New Record</a> 
    <!-- </div> -->
    <form>
        
 <?php if($_SESSION["role"] == 1) { ?>   

<label for="tables"> <br/><br/> Select a table:</label>
<select name="tables" onchange="this.form.submit()">
  <option value="users" <?php if(isset($_GET['tables']) && $_GET['tables'] == "users"){echo "selected='selected'"; $_SESSION['tables'] = "users"; } ?>>Users</option>
  <option value="venues"<?php if(isset($_GET['tables']) && $_GET['tables'] == "venues"){echo "selected='selected'"; $_SESSION['tables'] = "venues"; } ?>>Venues</option>
  <option value="events"<?php if(isset($_GET['tables']) && $_GET['tables'] == "events"){echo "selected='selected'"; $_SESSION['tables'] = "events"; } ?>>Events</option>
  <option value="sessions"<?php if(isset($_GET['tables']) && $_GET['tables'] == "sessions"){echo "selected='selected'"; $_SESSION['tables'] = "sessions";} ?>>Sessions</option>
  <option value="attendees"<?php if(isset($_GET['tables']) && $_GET['tables'] == "attendees"){echo "selected='selected'"; $_SESSION['tables'] = "attendees"; } ?>>Attendees</option>
</select>
<?php 

} ?>
        
 <?php if($_SESSION["role"] == 2) { ?>   
<label for="tables"> <br/><br/> Select a table:</label>
<select name="tables" onchange="this.form.submit()">
  <option value="events" selected="selected"<?php if(isset($_GET['tables']) && $_GET['tables'] == "events"){echo "selected='selected'"; $_SESSION['tables'] = "events";} ?>>Events</option>
  <option value="sessions"<?php if(isset($_GET['tables']) && $_GET['tables'] == "sessions"){echo "selected='selected'"; $_SESSION['tables'] = "sessions";} ?>>Sessions</option>
  <option value="attendees"<?php if(isset($_GET['tables']) && $_GET['tables'] == "attendees"){echo "selected='selected'"; $_SESSION['tables'] = "attendees";} ?>>Attendees</option>
</select>
<?php } ?>
        <br/><br/>

</form>    
<br/>
</body>
</html>

<?php
    
    //if admin role logged in, display everything
    if($_SESSION["role"] == 1) {
    //if select table wasn't picked yet, display the default - users table
    if(!isset($_GET["tables"])){
         echo $db->getAllUsersAsTable();
    }
    if(isset($_GET["tables"])){
           $tables=$_GET["tables"];

     if($tables == "users") {
            echo $db->getAllUsersAsTable();
        }   
    if($tables == "venues") {
            echo $db->getAllVenuesAsTable();
        } 
      if($tables == "events") {
            echo $db->getAllEventsAsTable();
        } 
    if($tables == "sessions") {
            echo $db->getAllSessionsAsTable();
        } 
     if($tables == "attendees") {
            echo $db->getAllUsersAsTable();
        } 
   } 
} 
//event manager role - display only their own events/sessions
if($_SESSION["role"] == 2) {
        //if select table wasn't picked yet, display the default - users table
        if(!isset($_GET["tables"])){
            //echo $db->getAllEventsAsTable();
            echo $db-> getAllEventsAsTable();
       }
       if(isset($_GET["tables"])){
        $tables=$_GET["tables"];

        if($tables == "events") {
            echo $db-> getAllEventsAsTable();
        } 
    if($tables == "sessions") {
            echo $db->getAllSessionsAsTable();
        } 
     if($tables == "attendees") {
            echo $db->getAllUsersAsTable();
        } 
       }
}
?>
