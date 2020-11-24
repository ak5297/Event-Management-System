<?php

class DB {

    private $con;

    function __construct()
    {

        $this->con = new mysqli($_SERVER['DB_SERVER'],$_SERVER['DB_USER'],
                        $_SERVER['DB_PASSWORD'],$_SERVER['DB']);

        if($this->con->connect_errno) {
            echo "connect failed ".mysqli_connect_error();
            die();
        }
    } // constructor
    
    function validateRegistration() {
    // If form submitted, insert values into the database.
        if (count($_POST) > 0) {
			$name = $_POST['name'];
			$password = $_POST['password'];
			$role = $_POST['role'];
        }
        
        //Prepare the insert statement
        $query = "INSERT INTO attendee (name, password, role) VALUES (?, ?, ?)";
        
        //Professor French said it was ok to use this hashing algorithm instead of SHA256
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        $numRows = 0;
        
        if ($stmt = $this->con->prepare($query)) {
            $stmt->bind_param("ssi",$name,$hashedpassword,$role);
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;
        }
                         
        if($numRows == 1){
            echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
        }
        
        else {
            echo "<div class='form'><h3>There was an error registering the account. Please try again.</h3>";
        }
    
    }

    
function validateLogin() {
    
     if (count($_POST) > 0) {
            session_start();
			$username = $_POST['username'];
			$password = $_POST['password'];
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
        }
        		
       //Checking is user existing in the database or not
        $query = "SELECT idattendee, name, password, role FROM attendee WHERE name = ?";
        $numRows = 0;
        $data = [];
    

        if ($stmt = $this->con->prepare($query)) {
            $stmt->bind_param("s",$username);
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;
            $stmt->bind_result($id,$username,$hashedpassword,$role);
            
            if($stmt-> num_rows > 0) {
                while($stmt->fetch()) {
                    $data[] = array(
                    'username'=>$username,
                    'password'=>$hashedpassword,
                    'role'=>$role
                    );
                }
            }    
        }
    
    //get role id and store in a session
    $_SESSION['role'] = $role;
    
        //check if the user's entered password matches the encrypted password in the DB, or matches unencrypted admin password
        if(password_verify($password, $hashedpassword) || $password == $hashedpassword) {
            if($numRows==1){
                switch ($role) {
                case '1':
                    $redirect = 'admin.php';
                    break;
                case '2':
                    $redirect = 'admin.php';
                    break;
                case '3':
                    $redirect = 'registrations.php';
                    break;
                }

                header('Location: ' . $redirect);

                }//numRows
        }//check if encrypted password matches

        
        else {
            echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Please try again.</div>";
        }

}
    
    function getAllUsers() { 
        $data = []; 
        //or array();
        if ($stmt=$this->con->prepare("SELECT * FROM attendee")) {

            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($id,$name,$password,$role);
            
            if ($stmt->num_rows > 0) {

                while($stmt->fetch()) {
                    $data[] = array(
                        'id'=>$id,
                        'name'=>$name,
                        'password'=>$password,
                        'role'=>$role
                    );
                }
                
            } // have rows returned

        } // if stmt
        echo "<div class='tableDiv'><b>Records found: ", count($data), "</b></div>";
        return $data;
        
    } // getAllUsers

    function getAllUsersAsTable() {
        $data = $this->getAllUsers();
        if (count($data) > 0) {
            $bigString = "<table border='1' \n
                        <tr><th>ID</th><th>Name</th><th>Password</th><th>Role</th><th>Update</th><th>Delete</th></tr>\n";

            foreach ($data as $row) {
                $bigString .= "<tr>
                                <td><a href='form.php?id={$row['id']}'>{$row['id']}</a></td>
                                <td>{$row['name']}</td><td>{$row['password']}</td><td>{$row['role']}</td>
                                <td><a href='update.php?id={$row['id']}'>Update</a></td><td><a href='delete.php?id={$row['id']}'>Delete</a></td>
                                </tr>\n";
            }

            $bigString .= "</table>\n";

        } else {
            $bigString = "<h2>No users exist.</h2>";
        }

        return $bigString;

    } // getAllUsersAsTable
    

    function getAllVenues() {
        $data = []; 
        //or array();
        if ($stmt=$this->con->prepare("SELECT * FROM venue")) {

            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($id,$name,$capacity);
            
            if ($stmt->num_rows > 0) {

                while($stmt->fetch()) {
                    $data[] = array(
                        'id'=>$id,
                        'name'=>$name,
                        'capacity'=>$capacity
                    );
                }
                
            } // have rows returned

        } // if stmt
        echo "<div class='tableDiv'><b>Records found: ", count($data), "</b></div>";
        return $data;
        
    } // getAllVenues

