<?php

session_start();
include("config/db.php");


if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}

$role = $_SESSION['role'];



$sql = "

SELECT
id,
'asset' AS source,
asset_date AS date,
'Purchase' AS type,
description AS asset,
species,
quantity AS qty,
fair_value AS value,
'Completed' AS status,
entry_name AS processed
FROM assets

UNION ALL

SELECT
ad.id,
'addition' AS source,
addition_date,
addition_type,
a.description,
a.species,
ad.qty,
ad.amount,
'Completed',
a.entry_name
FROM additions ad
INNER JOIN assets a
ON ad.asset_id=a.id

UNION ALL

SELECT
r.id,
'reduction' AS source,
reduction_date,
reduction_type,
a.description,
a.species,
r.qty,
r.amount,

CASE
WHEN reduction_type='Death'
THEN 'Recorded'
ELSE 'Completed'
END,

a.entry_name

FROM reductions r
INNER JOIN assets a
ON r.asset_id=a.id

ORDER BY date DESC

";



$result=mysqli_query($conn,$sql);



?>



<!DOCTYPE html>

<html>

<head>

<title>Transactions</title>


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
padding:25px;

}



.header{

display:flex;
justify-content:space-between;
align-items:center;

}



.new-btn{

background:#005612;
color:white;
padding:12px 20px;
border-radius:8px;
text-decoration:none;

}



.filters{

margin-top:25px;
display:flex;
gap:20px;

}


.filters input,
.filters select{

padding:10px;
border:1px solid #ccc;
border-radius:8px;

}




.box{

background:white;
margin-top:20px;
padding:20px;
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

}



.completed{

background:#d9d4ff;
padding:5px 10px;
border-radius:15px;

}



.recorded{

background:#ddd;
padding:5px 10px;
border-radius:15px;

}



.action i{

margin:5px;
cursor:pointer;

}


.eye{

color:#0d6efd;

}



.delete{

color:red;

}

.action .fa-pen{
    color:black;
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



<div class="header">


<div>

<h1>
Transactions
</h1>

<p>
Purchase, sale, transfer, and mortality records.
</p>

</div>



<a href="add_asset.php"
class="new-btn">

+ New Transaction

</a>


</div>







<div class="filters">


<select>

<option>
All Types
</option>

<option>
Purchase
</option>

<option>
Sale
</option>

<option>
Death
</option>


</select>



<input type="date">


<input type="date">


<input type="text"
placeholder="Search Transaction">



</div>







<div class="box">



<table>



<tr>

<th>Date</th>
<th>Type</th>
<th>Asset</th>
<th>Species</th>
<th>Qty</th>
<th>Value ₱</th>
<th>Status</th>
<th>Processed</th>
<th>Action</th>


</tr>





<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>



<td>
<?php echo date("M j, Y", strtotime($row['date'])); ?>
</td>



<td>

<?php echo $row['type']; ?>

</td>



<td>

<?php echo $row['asset']; ?>

</td>



<td>

<?php echo $row['species']; ?>

</td>



<td>

<?php echo $row['qty']; ?>

</td>



<td>
₱ <?php echo number_format($row['value'],2); ?>
</td>




<td>


<?php

if($row['status']=="Completed"){

echo "<span class='completed'>Completed</span>";

}

else{

echo "<span class='recorded'>Recorded</span>";

}


?>


</td>



<td>

<?php echo $row['processed']; ?>

</td>



<td class="action">

<a href="view_transaction.php?id=<?php echo $row['id']; ?>&source=<?php echo $row['source']; ?>">
    <i class="fa-solid fa-eye eye"></i>
</a>

<a href="edit_transaction.php?id=<?php echo $row['id']; ?>&source=<?php echo $row['source']; ?>">
    <i class="fa-solid fa-pen"></i>
</a>

<?php if($role=="Administrator"){ ?>

<a href="delete_transaction.php?id=<?php echo $row['id']; ?>&source=<?php echo $row['source']; ?>"
onclick="return confirm('Delete Transaction?')">

<i class="fa-solid fa-trash delete"></i>

</a>

<?php } ?>

</td>



</tr>


<?php } ?>



</table>


</div>




</div>


</div>



</body>

</html>