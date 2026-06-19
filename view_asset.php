```php
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

$result = mysqli_query($conn,"
    SELECT * FROM assets
    WHERE id='$id'
");

if(mysqli_num_rows($result) == 0){
    header("Location: assets.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>

<title>View Asset</title>

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

.header h1{
    font-size:32px;
}

.back-btn{
    background:#005612;
    color:white;
    text-decoration:none;
    padding:10px 15px;
    border-radius:8px;
}

.asset-card{
    background:white;
    padding:25px;
    border-radius:15px;
}

.asset-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:15px;
}

.info-box{
    border:1px solid #ddd;
    border-radius:10px;
    padding:12px;
}

.label{
    font-size:13px;
    color:#666;
    margin-bottom:5px;
}

.value{
    font-size:16px;
    font-weight:bold;
}

.full-width{
    grid-column:1 / 3;
}

.status{
    display:inline-block;
    padding:6px 15px;
    border-radius:20px;
    font-weight:bold;
}

.alive{
    background:#d4f8d4;
    color:green;
}

.sold{
    background:#fff0b8;
    color:#8f6b00;
}

.dead{
    background:#ffd4d4;
    color:red;
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

            <h1>Asset Details</h1>

            <a href="assets.php" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>

        </div>

        <div class="asset-card">

            <div class="asset-grid">

                <div class="info-box">
                    <div class="label">Asset ID</div>
                    <div class="value"><?php echo $row['id']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Asset Date</div>
                    <div class="value"><?php echo $row['asset_date']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Entry Name</div>
                    <div class="value"><?php echo $row['entry_name']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Asset Type</div>
                    <div class="value"><?php echo $row['asset_type']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Species</div>
                    <div class="value"><?php echo $row['species']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Quantity</div>
                    <div class="value"><?php echo $row['quantity']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Status</div>

                    <div class="value">

                        <?php
                        if($row['status']=="Alive"){
                            echo "<span class='status alive'>Alive</span>";
                        }
                        elseif($row['status']=="Sold"){
                            echo "<span class='status sold'>Sold</span>";
                        }
                        else{
                            echo "<span class='status dead'>".$row['status']."</span>";
                        }
                        ?>

                    </div>

                </div>

                <div class="info-box">
                    <div class="label">Fund Cluster</div>
                    <div class="value"><?php echo $row['fund_cluster']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Property Number</div>
                    <div class="value"><?php echo $row['property_number']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Reference No.</div>
                    <div class="value"><?php echo $row['reference_no']; ?></div>
                </div>

                <div class="info-box">
                    <div class="label">Fair Value</div>
                    <div class="value">
                        ₱<?php echo number_format($row['fair_value'],2); ?>
                    </div>
                </div>

                <div class="info-box">
                    <div class="label">Selling Price</div>
                    <div class="value">
                        ₱<?php echo number_format($row['selling_price'],2); ?>
                    </div>
                </div>

                <div class="info-box full-width">
                    <div class="label">Remarks</div>
                    <div class="value">
                        <?php echo nl2br($row['remarks']); ?>
                    </div>
                </div>

                <div class="info-box full-width">
                    <div class="label">Description</div>
                    <div class="value">
                        <?php echo nl2br($row['description']); ?>
                    </div>
                </div>

                <div class="info-box full-width">
                    <div class="label">Created At</div>
                    <div class="value">
                        <?php echo $row['created_at']; ?>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>