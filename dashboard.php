<?php
session_start();

if(!isset($_SESSION['fullname'])){
    header("Location: index.php");
    exit();
}
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

    padding:18px;

    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.sidebar-logo{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:25px;
}

.sidebar-logo img{
    width:45px;
    height:45px;
}

.sidebar-logo h2{
    font-size:22px;
}

.sidebar ul{
    list-style:none;
}

.sidebar ul li{
    padding:12px 14px;
    border-radius:10px;
    margin-bottom:8px;

    cursor:pointer;

    font-size:16px;

    display:flex;
    align-items:center;
    gap:12px;

    transition:.3s;
}

.sidebar ul li:hover,
.active{
    background:#227d33;
}

.logout{
    color:white;
    text-decoration:none;

    font-size:16px;

    display:flex;
    align-items:center;
    gap:10px;

    padding:12px 14px;
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

        <div>

            <div class="sidebar-logo">

                <img src="assets/images/adssu_logo.png.png">

                <h2>ADSSU-BAP</h2>

            </div>

            <ul>

                <li class="active">
                    <i class="fa-solid fa-table-columns"></i>
                    Dashboard
                </li>

                <li>
                    <i class="fa-solid fa-cube"></i>
                    Assets
                </li>

                <li>
                    <i class="fa-solid fa-plus"></i>
                    Add Assets
                </li>

                <li>
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    Transactions
                </li>

                <li>
                    <i class="fa-solid fa-boxes-stacked"></i>
                    Inventory
                </li>

                <li>
                    <i class="fa-solid fa-paw"></i>
                    Species
                </li>

                <li>
                    <i class="fa-regular fa-file-lines"></i>
                    Reports
                </li>

                <li>
                    <i class="fa-solid fa-users"></i>
                    Users
                </li>

                <li>
                    <i class="fa-solid fa-gear"></i>
                    Settings
                </li>

            </ul>

        </div>

        <a href="logout.php" class="logout">

            <i class="fa-solid fa-right-from-bracket"></i>

            Logout

        </a>

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

                <h3>Total Livestock</h3>

                <div class="card-flex">

                    <h1>20</h1>

                    <i class="fa-solid fa-warehouse"></i>

                </div>

            </div>

            <div class="card">

                <h3>Poultry</h3>

                <div class="card-flex">

                    <h1>4</h1>

                    <span>🐔</span>

                </div>

            </div>

            <div class="card">

                <h3>Swine</h3>

                <div class="card-flex">

                    <h1>4</h1>

                    <span>🐖</span>

                </div>

            </div>

            <div class="card">

                <h3>Cattle</h3>

                <div class="card-flex">

                    <h1>4</h1>

                    <span>🐄</span>

                </div>

            </div>

            <div class="card">

                <h3>Goat</h3>

                <div class="card-flex">

                    <h1>4</h1>

                    <span>🐐</span>

                </div>

            </div>

            <div class="card">

                <h3>Sheep</h3>

                <div class="card-flex">

                    <h1>4</h1>

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
                        <th>Activity</th>
                        <th>Assets</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>By</th>
                    </tr>

                    <tr>
                        <td>May 6, 2026</td>
                        <td>Added</td>
                        <td>Chicks</td>
                        <td>2</td>
                        <td>
                            <span class="status active">
                                Active
                            </span>
                        </td>
                        <td>Staff</td>
                    </tr>

                    <tr>
                        <td>May 6, 2026</td>
                        <td>Sold</td>
                        <td>Goat</td>
                        <td>2</td>
                        <td>
                            <span class="status completed">
                                Completed
                            </span>
                        </td>
                        <td>Staff</td>
                    </tr>

                    <tr>
                        <td>May 5, 2026</td>
                        <td>Transfer</td>
                        <td>Sheep</td>
                        <td>3</td>
                        <td>
                            <span class="status completed">
                                Completed
                            </span>
                        </td>
                        <td>Staff</td>
                    </tr>

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

            <div class="action-btn">

                <i class="fa-solid fa-circle-plus"></i>

                Add Asset

            </div>

            <div class="action-btn">

                <i class="fa-solid fa-arrow-right-arrow-left"></i>

                Transaction

            </div>

            <div class="action-btn">

                <i class="fa-solid fa-file-lines"></i>

                View Reports

            </div>

        </div>

    </div>

</div>

</body>
</html>