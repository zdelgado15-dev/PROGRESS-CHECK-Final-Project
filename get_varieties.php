<?php
include("config/db.php");

$category = mysqli_real_escape_string(
    $conn,
    $_GET['category']
);

$query = mysqli_query($conn,"
SELECT variety
FROM species
WHERE category='$category'
ORDER BY variety ASC
");

echo '
<option value="">
Select Variety
</option>
';

while($row=mysqli_fetch_assoc($query)){

    echo '
    <option value="'.$row['variety'].'">
        '.$row['variety'].'
    </option>
    ';
}
?>