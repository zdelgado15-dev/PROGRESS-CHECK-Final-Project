
<?php

session_start();
include("config/db.php");


if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}


$search="";


if(isset($_GET['search'])){
    $search=mysqli_real_escape_string($conn,$_GET['search']);
}


$sql="
SELECT * FROM users
WHERE fullname LIKE '%$search%'
OR username LIKE '%$search%'
OR role LIKE '%$search%'
OR status LIKE '%$search%'
ORDER BY id DESC
";


$result=mysqli_query($conn,$sql);


?>


<!DOCTYPE html>
<html>

<head>

<title>Users</title>


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



.sidebar ul li:hover,
.sidebar ul li.active{

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



.main{

flex:1;
padding:30px;

}



.header{

display:flex;
justify-content:space-between;
align-items:center;

}



.add-btn{

background:#005612;
color:white;
padding:12px 25px;
border-radius:8px;
text-decoration:none;

}



.search-area{

margin-top:20px;
display:flex;
gap:10px;

}



.search-area input{

width:320px;
padding:10px;
border:1px solid #aaa;
border-radius:8px;

}



.search-area button{

background:#005612;
color:white;
border:none;
padding:10px 20px;
border-radius:8px;

}



.table-box{

background:white;
margin-top:20px;
padding:20px;
border-radius:12px;

}



table{

width:100%;
border-collapse:collapse;

}



th{

background:#f5f5f5;

}



td,th{

padding:15px;
border:1px solid #ddd;

}



.active-status{

background:#57e56a;
padding:5px 15px;
border-radius:15px;

}



.inactive-status{

background:#ff7b7b;
padding:5px 15px;
border-radius:15px;

}



.edit{

color:black;

}



.delete{

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



<li class="active">

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

<h1>Users</h1>

<p>
Manage system user accounts and access control
</p>

</div>



<a href="add_user.php" class="add-btn">

<i class="fa-solid fa-plus"></i>

Add User

</a>


</div>




<form class="search-area">


<input type="text"
name="search"
placeholder="Search Users...">



<button>

Search

</button>


</form>




<div class="table-box">


<table>


<tr>

<th>Name</th>
<th>Username</th>
<th>Role</th>
<th>Status</th>
<th>Date Added</th>
<th>Actions</th>


</tr>



<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr>


<td>

<?php echo $row['fullname']; ?>

</td>


<td>

<?php echo $row['username']; ?>

</td>


<td>

<?php echo $row['role']; ?>

</td>



<td>


<?php

if($row['status']=="Active"){

echo "<span class='active-status'>Active</span>";

}

else{

echo "<span class='inactive-status'>Inactive</span>";

}

?>


</td>



<td>

<?php echo date("m/d/Y",strtotime($row['created_at'])); ?>

</td>



<td>


<i class="fa-solid fa-pen edit"></i>


&nbsp;


<i class="fa-solid fa-trash delete"></i>



</td>


</tr>



<?php } ?>



</table>



</div>


</div>


</div>


</body>

</html>
