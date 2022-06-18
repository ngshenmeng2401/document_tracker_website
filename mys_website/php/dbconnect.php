<?php
$servername = "localhost";
$username = "hubbuddi_mystrackeradmin";
$password = "H+-TDtUjS!{i";
$dbname = "hubbuddi_mystrackerdb";

$con = new mysqli($servername,$username,$password,$dbname);
if($con->connect_error){
    die("Connection failed: " . $con->connect_error);
}
?>