<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['fullname'])){
    header("Location:index.php");
    exit();
}

$id = intval($_GET['id']);
$source = $_GET['source'];

if(isset($_POST['update'])){

    $qty = $_POST['qty'];

    if($source == "asset"){

        $sql = "UPDATE assets
                SET quantity='$qty'
                WHERE id='$id'";

    }elseif($source == "addition"){

        $amount = $_POST['amount'];

        $sql = "UPDATE additions
                SET qty='$qty',
                    amount='$amount'
                WHERE id='$id'";

    }elseif($source == "reduction"){

        $amount = $_POST['amount'];

        $sql = "UPDATE reductions
                SET qty='$qty',
                    amount='$amount'
                WHERE id='$id'";

    }

    mysqli_query($conn,$sql);

    echo "<script>
    alert('Transaction Updated Successfully!');
    window.location='transactions.php';
    </script>";
    exit();
}

if($source=="asset"){

    $sql="SELECT * FROM assets WHERE id='$id'";

}elseif($source=="addition"){

    $sql="SELECT * FROM additions WHERE id='$id'";

}else{

    $sql="SELECT * FROM reductions WHERE id='$id'";
}

$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Transaction</title>

<style>

body{
    font-family:Arial;
    background:#f3f3f3;
    padding:30px;
}

.box{
    background:white;
    max-width:600px;
    margin:auto;
    padding:25px;
    border-radius:10px;
}

label{
    display:block;
    margin-top:10px;
}

input{
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:15px;
}

button{
    background:#005612;
    color:white;
    border:none;
    padding:10px 20px;
    cursor:pointer;
}

</style>

</head>
<body>

<div class="box">

<h2>Edit Transaction</h2>

<form method="POST">

<label>Quantity</label>

<input
type="number"
name="qty"
value="<?php echo isset($row['quantity']) ? $row['quantity'] : $row['qty']; ?>"
required>

<?php if($source!="asset"){ ?>

<label>Amount</label>

<input
type="number"
step="0.01"
name="amount"
value="<?php echo $row['amount']; ?>"
required>

<?php } ?>

<button type="submit" name="update">
Update Transaction
</button>

</form>

</div>

</body>
</html>