    function getAllVenuesAsTable() {

        $data = $this->getAllVenues();
        if (count($data) > 0) {

            $bigString = "<table border='1' \n
                        <tr><th>ID</th><th>Name</th><th>Capacity</th><th>Update</th><th>Delete</th></tr>\n";

            foreach ($data as $row) {
                $bigString .= "<tr>
                                <td><a href='form.php?id={$row['id']}'>{$row['id']}</a></td>
                                <td>{$row['name']}</td><td>{$row['capacity']}</td>
                                <td><a href='update.php?id={$row['id']}'>Update</a></td><td><a href='delete.php?id={$row['id']}'>Delete</a></td>
                                </tr>\n";
            }

            $bigString .= "</table>\n";

        } else {
            $bigString = "<h2>No venues exist.</h2>";
        }

        return $bigString;

    } // getAllVenuesAsTable
    
    function getAllEvents() {
        $data = []; 
        //or array();
        if ($stmt=$this->con->prepare("SELECT * FROM event")) {

            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($id,$name,$datestart,$dateend,$numberallowed,$venue);
            
            if ($stmt->num_rows > 0) {

                while($stmt->fetch()) {
                    $data[] = array(
                        'id'=>$id,
                        'name'=>$name,
                        'datestart'=>$datestart,
                        'dateend'=>$dateend,
                        'numberallowed'=>$numberallowed,
                        'venue'=>$venue
                    );
                }
                
            } // have rows returned

        } // if stmt
        echo "<div class='tableDiv'><b>Records found: ", count($data), "</b></div>";
        return $data;
        
    } // getAllEvents

    function getAllEventsAsTable() {

        $data = $this->getAllEvents();
        if (count($data) > 0) {
            $bigString = "<table border='1' \n
                        <tr><th>ID</th><th>Name</th><th>Date Start</th><th>Date End</th><th>Number Allowed</th><th>Venue</th><th>Update</th><th>Delete</th></tr>\n";

            foreach ($data as $row) {
                $bigString .= "<tr>
                                <td><a href='form.php?id={$row['id']}'>{$row['id']}</a></td>
                                <td>{$row['name']}</td><td>{$row['datestart']}</td><td>{$row['dateend']}</td><td>{$row['numberallowed']}</td><td>{$row['venue']}</td>
                                <td><a href='update.php?id={$row['id']}'>Update</a></td><td><a href='delete.php?id={$row['id']}'>Delete</a></td>
                                </tr>\n";
            }

            $bigString .= "</table>\n";

    } else {
            $bigString = "<h2>No events exist.</h2>";
        }

        return $bigString;

    } // getAllEventsAsTable

    // function getAllAdminEvents($id){
    //     try {
    //         $data = [];
    //         $stmtGetId = $this->con->prepare("select idattendee FROM attendee where name = ? and role = 2");
    //         $stmtGetEvents = $this->con->prepare("select * FROM events where idevent = ?);

    //         $stmt->bind_result("s", $username);
    //         $stmt->execute();
    //         $stmt->store_result();

    //         $stmt->bind_result($idevent,$eventname,$datestart,$dateend,$numberallowed,$venuename);
            
    //         if ($stmt->num_rows > 0) {

    //             while($stmt->fetch()) {
    //                 $data[] = array(
    //                     'idevent'=>$idevent,
    //                     'name'=>$eventname,
    //                     'datestart'=>$datestart,
    //                     'dateend'=>$dateend,
    //                     'numberallowed'=>$numberallowed,
    //                     'venue'=>$venuename
    //                 );
    //             }
                
    //         } // have rows returned

    //         echo "<div class='tableDiv'><b>Records found: ", count($data), "</b></div>";
    //         return $data;
    //     } // try stmt

    //     catch(Exception $e){
    //         echo $e->getMessage();
    //         return -1;
    //     }//catch
    // }//getAllAdminEvents

    // function getAllAdminEventsAsTable($id) {

    //     $data = $this->getAllAdminEvents($id);
    //     if (count($data) > 0) {

    //         $bigString = "<table border='1' \n
    //                     <tr><th>ID</th><th>Name</th><th>Date Start</th><th>Date End</th><th>Number Allowed</th><th>Venue</th></tr>\n";

    //         foreach ($data as $row) {
    //             $bigString .= "<tr>
    //                             <td><a href='form.php?id={$row['id']}'>{$row['id']}</a></td>
    //                             <td>{$row['name']}</td><td>{$row['datestart']}</td><td>{$row['dateend']}</td><td>{$row['numberallowed']}</td><td>{$row['venue']}</td>
    //                             </tr>\n";
    //         }

