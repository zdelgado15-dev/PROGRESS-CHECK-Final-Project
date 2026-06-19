<?php

session_start();

include("config/db.php");


if(!isset($_SESSION['fullname'])){

    header("Location:index.php");
    exit();

}


$query = "

SELECT 
category,
COUNT(*) total

FROM species

GROUP BY category

";


$result = mysqli_query($conn,$query);


?>


<!DOCTYPE html>

<html>

<head>

<title>Species Management</title>


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

gap:10px;

align-items:center;

}




.main{

flex:1;

padding:30px;

overflow:auto;

}



.header{

display:flex;

justify-content:space-between;

align-items:center;

}



.header h1{

font-size:32px;

}



.add{

background:#005612;

color:white;

padding:12px 20px;

border-radius:8px;

text-decoration:none;

}



.category{

background:white;

margin-top:20px;

padding:20px;

border-radius:12px;

display:flex;

justify-content:space-between;

align-items:center;

cursor:pointer;

}



.category:hover{

background:#eef8ee;

}



.category h2{

display:flex;

align-items:center;

gap:10px;

}



.count{

font-size:25px;

font-weight:bold;

}



.varieties{

background:white;

padding:20px;

border-radius:0 0 12px 12px;

}



.variety{

background:#f5faf5;

padding:12px;

margin:8px 0;

border-radius:8px;

display:flex;

justify-content:space-between;

align-items:center;

}



.edit{

color:green;

margin-right:15px;

cursor:pointer;

}



.delete{

color:red;

cursor:pointer;

}



.add-variety{

margin-top:10px;

padding:10px 20px;

background:#005612;

color:white;

border:none;

border-radius:8px;

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




<li class="active">

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



<div class="header">


<div>

<h1>

Species Management

</h1>


<p>

Manage livestock categories and their registered species varieties.

</p>


</div>



<a href="#" class="add">

+ Add Species

</a>



</div>





<?php while($cat=mysqli_fetch_assoc($result)){ ?>


<div class="category"
onclick="toggleSpecies('<?php echo $cat['category']; ?>')">



<h2>

<i class="fa-solid fa-cow"></i>

<?php echo $cat['category']; ?>


</h2>



<div class="count">


<?php echo $cat['total']; ?>


<i class="fa-solid fa-chevron-down"></i>


</div>


</div>





<div class="varieties"

id="<?php echo $cat['category']; ?>"

style="display:none;">



<?php



$name=$cat['category'];



$list=mysqli_query($conn,

"SELECT * FROM species 

WHERE category='$name'"

);



while($row=mysqli_fetch_assoc($list)){


?>



<div class="variety">


<span>

• <?php echo $row['variety']; ?>

</span>




<span>


<i class="fa-solid fa-pen edit"></i>


<i class="fa-solid fa-trash delete"></i>


</span>



</div>



<?php } ?>



<button class="add-variety">

+ Add Variety

</button>



</div>



<?php } ?>




</div>


</div>





<script>


function toggleSpecies(id){


let box=document.getElementById(id);



if(box.style.display==="none"){

box.style.display="block";

}

else{

box.style.display="none";

}


}


</script>



</body>

</html>

