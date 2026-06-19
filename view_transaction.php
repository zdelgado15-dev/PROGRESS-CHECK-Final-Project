<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$source = isset($_GET['source']) ? $_GET['source'] : '';

if($source == "asset"){

    $sql = "SELECT * FROM assets WHERE id='$id'";

}elseif($source == "addition"){

    $sql = "SELECT ad.*, a.asset_type, a.species
            FROM additions ad
            INNER JOIN assets a ON ad.asset_id = a.id
            WHERE ad.id='$id'";

}elseif($source == "reduction"){

    $sql = "SELECT r.*, a.asset_type, a.species
            FROM reductions r
            INNER JOIN assets a ON r.asset_id = a.id
            WHERE r.id='$id'";

}else{
    die("Invalid Transaction Source");
}

$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

if(!$row){
    die("Transaction not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>View Transaction</title>

<style>

body{
    font-family:Arial;
    background:#f3f3f3;
    padding:30px;
}

.box{
    background:white;
    max-width:700px;
    margin:auto;
    padding:25px;
    border-radius:10px;
}

h2{
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

.back{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    background:#005612;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

</style>

</head>
<body>

<div class="box">

<h2>Transaction Details</h2>

<table>

<?php foreach($row as $key => $value){ ?>

<tr>
<td><strong><?php echo ucfirst(str_replace("_"," ",$key)); ?></strong></td>
<td><?php echo $value; ?></td>
</tr>

<?php } ?>

</table>

<a href="transactions.php" class="back">Back</a>

</div>

</body>
</html>