<?php 
session_start();

//Call the DB class
require_once "DB.class.php";

$db = new DB();

if(!isset($_SESSION['tables'])) {
    echo $db->deleteUsers();
}

if(isset($_SESSION['tables']) == "users") {
    echo $db->deleteUsers();
}

if(isset($_SESSION['tables']) == "venues") {
    echo $db->deleteVenues();
}

if(isset($_SESSION['tables']) == "events") {
    echo $db->deleteEvents();
}

if(isset($_SESSION['tables']) == "sessions") {
    echo $db->deleteSessions();
}

if(isset($_SESSION['tables']) == "attendees") {
    echo $db->deleteUsers();
}

?>