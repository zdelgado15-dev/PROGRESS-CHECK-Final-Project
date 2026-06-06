<?php
session_start();
include("config/db.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "SELECT * FROM users
              WHERE username='$username'
              AND password='$password'
              AND role='$role'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];

        header("Location: dashboard.php");
        exit();

    }else{
        $error = "Invalid Login Credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ADSSU-BAP Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<div class="login-container">

    <div class="left-side">

        <img src="assets/images/adssu_logo.png.png" class="logo">

        <h1>ADSSU-BAP</h1>

        <p>
            Online Biological Assets Property &<br>
            Species-Specific Tracking System
        </p>

    </div>

    <div class="right-side">

        <div class="form-box">

            <h2>Welcome Back!</h2>
            <span>Please login to your account</span>

            <?php if(isset($error)){ ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="input-box">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" name="username" placeholder="Username or Email" required>
                </div>

                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                    <i class="fa-regular fa-eye eye"></i>
                </div>

                <label>Select Role</label>

                <select name="role" required>
                    <option>Administrator</option>
                    <option>Staff</option>
                </select>

                <button type="submit" name="login">
                    Login
                </button>

                <a href="#" class="forgot">
                    Forgot Password?
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>