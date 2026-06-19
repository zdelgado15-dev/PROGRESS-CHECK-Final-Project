<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);
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

$getAsset = mysqli_query($conn,"
    SELECT * FROM assets
    WHERE id='$id'
");

if(mysqli_num_rows($getAsset) == 0){
    header("Location: assets.php");
    exit();
}

$row = mysqli_fetch_assoc($getAsset);

if(isset($_POST['update_asset'])){

    $asset_date = mysqli_real_escape_string($conn,$_POST['asset_date']);
    $asset_type = mysqli_real_escape_string($conn,$_POST['asset_type']);
    $species = mysqli_real_escape_string($conn,$_POST['species']);
    $quantity = mysqli_real_escape_string($conn,$_POST['quantity']);
    $status = mysqli_real_escape_string($conn,$_POST['status']);

    $remarks = mysqli_real_escape_string($conn,$_POST['remarks']);
    $entry_name = mysqli_real_escape_string($conn,$_POST['entry_name']);
    $fund_cluster = mysqli_real_escape_string($conn,$_POST['fund_cluster']);
    $property_number = mysqli_real_escape_string($conn,$_POST['property_number']);

    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $reference_no = mysqli_real_escape_string($conn,$_POST['reference_no']);

    $fair_value = mysqli_real_escape_string($conn,$_POST['fair_value']);
    $selling_price = mysqli_real_escape_string($conn,$_POST['selling_price']);

    $update = mysqli_query($conn,"
        UPDATE assets SET

        asset_date='$asset_date',
        asset_type='$asset_type',
        species='$species',
        quantity='$quantity',
        status='$status',
        remarks='$remarks',
        entry_name='$entry_name',
        fund_cluster='$fund_cluster',
        property_number='$property_number',
        description='$description',
        reference_no='$reference_no',
        fair_value='$fair_value',
        selling_price='$selling_price'

        WHERE id='$id'
    ");

    if($update){
        echo "<script>
        alert('Asset Updated Successfully!');
        window.location='additions.php?asset_id=<?php echo $id; ?>';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Asset</title>

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

.sidebar ul li:hover{
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
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.form-box{
    background:white;
    padding:25px;
    border-radius:15px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
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
    grid-column:1 / 3;
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

.back-btn{
    background:#666;
    color:white;
    text-decoration:none;
    padding:10px 15px;
    border-radius:8px;
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

            <li>
                <a href="add_asset.php">
                    <i class="fa-solid fa-plus"></i>
                    Add Asset
                </a>
            </li>

        </ul>

    </div>

    <div class="main">

        <div class="header">

            <h1>Edit Asset</h1>

            <a href="assets.php" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>

        </div>

        <div class="form-box">

            <form method="POST">

                <div class="form-grid">

                    <div class="form-group">
                        <label>Asset Date</label>
                        <input type="date"
                               name="asset_date"
                               value="<?php echo $row['asset_date']; ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Entry Name</label>
                        <input type="text"
                               name="entry_name"
                               value="<?php echo $row['entry_name']; ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Asset Type</label>
                        <input type="text"
                               name="asset_type"
                               value="<?php echo $row['asset_type']; ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Species</label>
                        <input type="text"
                               name="species"
                               value="<?php echo $row['species']; ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number"
                               name="quantity"
                               value="<?php echo $row['quantity']; ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">

                            <option value="Alive"
                            <?php if($row['status']=="Alive") echo "selected"; ?>>
                            Alive
                            </option>

                            <option value="Sold"
                            <?php if($row['status']=="Sold") echo "selected"; ?>>
                            Sold
                            </option>

                            <option value="Dead"
                            <?php if($row['status']=="Dead") echo "selected"; ?>>
                            Dead
                            </option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Fund Cluster</label>
                        <input type="text"
                               name="fund_cluster"
                               value="<?php echo $row['fund_cluster']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Property Number</label>
                        <input type="text"
                               name="property_number"
                               value="<?php echo $row['property_number']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Reference No.</label>
                        <input type="text"
                               name="reference_no"
                               value="<?php echo $row['reference_no']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Fair Value</label>
                        <input type="number"
                               step="0.01"
                               name="fair_value"
                               value="<?php echo $row['fair_value']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Selling Price</label>
                        <input type="number"
                               step="0.01"
                               name="selling_price"
                               value="<?php echo $row['selling_price']; ?>">
                    </div>

                    <div class="form-group full-width">
                        <label>Remarks</label>
                        <textarea name="remarks"
                                  rows="3"><?php echo $row['remarks']; ?></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label>Description</label>
                        <textarea name="description"
                                  rows="4"><?php echo $row['description']; ?></textarea>
                    </div>

                </div>

                <button type="submit"
                        name="update_asset"
                        class="btn">

                    <i class="fa-solid fa-floppy-disk"></i>
                    Update Asset

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>