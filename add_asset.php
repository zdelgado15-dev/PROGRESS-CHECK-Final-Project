<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['add_asset'])){

    $asset_date = mysqli_real_escape_string($conn,$_POST['asset_date']);
    $asset_type = mysqli_real_escape_string($conn,$_POST['asset_type']);
    $species = mysqli_real_escape_string($conn,$_POST['species']);
    $quantity = mysqli_real_escape_string($conn,$_POST['quantity']);

    $remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
    $entry_name = mysqli_real_escape_string($conn,$_POST['entry_name']);
    $fund_cluster = mysqli_real_escape_string($conn,$_POST['fund_cluster']);
    $property_number = mysqli_real_escape_string($conn,$_POST['property_number']);

    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $reference_no = mysqli_real_escape_string($conn,$_POST['reference_no']);

    $fair_value = mysqli_real_escape_string($conn,$_POST['fair_value']);
    $selling_price = mysqli_real_escape_string($conn,$_POST['selling_price']);

    $insert = mysqli_query($conn,"
        INSERT INTO assets(
asset_date,
asset_type,
species,
quantity,
status,
remarks,
entry_name,
fund_cluster,
property_number,
description,
reference_no,
fair_value,
selling_price
)
        VALUES(
'$asset_date',
'$asset_type',
'$species',
'$quantity',
'Alive',
'$remarks',
'$entry_name',
'$fund_cluster',
'$property_number',
'$description',
'$reference_no',
'$fair_value',
'$selling_price'
)
    ");

    if($insert){

    $asset_id = mysqli_insert_id($conn);

    echo "<script>
    alert('General Information Saved!');
    window.location='additions.php?asset_id=".$asset_id."';
    </script>";

    exit();
}
    else{
    die(mysqli_error($conn));
}
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Asset</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f3f3f3;
}

.container{
    display:flex;
    min-height:100vh;
}

.sidebar{
    width:250px;
    background:#005612;
    color:white;
    padding:20px;
}

.sidebar-logo{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:30px;
}

.sidebar-logo img{
    width:45px;
    height:45px;
}

.sidebar ul{
    list-style:none;
}

.sidebar ul li{
    padding:12px;
    margin-bottom:8px;
    border-radius:10px;
}

.sidebar ul li:hover,
.active{
    background:#227d33;
}

.sidebar ul li a{
    color:white;
    text-decoration:none;
}

.main{
    flex:1;
    padding:25px;
}

.header{
    margin-bottom:20px;
}

.header h1{
    font-size:32px;
}

.form-box{
    background:white;
    padding:25px;
    border-radius:15px;
}

.form-grid{
    display:grid;
    grid-template-columns:
        repeat(4, minmax(180px,1fr));
    gap:25px;
}

.span-2{
    grid-column:span 2;
}

.span-3{
    grid-column:span 3;
}

.span-4{
    grid-column:span 4;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    margin-bottom:5px;
    font-weight:bold;
}

.form-group input,
.form-group select,
.form-group textarea{
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
}

.full-width{
    grid-column:1/3;
}

.btn{
    background:#005612;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
    margin-top:15px;
}

.btn:hover{
    background:#0a7520;
}
.form-box{
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:
        0 5px 20px rgba(0,0,0,.08);
}

.tabs{
    display:flex;
    gap:15px;
    margin-bottom:45px;
}

.tab{
    flex:1;
    text-align:center;
    text-decoration:none;
    padding:16px;
    border:1px solid #8d9b8d;
    border-radius:10px;
    background:#f8f8f8;
    color:#333;
    transition:.3s;
}

.tab.active{
    background:#25c425;
    border-color:#20b520;
    color:white;
}

.form-group label{
    font-weight:bold;
    margin-bottom:8px;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    padding:14px;
    border:1px solid #b8b8b8;
    border-radius:10px;
    font-size:15px;
    transition:.3s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{
    outline:none;
    border-color:#25c425;
    box-shadow:
        0 0 0 3px
        rgba(37,196,37,.15);
}

.bottom-buttons{
    display:flex;
    justify-content:flex-end;
    gap:18px;
    margin-top:45px;
}

.cancel-btn{
    background:white;
    border:1px solid #999;
    padding:13px 35px;
    border-radius:10px;
    text-decoration:none;
    color:#333;
}

.next-btn{
    background:#25c425;
    color:white;
    border:none;
    padding:13px 45px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
}

.next-btn:hover{
    background:#1fa91f;
}
.back-link{
    display:inline-block;
    margin-top:15px;
    text-decoration:none;
    color:#333;
    font-size:15px;
}

.back-link:hover{
    color:#25c425;
}

</style>

</head>

<body>

<div class="container">

<div class="sidebar">

    <div class="sidebar-logo">

        <img src="assets/images/adssu_logo.png.png">

        <h2>ADSSU-BAP</h2>

    </div>


    <ul>


        <li>
            <a href="dashboard.php">

                <i class="fa-solid fa-table-columns"></i>

                Dashboard

            </a>
        </li>



        <li>
            <a href="assets.php">

                <i class="fa-solid fa-cube"></i>

                Assets

            </a>
        </li>




        <li class="active">

            <a href="add_asset.php">

                <i class="fa-solid fa-plus"></i>

                Add Asset

            </a>

        </li>





        <li>

            <a href="transactions.php">

                <i class="fa-solid fa-arrow-right-arrow-left"></i>

                Transactions

            </a>

        </li>





        <li>

            <a href="inventory.php">

                <i class="fa-solid fa-boxes-stacked"></i>

                Inventory

            </a>

        </li>





        <li>

            <a href="species.php">

                <i class="fa-solid fa-cow"></i>

                Species

            </a>

        </li>





        <li>

            <a href="reports.php">

                <i class="fa-solid fa-chart-column"></i>

                Reports

            </a>

        </li>




        <li>

            <a href="users.php">

                <i class="fa-solid fa-users"></i>

                Users

            </a>

        </li>




        <li>

            <a href="settings.php">

                <i class="fa-solid fa-gear"></i>

                Settings

            </a>

        </li>


    </ul>


</div>

    <div class="main">

        <div class="header">
            <h1>Add Asset(Biological Asset Property Card)</h1>
            <p>Create a new biological asset record</p>
        </div>

        <a href="assets.php" class="back-link">
    <i class="fa-solid fa-arrow-left"></i>
    Back
</a>

        <div class="form-box">

        <form method="POST">

            <div class="tabs">

<a href="add_asset.php" class="tab active">
1. General Info
</a>

<a href="#" class="tab">
2. Additions
</a>

<a href="#" class="tab">
3. Reductions
</a>

</div>

<div class="form-grid">

    <!-- ROW 1 -->

    <div class="form-group">
        <label>Entry Name *</label>
        <input type="text"
               name="entry_name"
               value="ADSSU"
               required>
    </div>

    <div class="form-group">
        <label>Fund Cluster *</label>
        <input type="text"
               name="fund_cluster"
               placeholder="BN/">
    </div>

    <div class="form-group span-2">
        <label>Property Number *</label>
        <input type="text"
               name="property_number"
               placeholder="BA-01-14(1-12)">
    </div>

    <!-- ROW 2 -->

    <div class="form-group">
        <label>Biological Asset Type *</label>

        <select name="species" id="species" required>

<option value="">Select Species</option>

<?php

$species_query =
mysqli_query($conn,
"SELECT DISTINCT category
 FROM species
 ORDER BY category ASC");

while($sp=mysqli_fetch_assoc($species_query)){

?>

<option value="<?php echo $sp['category']; ?>">

<?php echo $sp['category']; ?>

</option>

<?php } ?>

</select>
    </div>

    <div class="form-group span-3">
        <label>Description</label>

        <select name="description" id="description" required>

<option value="">
Select Variety
</option>

</select>
    </div>

    <!-- ROW 3 -->

    <div class="form-group">
        <label>Date *</label>

        <input type="date"
               name="asset_date"
               required>
    </div>

    <div class="form-group">
        <label>Reference</label>

        <input type="text"
               name="reference_no"
               placeholder="Purchase">
    </div>

    <div class="form-group">
        <label>Quantity *</label>

        <input type="number"
               name="quantity"
               required>
    </div>

    <div class="form-group">
        <label>Fair Value</label>

        <input type="number"
               step="0.01"
               name="fair_value">
    </div>

    <!-- ROW 4 -->

    <div></div>
    <div></div>

    <div class="form-group">
        <label>Selling Price</label>

        <input type="number"
               step="0.01"
               name="selling_price">
    </div>

    <div class="form-group">
        <label>Remarks</label>

        <textarea
            name="remarks"
            rows="2"></textarea>
    </div>

</div>

<input type="hidden"
       name="asset_type"
       value="Consumable Biological Asset">

<div class="bottom-buttons">

    <a href="assets.php"
       class="cancel-btn">

        Cancel

    </a>

    <button
        type="submit"
        name="add_asset"
        class="next-btn">

        Next

    </button>

</div>
</form>

    </div>

</div>

<script>

document.getElementById("species")
.addEventListener("change", function(){

    var category = this.value;

    var xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "get_varieties.php?category=" + category,
        true
    );

    xhr.onload = function(){

        document.getElementById(
            "description"
        ).innerHTML = this.responseText;

    };

    xhr.send();

});

</script>

</body>
</html>