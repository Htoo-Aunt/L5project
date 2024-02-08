<?php 
include('../connect.php');

session_start();  


$Category = $_POST['category'];
$Size = $_POST['size'];
$price=$_POST['price'];
$qty=0;

$check="SELECT * FROM inventory WHERE ProductID='$Category' AND Size='$Size'";
$run=mysqli_query($connect,$check);
$count=mysqli_num_rows($run);

if ($count>0) {
   echo "Product Already Exist";
   
}

else{
$sql="INSERT INTO inventory (`ProductID`, `Size`, `Quantity`,`SellingPrice`) VALUES ('$Category','$Size','$qty','$price')";

$run=mysqli_query($connect,$sql);

if ($run) {
    echo "Product inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

}

?>