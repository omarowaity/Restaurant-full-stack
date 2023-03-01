<?php
function connect(){
    $db = new mysqli("localhost","root","","restaurant");
    if(mysqli_connect_errno()){
        die("can't connect to database");
    }
    return $db;
}
?>