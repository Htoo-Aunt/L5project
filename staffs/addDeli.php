<?php 

session_start();
include('../connect.php');

if (!isset($_SESSION['sid'])) {

echo "<script>window.alert('Please Login First!')</script>";
echo "<script>window.location='stfLogin.php'</script>";


}

$proid=$_GET['delid'];
$check="SELECT * FROM orders WHERE OrderID='$proid'";
$check2="SELECT * FROM deliveryorders WHERE OrderID='$proid'";
$checkquery=mysqli_query($connect,$check);
$checkquery2=mysqli_query($connect,$check2);
$statusrow=mysqli_fetch_array($checkquery);
$count=mysqli_num_rows($checkquery2);

if (isset($proid) && ($statusrow['OrderStatus'] === 'Pending' || $statusrow['OrderStatus'] === 'Canceled' || $statusrow['OrderStatus']==='Scheduled')) 
{
    echo"<script>window.alert('It cannot be registered for Delivery')</script>";
     echo "<script>window.location='orderlist.php'</script>";
}
 
elseif ($count>0) {
    echo"<script>window.alert('This order already exist in delivery process!! You can check it at delivery page')</script>";
     echo "<script>window.location='deliList.php'</script>";
}

else{
$show="SELECT * FROM orders WHERE OrderID='$proid'";
$run=mysqli_query($connect,$show);
$row=mysqli_fetch_array($run);
}

