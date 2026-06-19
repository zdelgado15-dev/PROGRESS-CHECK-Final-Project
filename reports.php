<?php

session_start();
include("config/db.php");


if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}



$opening_query = mysqli_query($conn,"
SELECT SUM(quantity) AS total
FROM assets
");


$opening = mysqli_fetch_assoc($opening_query)['total'] ?? 0;




$addition_query = mysqli_query($conn,"
SELECT SUM(qty) AS total
FROM additions
");


$addition = mysqli_fetch_assoc($addition_query)['total'] ?? 0;




$reduction_query = mysqli_query($conn,"
SELECT SUM(qty) AS total
FROM reductions
");


$reduction = mysqli_fetch_assoc($reduction_query)['total'] ?? 0;




$closing = $opening + $addition - $reduction;


?>


<!DOCTYPE html>
<html>

<head>

<title>Reports</title>


<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<style>


*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}



body{

background:#f3f3f3;

}



.container{

display:flex;
min-height:100vh;

}



/* SIDEBAR */

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



.sidebar a{

color:white;
text-decoration:none;

display:flex;
gap:10px;
align-items:center;

}



.logout{

margin-top:auto;

padding:12px;

}




/* MAIN */


.main{

flex:1;
padding:30px;

}




.header{

display:flex;
justify-content:space-between;
align-items:center;

}



.header h1{

font-size:32px;

}



.actions{

display:flex;
gap:10px;

}



.btn{

padding:12px 18px;
border-radius:8px;
border:none;
cursor:pointer;

}



.green{

background:#005612;
color:white;

}



.gray{

background:white;
border:1px solid #ccc;

}





/* CARDS */


.cards{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:20px;

margin-top:30px;

}




.card{

background:white;

padding:25px;

border-radius:15px;

box-shadow:0 2px 8px #ddd;

}



.card h3{

color:#555;

margin-bottom:15px;

}



.number{

font-size:32px;

font-weight:bold;

}



.open{

color:#005612;

}



.add{

color:#0b7d26;

}



.reduce{

color:#d9534f;

}



.close{

color:#0066cc;

}




.report-box{

background:white;

margin-top:30px;

padding:25px;

border-radius:15px;

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



<li class="active">

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





<div class="main">



<div class="header">


<div>

<h1>
Reports
</h1>


<p>
Generate and view biological asset reports
</p>


</div>



<div class="actions">


<button class="btn green">

<i class="fa-solid fa-file"></i>

Generate Report

</button>



<button class="btn green">

<i class="fa-solid fa-file-pdf"></i>

Export PDF

</button>



<button class="btn green">

<i class="fa-solid fa-file-excel"></i>

Export Excel

</button>




<button onclick="window.print()"
class="btn gray">

<i class="fa-solid fa-print"></i>

Print

</button>



</div>


</div>





<div class="cards">



<div class="card">

<h3>
Opening Balance
</h3>

<div class="number open">

<?php echo $opening; ?>

</div>


</div>





<div class="card">

<h3>
Total Additions
</h3>

<div class="number add">

<?php echo $addition; ?>

</div>


</div>





<div class="card">

<h3>
Total Reductions
</h3>

<div class="number reduce">

<?php echo $reduction; ?>

</div>


</div>





<div class="card">

<h3>
Closing Balance
</h3>

<div class="number close">

<?php echo $closing; ?>

</div>


</div>



</div>





<div class="report-box">


<h2>
Biological Asset Summary
</h2>


<p>
Current inventory balance after additions and reductions.
</p>


</div>




</div>



</div>


</body>


</html>
