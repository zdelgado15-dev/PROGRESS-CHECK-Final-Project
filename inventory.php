<?php

session_start();
include("config/db.php");


if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}



// TOTAL OPENING BALANCE
$opening = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(quantity) total
FROM assets
"));

$opening_balance = $opening['total'] ?? 0;



// TOTAL ADDITIONS

$add = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(qty) total
FROM additions
"));

$total_additions = $add['total'] ?? 0;




// TOTAL REDUCTIONS

$red = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(qty) total
FROM reductions
"));

$total_reductions = $red['total'] ?? 0;




$current_balance = 
$opening_balance 
+ 
$total_additions
-
$total_reductions;




// INVENTORY PER SPECIES

$sql = "

SELECT

a.species,

SUM(a.quantity) AS balance,

IFNULL((
    SELECT SUM(ad.qty)
    FROM additions ad
    INNER JOIN assets aa
    ON ad.asset_id = aa.id
    WHERE aa.species = a.species
),0) AS additions,

IFNULL((
    SELECT SUM(r.qty)
    FROM reductions r
    INNER JOIN assets rr
    ON r.asset_id = rr.id
    WHERE rr.species = a.species
),0) AS reductions

FROM assets a

GROUP BY a.species

";


$result=mysqli_query($conn,$sql);



?>


<!DOCTYPE html>

<html>

<head>


<title>Inventory</title>


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
height:100vh;

}



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




.main{

flex:1;
padding:30px;

}



.cards{

display:flex;
gap:20px;
margin-top:20px;

}



.card{

background:white;
padding:20px;
width:220px;
border-radius:15px;

}



.card h2{

font-size:30px;

}



.green{

color:green;

}


.red{

color:red;

}



.table-box{

background:white;
padding:20px;
margin-top:30px;
border-radius:15px;

}



table{

width:100%;
border-collapse:collapse;

}



th{

background:#f5f5f5;

}



td,th{

padding:12px;
border:1px solid #ddd;

text-align:center;

}



.total{

background:#8be28b;
font-weight:bold;

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





<div class="main">


<h1>
Inventory
</h1>


<p>
Opening balance, additions, reductions, and current livestock count
</p>




<div class="cards">



<div class="card">

<p>
Current Livestock
</p>

<h2>

<?php echo $opening_balance; ?>

</h2>

</div>




<div class="card">

<p>
Total Additions
</p>

<h2 class="green">

+<?php echo $total_additions; ?>

</h2>

</div>





<div class="card">

<p>
Total Reductions
</p>

<h2 class="red">

-<?php echo $total_reductions; ?>

</h2>

</div>




<div class="card">

<p>
Current Balance
</p>

<h2>

<?php echo $current_balance; ?>

</h2>

</div>



</div>






<div class="table-box">


<h2>
Inventory by Species
</h2>


<br>



<table>


<tr>

<th>
Species
</th>

<th>
Opening
</th>

<th>
Additions
</th>

<th>
Reductions
</th>

<th>
Balance
</th>


</tr>



<?php


$grand_open=0;
$grand_add=0;
$grand_red=0;



while($row=mysqli_fetch_assoc($result)){



$balance = $row['balance'];



$grand_open += $row['balance'];
$grand_add += $row['additions'];
$grand_red += $row['reductions'];



?>



<tr>


<td>

<?php echo $row['species']; ?>

</td>



<td>
<?php echo $row['balance']; ?>
</td>



<td class="green">

+<?php echo $row['additions']; ?>

</td>



<td class="red">

-<?php echo $row['reductions']; ?>

</td>




<td>

<?php echo $balance; ?>

</td>



</tr>



<?php } ?>





<tr class="total">


<td>

GRAND TOTAL

</td>


<td>

<?php echo $grand_open; ?>

</td>



<td>

+<?php echo $grand_add; ?>

</td>



<td>

-<?php echo $grand_red; ?>

</td>




<td>

<?php echo $grand_open; ?>

</td>


</tr>



</table>




</div>





</div>


</div>


</body>

</html>