function logout() {
     
     unset($_SESSION['sid']);

    // Redirect to the login page
    header("Location: stfLogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirmation = $_POST['confirmation'];
    

    if ($confirmation === 'confirmed') {
     logout();


    } 
    else {
        // Handle the case where the user canceled
        echo "User canceled. No action taken.";
    }
} 






if (isset($_POST['deliUpd'])) {

    $deliOrdid=$_POST['updOrdid'];
    $deliname=$_POST['cboDeliname'];    
    $deliContact=$_POST['delicon'];
    $deliaddress=$_POST['deliadd'];
     $pickDate=$_POST['deliDate'];
    $paymentTypes=$_POST['cbodeliPayT'];
    $paymentMethod=$_POST['cbodeliPayM'];
    $delsts="Scheduled";
   
$insert="INSERT INTO deliveryorders(`OrderID`, `DeliName`, `DeliCusContact`, `DeliCusAddress`, `PickUpDate`, `PaymentTypes`, `PaymentMethod`, `DeliStatus`) VALUES ('$deliOrdid','$deliname',' $deliContact','  $deliaddress',' $pickDate','$paymentTypes',' $paymentMethod','$delsts')";

$UpdateStatus="UPDATE orders 
                   SET 
                   OrderStatus='$delsts'
                   WHERE OrderID='$deliOrdid' 
                   ";
$result2=mysqli_query($connect,$UpdateStatus);
        $result=mysqli_query($connect,$insert);

        if ($result && $result2) {
         echo"<script>window.alert('Successful')</script>";
        echo"<script>window.location='orderlist.php'</script>";
         
    
}
}



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="POS - Bootstrap Admin Template">
<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
<meta name="author" content="Dreamguys - Bootstrap Admin Template">
<meta name="robots" content="noindex, nofollow">
<title>Jelly ICS</title>

<link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">

<link rel="stylesheet" href="../assets/css/bootstrap.min.css">

<link rel="stylesheet" href="../assets/css/animate.css">

<link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">

<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="../assets/css/style.css">


</head>
<body>
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper">

<div class="header">

<div class="header-left active">
<a href="#" class="logo">
<img src="../assets/img/logo.png" alt="">
</a>
<a href="#" class="logo-small">
<img src="../assets/img/logo-small.png" alt="">
</a>
<a id="toggle_btn" href="javascript:void(0);">
</a>
</div>

<a id="mobile_btn" class="mobile_btn" href="#sidebar">
<span class="bar-icon">
<span></span>
<span></span>
<span></span>
</span>
</a>

<ul class="nav user-menu">









<li class="nav-item dropdown has-arrow main-drop">
<a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
<span class="user-img" style="padding-bottom:0px;"><img src="../assets/img/profiles/avator1.jpg" alt="">
<span class="status online"></span></span>
</a>
<div class="dropdown-menu menu-drop-user">
<div class="profilename">
<div class="profileset">
<span class="user-img"><img src="../assets/img/profiles/avator1.jpg" alt="">
<span class="status online"></span></span>
<div class="profilesets">
    <?php

    $tempaid=$_SESSION['sid'];
    $admQuery="SELECT st.*, r.* FROM staffs st, roles r WHERE st.StaffID='$tempaid' AND st.RoleID=r.RoleID ";
    $stfrun=mysqli_query($connect,$admQuery);
    $staff=mysqli_fetch_array($stfrun);


     ?>

<h6><?php echo $staff['StaffName']; ?></h6>
<h5><?php echo $staff['RoleName']; ?></h5>
</div>
</div>
<hr class="m-0">

<hr class="m-0">

<a class="dropdown-item logout pb-0" onclick="confirmLog();"><img src="../assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
</div>
</div>
</li>
</ul>


<div class="dropdown mobile-user-menu " >
<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
<div class="dropdown-menu dropdown-menu-right">
    

<a class="dropdown-item" onclick="confirmLog();">Logout</a>
</div>
</div>

</div>



<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li>
<a href="dashboard.php" ><img src="../assets/img/icons/dashboard.svg" alt="img"><span>Dashboard</span> </a>
</li>
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/users1.svg" alt="img"><span>Supplier</span> <span class="menu-arrow"></span></a>
<ul>

    <li>
<a href="supplierlist.php">Suppliers List</a>
</li>
<li>
<a href="addsupplier.php" > Add Suppliers</a>
</li>


</ul>
</li>

<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/product.svg" alt="img"><span>Products</span> <span class="menu-arrow"></span></a>
<ul>
<li>
<a href="productlist.php" >Product List</a>
</li>
<li>
<a href="addproduct.php" >Add Products</a>
</li>
<li>
<a href="categorylist.php">Category List</a>
</li>
<li>
<a href="addcategory.php">Add Category</a>
</li>
<li>
<a href="sizeList.php">Size List</a>
</li>
<li>
<a href="addsize.php" >Add Sizes</a>
</li>

</ul>
</li>

<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/quotation1.svg" alt="img"><span>Purchases</span> <span class="menu-arrow"></span></a>
<ul>
<li>
<a href="purchaselist.php">Purchase List</a>

</li>
<li>
<a href="addpurchase.php">Add Purchase</a>
</li>




</ul>
</li>

<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/purchase1.svg" alt="img"><span>Inventory</span> <span class="menu-arrow"></span></a>
<ul>


<li>
<a href="inventoriesList.php">Inventories List</a>

</li>
<li>
<a href="addinventories.php">Add Inventories</a>
</li>



</ul>
</li>

<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/order.svg" alt="img"><span>Orders</span> <span class="menu-arrow"></span></a>
<ul>


<li>
<a href="orderlist.php" class="active">Orders List</a>
</li>
<li>
<a href="addcustomers.php"  >Add Orders</a>
</li>
<li>
<a href="addcustomers.php">Add Customers</a>
</li>


</ul>
</li>

<li>
<a href="deliList.php" ><img src="../assets/img/icons/delivery.svg" alt="img"><span>Deliveries</span> </a>
</li>
</ul>
</div>
</div>
</div>


<form action="addDeli.php" method="POST" >
<div class="page-wrapper">
<div class="content">
<div class="page-header">
<div class="page-title">

    <a href="orderlist.php" class="btn btn-cancel" style="margin-bottom: 20px;">Back</a>
<h4>Add Delivery</h4>
<h6>Create new Delivery record</h6>
</div>
</div>

<div class="card">
<div class="card-body">
<div class="row">



<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Order Code</label>
<input type="text" name="proname" value="<?php echo $row['OrderID'] ?>" required readonly>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Select Delivery</label>
<select name="cboDeliname" class="select">

<option value="Mini Express">Mini Express</option>
<option value="Ninja Van">Ninja Van</option>
<option value="Royal Express">Royal Express</option>
<option value="Bee Express">Bee Express</option>

</select>
</div>
</div>


<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Contact to Deliver</label>
<input type="number" name="delicon" id="phoneNumberInput" onchange="validatePhoneNumber()" required>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Address to Deliver</label>
<input type="text" name="deliadd" required>
</div>
</div>
<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Pick Up Date</label>
<input type="date" name="deliDate" required>
</div>
</div>


<div class="col-lg-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Select Payment Types</label>
<select name="cbodeliPayT" class="select">


<option value="COD">Cash On Deli</option>
<option value="prepaid">Prepaid</option>

</select>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Select Payment Method</label>
<select name="cbodeliPayM" class="select">

<option value="Cash">
    Cash
</option>
<option value="Kpay">KBZpay</option>
<option value="WavePay">WavePay</option>

</select>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Order Amount (Exclude Delifees)</label>
<input type="text"  value="<?php echo $row['TotalAmount'] ?>" required readonly>
</div>
</div>

<input type="text" name="updOrdid" value="<?php echo  $row['OrderID'] ?>" readonly hidden>

<div class="col-lg-12">
<input type="submit" class="btn btn-submit me-2" value="Update" name="deliUpd">
<input type="reset" class="btn btn-submit me-2">

</div>
</div>
</div>
</div>


</div>

</div>
</form>
</div>

</div>


<script>
    function confirmLog() {
           
            var confirmMessage = "Are you sure you want to Log out!!" ;
            
            // Show the confirmation dialog
            var userConfirmed = confirm(confirmMessage);

            // Send the confirmation result to the server using AJAX
            if (userConfirmed) {
                $.ajax({
                    type:"POST",
                    url: "addproduct.php",
                    data: { confirmation: "confirmed" },
                    success:function(response) {
               if(response){ // check whether response is received
                    window.location.href = "stfLogin.php";}
               }
                });
            } else {
                // Handle the case where the user canceled
                alert("User canceled. No action taken.");
            }
        }

function validatePhoneNumber() {
      // Get the phone number from the input field
      const phoneNumber = document.getElementById("phoneNumberInput").value;

      // Define a regular expression pattern for a typical phone number
      const phoneRegex = /^[0-9]{11}$/;

      // Test the phone number against the regular expression
      const isValid = phoneRegex.test(phoneNumber);

      // Display the validation result
      if (isValid) {
        alert("Phone number is valid!");
      } 
      else {
        alert("Invalid phone number. Please enter a 11-digit numeric phone number.");
        document.getElementById("phoneNumberInput").value= '';
      }
    }

</script>

<script src="../assets/js/jquery-3.6.0.min.js"></script>

<script src="../assets/js/feather.min.js"></script>

<script src="../assets/js/jquery.slimscroll.min.js"></script>

<script src="../assets/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/dataTables.bootstrap4.min.js"></script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/plugins/select2/js/select2.min.js"></script>

<script src="../assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="../assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script src="../assets/js/script.js"></script>
</body>
</html>