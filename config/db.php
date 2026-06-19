<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "bap_db"
);


if(!$conn){
    die("Database Connection Failed");
}

?>