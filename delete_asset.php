<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location: index.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: assets.php");
    exit();
}

$id = intval($_GET['id']);

$check = mysqli_query($conn,"
    SELECT id
    FROM assets
    WHERE id='$id'
");

if(mysqli_num_rows($check) == 0){

    echo "<script>
    alert('Asset not found!');
    window.location='assets.php';
    </script>";

    exit();
}

$delete = mysqli_query($conn,"
    DELETE FROM assets
    WHERE id='$id'
");

if($delete){

    echo "<script>
    alert('Asset deleted successfully!');
    window.location='assets.php';
    </script>";

}else{

    echo "<script>
    alert('Unable to delete asset!');
    window.location='assets.php';
    </script>";

}
?>