    //         $bigString .= "</table>\n";

    //     } else {
    //         $bigString = "<h2>No events exist.</h2>";
    //     }

    //     return $bigString;

    // } // getAllEventsAsTable
    
     function getAllSessions() {
        $data = []; 
        //or array();
        if ($stmt=$this->con->prepare("SELECT * FROM session")) {

            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($id,$name,$numberallowed,$event,$startdate,$enddate);
            
            if ($stmt->num_rows > 0) {

                while($stmt->fetch()) {
                    $data[] = array(
                        'id'=>$id,
                        'name'=>$name,
                        'numberallowed'=>$numberallowed,
                        'event'=>$event,
                        'startdate'=>$startdate,
                        'enddate'=>$enddate
                    );
                }
                
            } // have rows returned

        } // if stmt
        echo "<div class='tableDiv'><b>Records found: ", count($data), "</b></div>";
        return $data;
        
    } // getAllSessions

    function getAllSessionsAsTable() {

        $data = $this->getAllSessions();
        if (count($data) > 0) {

            $bigString = "<table border='1' \n
                        <tr><th>ID</th><th>Name</th><th>Number Allowed</th><th>Event</th><th>Start Date</th><th>End Date</th><th>Update</th><th>Delete</th></tr>\n";

            foreach ($data as $row) {
                $bigString .= "<tr>
                                <td><a href='form.php?id={$row['id']}'>{$row['id']}</a></td>
                                <td>{$row['name']}</td><td>{$row['numberallowed']}</td><td>{$row['event']}</td><td>{$row['startdate']}</td><td>{$row['enddate']}</td>
                                <td><a href='update.php?id={$row['id']}'>Update</a></td><td><a href='delete.php?id={$row['id']}'>Delete</a></td>
                                </tr>\n";
            }

            $bigString .= "</table>\n";

        } else {
            $bigString = "<h2>No sessions exist.</h2>";
        }

        return $bigString;

    } // getAllSessionsAsTable
   
    function addUsers() {        
        // If form submitted, insert values into the database.
        if (count($_POST) > 0) {
			$name = $_POST['name'];
			$password = $_POST['password'];
			$role = $_POST['role'];
        }
        
        //Prepare the insert statement
        $query = "INSERT INTO attendee (name, password, role) VALUES (?, ?, ?)";
        
        //Professor French said it was ok to use this hashing algorithm instead of SHA256
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        $numRows = 0;
        
        if ($stmt = $this->con->prepare($query)) {
            $stmt->bind_param("ssi",$name,$hashedpassword,$role);
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;
        }    

        if($numRows == 1){
            echo "<div class='form'><h3>New record created.</div>";
        }
        else {
            echo "<div class='form'><h3>Record could not be created.</div>";
        }
    }
    
    //INSERT to add fields
    function addVenues() {
           // If form submitted, insert values into the database.
           if (count($_POST) > 0) {
			$name = $_POST['name'];
			$capacity = $_POST['capacity'];
        }
        
        //Prepare the insert statement
        $query = "INSERT INTO venue (name, capacity) VALUES (?, ?)";
        
        $numRows = 0;
        
        if ($stmt = $this->con->prepare($query)) {
            $stmt->bind_param("si",$name,$capacity);
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;
        }    

        if($numRows == 1){
            echo "<div class='form'><h3>New record created.</div>";
        }
        else {
            echo "<div class='form'><h3>Record could not be created.</div>";
        }
    }

    function addEvents() {
                   // If form submitted, insert values into the database.
                   if (count($_POST) > 0) {
                    $name = $_POST['name'];
                    $datestart = date("Y-m-d H:i:s", strtotime($_POST['datestart']));
                    $dateend = date("Y-m-d H:i:s", strtotime($_POST['dateend']));
                    $numberallowed = $_POST['numberallowed'];
                    $venue = $_POST['venue'];

                    
                }
                
                //Prepare the insert statement
                $query = "INSERT INTO event (name, datestart, dateend, numberallowed, venue) VALUES (?, ?, ?, ?, ?)";
                
                $numRows = 0;
                
                if ($stmt = $this->con->prepare($query)) {
                    $stmt->bind_param("sssii",$name,$datestart,$dateend,$numberallowed,$venue);
                    $stmt->execute();
                    $stmt->store_result();
                    $numRows = $stmt->affected_rows;
                }    
        
                if($numRows == 1){
                    echo "<div class='form'><h3>New record created.</div>";
                }
                else {
                    echo "<div class='form'><h3>Record could not be created.</div>";
                }
    }

