<?php
// insert_product.php

include('../connect.php');

$insPurDate = $_POST['Date'];
$insPurStf = $_POST['purStaff'];
$insPurQty= $_POST['purqt'];
$insPurPrc=$_POST['purprc'];

echo $insPurPrc;

$sql = "INSERT INTO `test`(`date`, `qty`, `prc`) VALUES ('$insPurDate', '$insPurQty','$insPurPrc')";
if ($connect->query($sql) === TRUE) {
    echo "Product inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

?>
