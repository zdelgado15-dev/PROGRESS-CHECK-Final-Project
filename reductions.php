<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location: index.php");
    exit();
}

if(!isset($_GET['asset_id'])){
    header("Location: assets.php");
    exit();
}

$asset_id = intval($_GET['asset_id']);
if(isset($_POST['save_reductions'])){

    $reduction_type = mysqli_real_escape_string(
        $conn,
        $_POST['reduction_type']
    );

    $qty = mysqli_real_escape_string(
        $conn,
        $_POST['qty']
    );

    $reduction_date = mysqli_real_escape_string(
        $conn,
        $_POST['reduction_date']
    );

    $reference_no = mysqli_real_escape_string(
        $conn,
        $_POST['reference_no']
    );

    $unit_cost = mysqli_real_escape_string(
        $conn,
        $_POST['unit_cost']
    );

    $amount = mysqli_real_escape_string(
        $conn,
        $_POST['amount']
    );

   $insert = mysqli_query($conn,"
INSERT INTO reductions(
    asset_id,
    reduction_type,
    qty,
    reduction_date,
    reference_no,
    unit_cost,
    amount
)
VALUES(
    '$asset_id',
    '$reduction_type',
    '$qty',
    '$reduction_date',
    '$reference_no',
    '$unit_cost',
    '$amount'
)
");

if($insert){

    mysqli_query($conn,"
    UPDATE assets
    SET quantity = quantity - $qty
    WHERE id='$asset_id'
    ");

    if($reduction_type=="Death"){

        mysqli_query($conn,"
        UPDATE assets
        SET status='Dead'
        WHERE id='$asset_id'
        ");

    }
    elseif($reduction_type=="Sale"){

        mysqli_query($conn,"
        UPDATE assets
        SET status='Sold'
        WHERE id='$asset_id'
        ");

    }

    header("Location: reductions.php?asset_id=".$asset_id);
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

<title>Reductions</title>

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
    display:flex;
    flex-direction:column;
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
    flex:1;
}

.sidebar ul li{
    padding:12px;
    margin-bottom:8px;
    border-radius:10px;
}

.sidebar ul li.active,
.sidebar ul li:hover{
    background:#227d33;
}

.sidebar ul li a{
    color:white;
    text-decoration:none;
    display:flex;
    align-items:center;
    gap:10px;
}

.logout{
    margin-top:auto;
}

.logout a{
    color:white;
    text-decoration:none;
    display:flex;
    gap:10px;
    align-items:center;
}

.main{
    flex:1;
    padding:35px;
}
.page-header{
    margin-bottom:25px;
}

.page-header h1{
    margin-bottom:15px;
}

.back-link{
    text-decoration:none;
    color:#333;
}

.back-link:hover{
    color:#28a745;
}
.form-box{
    background:white;
    padding:35px;
    border-radius:20px;
}
.tabs{
    display:flex;
    gap:15px;
    margin-top:30px;
    margin-bottom:40px;
}

.tab{
    flex:1;
    text-align:center;
    text-decoration:none;
    padding:16px;
    border:1px solid #999;
    border-radius:10px;
    background:#f5f5f5;
    color:#333;
}

.tab.active{
    background:#25c425;
    color:white;
    border-color:#25c425;
}
.column-labels{
    display:grid;
    grid-template-columns:
        140px
        repeat(5,1fr)
        60px;

    gap:15px;
    margin-bottom:15px;
    font-weight:bold;
}

.reduction-row{
    display:grid;
    grid-template-columns:
        140px
        repeat(5,1fr)
        60px;

    gap:15px;
    align-items:center;
    margin-bottom:40px;
}

.row-title{
    font-size:18px;
    font-weight:bold;
}

.reduction-row input{
    padding:12px;
    border:1px solid #999;
    border-radius:10px;
}
.plus-btn{
    width:50px;
    height:50px;
    border:1px solid #999;
    border-radius:10px;
    background:white;
    font-size:30px;
    cursor:pointer;
}

.plus-btn:hover{
    background:#25c425;
    color:white;
}

.bottom-buttons{
    display:flex;
    justify-content:flex-end;
    gap:20px;
    margin-top:60px;
}

.previous-btn{
    background:white;
    border:1px solid #999;
    padding:13px 35px;
    border-radius:10px;
    text-decoration:none;
    color:#333;
}

.save-btn{
    background:#25c425;
    color:white;
    border:none;
    padding:13px 45px;
    border-radius:10px;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
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
                    Add Assets
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

        <div class="logout">

            <a href="logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                Logout

            </a>

        </div>

    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="page-header">

            <h1>
                Add Asset - Reductions Tab
            </h1>

            <a
                href="additions.php?asset_id=<?php echo $asset_id; ?>"
                class="back-link">

                <i class="fa-solid fa-arrow-left"></i>
                Back

            </a>

        </div>

        <div class="form-box">

            <h2>
                Biological Asset Property Card
            </h2>

            <!-- TABS -->

            <div class="tabs">

                <a
                    href="edit_asset.php?id=<?php echo $asset_id; ?>"
                    class="tab">

                    1. General Info

                </a>

                <a
                    href="additions.php?asset_id=<?php echo $asset_id; ?>"
                    class="tab">

                    2. Additions

                </a>

                <a
                    href="reductions.php?asset_id=<?php echo $asset_id; ?>"
                    class="tab active">

                    3. Reductions

                </a>

            </div>

            <!-- COLUMN LABELS -->

            <div class="column-labels">

                <div></div>

                <span>Qty.</span>
                <span>Date</span>
                <span>Reference</span>
                <span>Unit Cost</span>
                <span>Amount</span>
                <span></span>

            </div>

            <?php
            $types = ["Sale","Death","Transfer Out"];

            foreach($types as $type){
            ?>

            <form method="POST">

                <div class="reduction-row">

                    <div class="row-title">

                        <?php echo $type; ?>

                    </div>

                    <input
                        type="hidden"
                        name="reduction_type"
                        value="<?php echo $type; ?>">

                    <input
                        type="number"
                        name="qty"
                        placeholder="--">

                    <input
                        type="date"
                        name="reduction_date">

                    <input
                        type="text"
                        name="reference_no"
                        placeholder="--">

                    <input
                        type="number"
                        step="0.01"
                        name="unit_cost"
                        placeholder="--">

                    <input
                        type="number"
                        step="0.01"
                        name="amount"
                        placeholder="--">

                    <button
                        type="submit"
                        name="save_reductions"
                        class="plus-btn">

                        +

                    </button>

                </div>

            </form>

            <?php } ?>

<div class="bottom-buttons">

    <a
        href="additions.php?asset_id=<?php echo $asset_id; ?>"
        class="previous-btn">

        Previous

    </a>

    <a
        href="assets.php"
        class="save-btn">

        Finish

    </a>

</div>

            </div>

        </div>

    </div>

</div>

</body>
</html>