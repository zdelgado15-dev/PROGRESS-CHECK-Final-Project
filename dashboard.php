<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location: index.php");
    exit();
}

/* ===========================
   DASHBOARD COUNTS
=========================== */

$totalAssets = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM assets")
)['total'];

$poultry = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM assets WHERE species='Poultry'")
)['total'];

$swine = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM assets WHERE species='Swine'")
)['total'];

$cattle = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM assets WHERE species='Cattle'")
)['total'];

$goat = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM assets WHERE species='Goat'")
)['total'];

$sheep = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM assets WHERE species='Sheep'")
)['total'];

$recentAssets = mysqli_query(
    $conn,
    "SELECT * FROM assets
     ORDER BY created_at DESC
     LIMIT 5"
);
?>

<!DOCTYPE html>
<html>
<head>

    <title>Dashboard</title>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f3f3f3;
    overflow:hidden;
}

.dashboard-container{
    display:flex;
    height:100vh;
}

/* ================= SIDEBAR ================= */

.sidebar{

    width:250px;
    background:#005612;
    color:white;
    padding:20px;

    display:flex;
    flex-direction:column;

    min-height:100vh;

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



.sidebar ul li:hover,
.sidebar ul li.active{

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

    padding:12px;

}



.logout a{

    color:white;

    text-decoration:none;

    display:flex;

    align-items:center;

    gap:10px;

}

/* ================= MAIN ================= */

.main-content{
    flex:1;
    padding:18px 22px;
    overflow:auto;
}

/* TOPBAR */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:14px;
}

.topbar h1{
    font-size:40px;
    line-height:42px;
}

.topbar span{
    font-size:15px;
    color:#666;
}

.top-icons{
    display:flex;
    align-items:center;
    gap:18px;
}

.top-icons i{
    font-size:24px;
    cursor:pointer;
}

.admin{
    display:flex;
    align-items:center;
    gap:10px;
}

.admin img{
    width:42px;
    height:42px;
    border-radius:50%;
}

.admin span{
    font-size:15px;
}

/* ================= CARDS ================= */

.cards{
    display:grid;
    grid-template-columns:repeat(6, 1fr);
    gap:12px;

    margin-bottom:14px;
}

.card{
    background:white;
    border:1px solid #d9d9d9;
    border-radius:14px;

    padding:14px;
}

.card h3{
    font-size:14px;
    margin-bottom:8px;
}

.card-flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.card-flex h1{
    font-size:34px;
}

.card-flex i,
.card-flex span{
    font-size:30px;
}

/* ================= GRID ================= */

.content-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:16px;

    margin-bottom:14px;
}

.table-box,
.inventory-box{
    background:white;
    border-radius:18px;
    padding:18px;
}

.table-box h2,
.inventory-box h2{
    font-size:24px;
    margin-bottom:14px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f5f5f5;
    font-size:14px;
}

table th,
table td{
    border:1px solid #ddd;
    padding:10px;
    text-align:left;
    font-size:13px;
}

/* STATUS */

