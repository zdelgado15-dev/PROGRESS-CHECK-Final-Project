<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "bap_db"
);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

?>