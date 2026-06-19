<?php

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}

function isAdmin(){
    return isset($_SESSION['role']) &&
           $_SESSION['role'] == 'Admin';
}

function isStaff(){
    return $_SESSION['role'] == 'Staff';
}

?>