<?php

session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}

if($_SESSION['role'] != "Administrator"){

    echo "<script>
    alert('Access Denied!');
    window.location='transactions.php';
    </script>";

    exit();
}

$id = intval($_GET['id']);
$source = $_GET['source'];

if($source == "asset"){

    $sql = "DELETE FROM assets WHERE id='$id'";

}elseif($source == "addition"){

    $sql = "DELETE FROM additions WHERE id='$id'";

}elseif($source == "reduction"){

    $sql = "DELETE FROM reductions WHERE id='$id'";

}else{

    die("Invalid Source");
}

mysqli_query($conn,$sql);

echo "<script>
alert('Transaction Deleted Successfully!');
window.location='transactions.php';
</script>";

?>