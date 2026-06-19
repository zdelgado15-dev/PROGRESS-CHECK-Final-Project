<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}

$message="";

if(isset($_POST['save'])){

    $system_name=mysqli_real_escape_string($conn,$_POST['system_name']);
    $institution=mysqli_real_escape_string($conn,$_POST['institution']);
    $office=mysqli_real_escape_string($conn,$_POST['office']);
    $currency=mysqli_real_escape_string($conn,$_POST['currency']);
    $date_format=mysqli_real_escape_string($conn,$_POST['date_format']);
    $timezone=mysqli_real_escape_string($conn,$_POST['timezone']);

    mysqli_query($conn,"
    UPDATE settings SET
    system_name='$system_name',
    institution='$institution',
    office='$office',
    currency='$currency',
    date_format='$date_format',
    timezone='$timezone'
    WHERE id=1
    ");

    $message="Settings updated successfully!";
}

$settings=mysqli_fetch_assoc(
mysqli_query($conn,"SELECT * FROM settings WHERE id=1")
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Settings</title>

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
}

.logout a{
color:white;
text-decoration:none;
display:flex;
align-items:center;
gap:10px;
padding:12px;
}

.main{
flex:1;
padding:30px;
}

.topbar{
display:flex;
justify-content:flex-end;
align-items:center;
gap:20px;
margin-bottom:20px;
}

.admin{
display:flex;
align-items:center;
gap:10px;
}

.admin img{
width:35px;
height:35px;
border-radius:50%;
}

.header h1{
font-size:35px;
}

.header p{
color:#666;
margin-bottom:25px;
}

.tabs{
display:flex;
gap:5px;
margin-bottom:0;
}

.tab{
padding:12px 20px;
border:1px solid #999;
background:white;
border-radius:8px 8px 0 0;
cursor:pointer;
}

.tab.active{
background:#1f5f2a;
color:white;
border:none;
}

.settings-box{
background:white;
border:1px solid #999;
padding:30px;
border-radius:0 8px 8px 8px;
}

.form-group{
display:flex;
align-items:center;
margin-bottom:18px;
}

.form-group label{
width:250px;
font-size:18px;
}

.form-group input{
flex:1;
padding:12px;
border:1px solid #999;
border-radius:6px;
font-size:16px;
}

.save-btn{
background:#1f5f2a;
color:white;
border:none;
padding:12px 40px;
border-radius:8px;
cursor:pointer;
font-size:16px;
}

.save-wrap{
text-align:center;
margin-top:25px;
}

.success{
background:#d4edda;
color:#155724;
padding:12px;
margin-bottom:15px;
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

<li class="active">
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

<div class="topbar">

<i class="fa-regular fa-bell fa-lg"></i>

<div class="admin">
<i class="fa-solid fa-circle-user fa-xl"></i>
Administrator
<i class="fa-solid fa-chevron-down"></i>
</div>

</div>

<div class="header">
<h1>Settings</h1>
<p>System configuration and organizational preferences.</p>
</div>

<div class="tabs">
<div class="tab active">Overall</div>
<div class="tab">System</div>
<div class="tab">Backup</div>
<div class="tab">Notifications</div>
</div>

<div class="settings-box">

<?php if($message!=""){ ?>
<div class="success">
<?php echo $message; ?>
</div>
<?php } ?>

<form method="POST">

<div class="form-group">
<label>System Name</label>
<input type="text" name="system_name"
value="<?php echo $settings['system_name']; ?>">
</div>

<div class="form-group">
<label>Institution</label>
<input type="text" name="institution"
value="<?php echo $settings['institution']; ?>">
</div>

<div class="form-group">
<label>Academic Unit/Office</label>
<input type="text" name="office"
value="<?php echo $settings['office']; ?>">
</div>

<div class="form-group">
<label>Default Currency</label>
<input type="text" name="currency"
value="<?php echo $settings['currency']; ?>">
</div>

<div class="form-group">
<label>Date Format</label>
<input type="text" name="date_format"
value="<?php echo $settings['date_format']; ?>">
</div>

<div class="form-group">
<label>Time Zone</label>
<input type="text" name="timezone"
value="<?php echo $settings['timezone']; ?>">
</div>

<div class="save-wrap">
<button type="submit" name="save" class="save-btn">
Save Changes
</button>
</div>

</form>

</div>

</div>

</div>

</body>
</html>