    function addSessions() {

                          // If form submitted, insert values into the database.
                          if (count($_POST) > 0) {
                            $name = $_POST['name'];
                            $numberallowed = $_POST['numberallowed'];
                            $event = $_POST['event'];
                            $datestart = date("Y-m-d H:i:s", strtotime($_POST['startdate']));
                            $dateend = date("Y-m-d H:i:s", strtotime($_POST['enddate']));
                        }
                        
                        //Prepare the insert statement
                        $query = "INSERT INTO session (name, numberallowed, event, startdate, enddate) VALUES (?, ?, ?, ?, ?)";
                        
                        $numRows = 0;
                        
                        if ($stmt = $this->con->prepare($query)) {
                            $stmt->bind_param("siiss",$name,$numberallowed,$event,$datestart,$dateend);
                            $stmt->execute();
                            $stmt->store_result();
                            $numRows = $stmt->affected_rows;
                        }    
                
                        if($numRows == 1){
                            echo "<div class='form'><h3>New record created.</div>";
                        }
                        else {
                            echo "<div class='form'><h3>Record could not be created.</div>";
                        }
    }

    //UPDATE to edit fields
   function updateUser($fields) {
       $query = "update attendee set ";
       $updateId = 0;
       $numRows = 0;
       $items = [];
       $types = "";
       
       foreach($fields as $k => $v) {
           switch($k) {
                   case 'name':
                    $query .= "name = ?,";
                    $items[] = &$fields[$k];
                    $types .= "s";
                   break;
                   case 'password':
                    $query .= "password = ?,";
                    $items[] = &$fields[$k];
                    $types .= "s";
                   break;
                   case 'role':
                    $updateId = intval($v);
                   break;
           }//switch
       }//foreach
       $query = trim($query,",");
       $query .= "where id = ?";
       $types .= "i";
       $items[] = &$updateId;

       if($stmt = $this->con->prepare($query)) {
           $refArray = array_merge(array($types),$items);
           $ref = new ReflectionClass('mysqli_stmt');
           $method = $ref->getMethod('bind_param');
           $method->invokeArgs($stmt,$refArray);
           
           $stmt->execute();
           $stmt->store_result();
           $numRows = $stmt->affected_rows;


       }//if statement

       return $numRows;
   }//update

    
    //DELETE to remove fields

    function deleteUsers() {
        $id = $_GET['id'];
        $query = "delete from attendee where idattendee = ?";
        $numRows = 0;

        if($stmt = $this->con->prepare($query)) {
            $stmt->bind_param("i", intval($id));
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;

        }//end if

        if($numRows = 1) {
            echo 'Record  '.$id.'  deleted successfully.';
            echo "\n\n<a href='admin.php?tables=attendees'>OK, go back</a></body></html>";
        } else {
            echo 'Could not delete the record.';
        }
    }//end deleteUsers

    function deleteVenues() {
        $id = $_GET['id'];
        $query = "delete from venue where idvenue = ?";
        $numRows = 0;

        if($stmt = $this->con->prepare($query)) {
            $stmt->bind_param("i", intval($id));
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;

        }//end if

        if($numRows = 1) {
            echo 'Record  '.$id.'  deleted successfully.';
            echo "\n\n<a href='admin.php?tables=venues'>OK, go back</a></body></html>";
        } else {
            echo 'Could not delete the record.';
        }
    }//end deleteVenues

    function deleteEvents() {
        $id = $_GET['id'];
        $query = "delete from event where idevent = ?";
        $numRows = 0;

        if($stmt = $this->con->prepare($query)) {
            $stmt->bind_param("i", intval($id));
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;

        }//end if

        if($numRows = 1) {
            echo 'Record  '.$id.'  deleted successfully.';
            echo "\n\n<a href='admin.php?tables=events'>OK, go back</a></body></html>";
        } else {
            echo 'Could not delete the record.';
        }
    }//end deleteEvents

    function deleteSessions() {
        $id = $_GET['id'];
        $query = "delete from session where idsession = ?";
        $numRows = 0;

        if($stmt = $this->con->prepare($query)) {
            $stmt->bind_param("i", intval($id));
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;

        }//end if

        if($numRows = 1) {
            echo 'Record  '.$id.'  deleted successfully.';
            echo "<a href='admin.php?tables=sessions'>\n\nOK, go back</a></body></html>";
        } else {
            echo 'Could not delete the record.';
        }
    }//end deleteSessions

} // Class