.status{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.status.active{
    background:#c8f7d0;
    color:green;
}

.status.completed{
    background:#d8d4ff;
    color:blue;
}

/* PIE CHART */

.circle-chart{
    width:160px;
    height:160px;
    border-radius:50%;

    margin:10px auto 20px;

    background:
    conic-gradient(
        green 0% 20%,
        red 20% 40%,
        orange 40% 60%,
        limegreen 60% 80%,
        purple 80% 100%
    );
}

.legend p{
    display:flex;
    align-items:center;

    gap:10px;

    margin-bottom:10px;

    font-size:14px;
}

.legend span{
    width:14px;
    height:14px;
    border-radius:50%;
}

.green{background:green;}
.red{background:red;}
.orange{background:orange;}
.lightgreen{background:limegreen;}
.purple{background:purple;}

/* ================= QUICK ACTIONS ================= */

.quick-actions{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:14px;

    margin-top:5px;
}

.action-btn{
    background:white;

    border:2px solid #2db845;
    border-radius:18px;

    height:75px;

    display:flex;
    justify-content:center;
    align-items:center;
    gap:12px;

    font-size:18px;
    font-weight:bold;

    cursor:pointer;

    transition:.3s;
}

.action-btn:hover{
    background:#f5fff6;
    transform:translateY(-2px);
}

.action-btn i{
    color:#27aa3d;
    font-size:24px;
}

    </style>

</head>

<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->
<div class="sidebar">


    <div class="sidebar-logo">

        <img src="assets/images/adssu_logo.png.png">

        <h2>ADSSU-BAP</h2>

    </div>



    <ul>


        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':''; ?>">

            <a href="dashboard.php">

                <i class="fa-solid fa-table-columns"></i>

                Dashboard

            </a>

        </li>




        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='assets.php'?'active':''; ?>">

            <a href="assets.php">

                <i class="fa-solid fa-cube"></i>

                Assets

            </a>

        </li>





        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='add_asset.php'?'active':''; ?>">

            <a href="add_asset.php">

                <i class="fa-solid fa-plus"></i>

                Add Asset

            </a>

        </li>





        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='transactions.php'?'active':''; ?>">

            <a href="transactions.php">

                <i class="fa-solid fa-arrow-right-arrow-left"></i>

                Transactions

            </a>

        </li>





        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='inventory.php'?'active':''; ?>">

            <a href="inventory.php">

                <i class="fa-solid fa-boxes-stacked"></i>

                Inventory

            </a>

        </li>





        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='species.php'?'active':''; ?>">

            <a href="species.php">

                <i class="fa-solid fa-cow"></i>

                Species

            </a>

        </li>





        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='reports.php'?'active':''; ?>">

            <a href="reports.php">

                <i class="fa-solid fa-chart-column"></i>

                Reports

            </a>

        </li>





        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='users.php'?'active':''; ?>">

            <a href="users.php">

                <i class="fa-solid fa-users"></i>

                Users

            </a>

        </li>





        <li class="<?php echo basename($_SERVER['PHP_SELF'])=='settings.php'?'active':''; ?>">

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
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">

            <div>

                <h1>Dashboard</h1>

                <span>
                    Overview of all biological assets — FY 2026
                </span>

            </div>

            <div class="top-icons">

                <i class="fa-regular fa-bell"></i>

                <div class="admin">

                    <img src="https://i.pravatar.cc/100">

                    <span>
                        <?php echo $_SESSION['fullname']; ?>
                    </span>

                </div>

            </div>

        </div>

        <!-- CARDS -->
<div class="cards">

    <div class="card">
        <h3>Total Assets</h3>

        <div class="card-flex">
            <h1><?php echo $totalAssets; ?></h1>
            <i class="fa-solid fa-warehouse"></i>
        </div>
    </div>

    <div class="card">
        <h3>Poultry</h3>

        <div class="card-flex">
            <h1><?php echo $poultry; ?></h1>
            <span>🐔</span>
        </div>
    </div>

    <div class="card">
        <h3>Swine</h3>

        <div class="card-flex">
            <h1><?php echo $swine; ?></h1>
            <span>🐖</span>
        </div>
    </div>

    <div class="card">
        <h3>Cattle</h3>

        <div class="card-flex">
            <h1><?php echo $cattle; ?></h1>
            <span>🐄</span>
        </div>
    </div>

    <div class="card">
        <h3>Goat</h3>

        <div class="card-flex">
            <h1><?php echo $goat; ?></h1>
            <span>🐐</span>
        </div>
    </div>

    <div class="card">
        <h3>Sheep</h3>

        <div class="card-flex">
            <h1><?php echo $sheep; ?></h1>
            <span>🐑</span>
        </div>
    </div>

</div>

        <!-- GRID -->
        <div class="content-grid">

            <!-- TABLE -->
            <div class="table-box">

                <h2>Recent Activities</h2>

                <table>

    <tr>
        <th>Date</th>
        <th>Asset</th>
        <th>Species</th>
        <th>Quantity</th>
        <th>Status</th>
    </tr>

    <?php while($row=mysqli_fetch_assoc($recentAssets)){ ?>

    <tr>

        <td>
            <?php echo $row['asset_date']; ?>
        </td>

        <td>
            <?php echo $row['description']; ?>
        </td>

        <td>
            <?php echo $row['species']; ?>
        </td>

        <td>
            <?php echo $row['quantity']; ?>
        </td>

        <td>

            <?php

            if($row['status']=="Alive"){
                echo "<span class='status active'>Alive</span>";
            }

            elseif($row['status']=="Sold"){
                echo "<span class='status completed'>Sold</span>";
            }

            else{
                echo "<span class='status'>".$row['status']."</span>";
            }

            ?>

        </td>

    </tr>

    <?php } ?>

</table>

            </div>

            <!-- INVENTORY -->
            <div class="inventory-box">

                <h2>Inventory Summary</h2>

                <div class="circle-chart"></div>

                <div class="legend">

                    <p>
                        <span class="green"></span>
                        Poultry
                    </p>

                    <p>
                        <span class="red"></span>
                        Swine
                    </p>

                    <p>
                        <span class="orange"></span>
                        Cattle
                    </p>

                    <p>
                        <span class="lightgreen"></span>
                        Goat
                    </p>

                    <p>
                        <span class="purple"></span>
                        Sheep
                    </p>

                </div>

            </div>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="quick-actions">

    <a href="add_asset.php"
       class="action-btn"
       style="text-decoration:none;color:black;">

        <i class="fa-solid fa-circle-plus"></i>
        Add Asset

    </a>

    <a href="assets.php"
       class="action-btn"
       style="text-decoration:none;color:black;">

        <i class="fa-solid fa-boxes-stacked"></i>
        View Assets

    </a>

    <a href="assets.php"
       class="action-btn"
       style="text-decoration:none;color:black;">

        <i class="fa-solid fa-file-lines"></i>
        Asset Records

    </a>

</div>

        </div>

    </div>

</div>

</body>
</html>

