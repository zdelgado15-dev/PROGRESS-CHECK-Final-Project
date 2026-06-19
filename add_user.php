<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}

if($_SESSION['role'] != "Administrator"){
    header("Location:dashboard.php");
    exit();
}

if(isset($_POST['save_user'])){

    $fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $role = mysqli_real_escape_string($conn,$_POST['role']);
    $assigned_species = mysqli_real_escape_string($conn,$_POST['assigned_species']);
    $status = mysqli_real_escape_string($conn,$_POST['status']);

    $check = mysqli_query($conn,"
        SELECT * FROM users
        WHERE username='$username'
    ");

    if(mysqli_num_rows($check) > 0){

        $msg = "Username already exists.";

    }else{

        mysqli_query($conn,"
            INSERT INTO users
            (
                fullname,
                username,
                password,
                role,
                assigned_species,
                status
            )
            VALUES
            (
                '$fullname',
                '$username',
                '$password',
                '$role',
                '$assigned_species',
                '$status'
            )
        ");

        echo "
        <script>
        alert('User Added Successfully');
        window.location='users.php';
        </script>
        ";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add User</title>

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
max-width:800px;
margin:40px auto;
}

.form-box{
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 0 10px rgba(0,0,0,.1);
}

h1{
margin-bottom:20px;
}

.form-group{
margin-bottom:15px;
}

label{
display:block;
margin-bottom:5px;
font-weight:bold;
}

input,
select{
width:100%;
padding:12px;
border:1px solid #ccc;
border-radius:8px;
}

.btn{
background:#005612;
color:white;
border:none;
padding:12px 25px;
border-radius:8px;
cursor:pointer;
}

.back{
text-decoration:none;
background:#999;
color:white;
padding:12px 25px;
border-radius:8px;
margin-right:10px;
}

.error{
background:#ffd5d5;
padding:10px;
margin-bottom:15px;
border-radius:8px;
}

</style>

</head>

<body>

<div class="container">

<div class="form-box">

<h1>Add User</h1>

<?php
if(isset($msg)){
echo "<div class='error'>$msg</div>";
}
?>

<form method="POST">

<div class="form-group">
<label>Full Name</label>
<input type="text" name="fullname" required>
</div>

<div class="form-group">
<label>Username</label>
<input type="text" name="username" required>
</div>

<div class="form-group">
<label>Password</label>
<input type="text" name="password" required>
</div>

<div class="form-group">
<label>Role</label>

<select name="role" required>
<option value="Administrator">Administrator</option>
<option value="Staff">Staff</option>
</select>

</div>

<div class="form-group">
<label>Assigned Species</label>

<select name="assigned_species">

<option value="">None</option>

<option value="Poultry">Poultry</option>

<option value="Swine">Swine</option>

<option value="Cattle">Cattle</option>

<option value="Goat">Goat</option>

<option value="Sheep">Sheep</option>

</select>

</div>

<div class="form-group">
<label>Status</label>

<select name="status">

<option value="Active">Active</option>

<option value="Inactive">Inactive</option>

</select>

</div>

<a href="users.php" class="back">
Back
</a>

<button
type="submit"
name="save_user"
class="btn">

Save User

</button>

</form>

</div>

</div>

</body>
</html>