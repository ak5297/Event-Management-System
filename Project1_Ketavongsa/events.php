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
    <title>Events Page</title>
    <link rel="stylesheet" href="css/style.css" />
    <h3>Events Page</h3>
</body>
<a href="javascript:history.back()">Go Back</a>
| <a href="logout.php">Logout</a><br><br>
</html>


<?php
        
    echo $db->getAllEventsAsTable();

?>

