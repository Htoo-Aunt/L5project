<?php 
include('../connect.php');
session_start();
if (!isset($_SESSION['sid'])) {

echo "<script>window.alert('Please Login First!')</script>";
echo "<script>window.location='stfLogin.php'</script>";


}
function logout() {
     
     unset($_SESSION['sid']);

    // Redirect to the login page
    header("Location: signin.php");
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

if(isset($_POST['btnUpd'])) 
{
    $txtPurchaseID=$_POST['updDelid'];
    $sts=$_POST['updPurstatus'];
    $ordsts=$_POST['updOrderID'];
    
if ($sts=='Failed') {
    $redInv="SELECT * FROM orderdetails WHERE OrderID='$ordsts'";
    $run=mysqli_query($connect,$redInv);
    while($arr=mysqli_fetch_array($run))
    {
        $ProductID=$arr['InvID'];
        $PurchaseQuantity=$arr['quantity'];
        $UpdateQty="UPDATE inventory 
                    SET 
                    Quantity=Quantity + '$PurchaseQuantity'
                    WHERE InvID='$ProductID'
                    ";
        $ret=mysqli_query($connect,$UpdateQty);
    }
    $UpdateQty="UPDATE deliveryorders 
                    SET 
                    DeliStatus='$sts'
                    WHERE DeliveryID='$txtPurchaseID'
                    ";
        $ret=mysqli_query($connect,$UpdateQty);
    

    $UpdateStatus="UPDATE orders 
                   SET 
                   OrderStatus='$sts'
                   WHERE OrderID='$ordsts' 
                   ";
    $ret=mysqli_query($connect,$UpdateStatus);
     if($ret) //true
    {
        echo "<script>window.alert('Successfully Confirmed!')</script>";
        echo "<script>window.location='orderlist.php'</script>";
    }
    else
    {
        echo "<p>Something went wrong in Purchase Confirmed:" . mysql_error($connect) . "</p>";
    }
}

else{
    
        $UpdateQty="UPDATE deliveryorders 
                    SET 
                    DeliStatus='$sts'
                    WHERE DeliveryID='$txtPurchaseID'
                    ";
        $ret=mysqli_query($connect,$UpdateQty);

    

    $UpdateStatus="UPDATE orders 
                   SET 
                   OrderStatus='$sts'
                   WHERE OrderID='$ordsts' 
                   ";
    $ret=mysqli_query($connect,$UpdateStatus);

    if($ret) //true
    {
        echo "<script>window.alert('Successfully Confirmed!')</script>";
        echo "<script>window.location='orderlist.php'</script>";
    }
    else
    {
        echo "<p>Something went wrong in Purchase Confirmed:" . mysql_error($connect) . "</p>";
    }
}
}


$purid=$_GET['did'];

$query1="SELECT o.*,c.*,od.* FROM orders o,customers c,deliveryorders od
        WHERE od.DeliveryID='$purid' AND o.OrderID=od.OrderID AND o.CustomerID=c.CustomerID
        ";
$result1=mysqli_query($connect,$query1);
$row1=mysqli_fetch_array($result1);








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

<style>
 @media print {
            
    html, body {
                width: 210mm; /* A4 paper width */
                height: 297mm; /* A4 paper height */
                margin: 10mm; /* No margin */
                padding: 0; /* No padding */
            }

            .no-print {
                display: none;
            }
        }
</style>

</head>
<body>
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper">

<div class="header">

<div class="header-left active">
<a href="index.html" class="logo">
<img src="../assets/img/logo.png" alt="">
</a>
<a href="index.html" class="logo-small">
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
<h5><?php echo  $staff['RoleName']; ?></h5>
</div>
</div>

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
<a href="javascript:void(0);"><img src="../assets/img/icons/users1.svg" alt="img"><span>Staffs register</span> <span class="menu-arrow"></span></a>
<ul>

<li>
<a href="supplierlist.php" >Supplier List</a>
</li>
<li>
<a href="addsupplier.php" >Add Suppliers</a>
</li>

</ul>
</li>

<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/product.svg" alt="img"><span>Products</span> <span class="menu-arrow"></span></a>
<ul>


<li>
<a href="productlist.php">Product List</a>
</li>
<li>
<a href="addproduct.php">Add Products</a>
</li>
<li>
<a href="categorylist.php">Category List</a>
</li>
<li>
<a href="addcategory.php" >Add Category</a>
</li>
</ul>
</li>

<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/quotation1.svg" alt="img"><span>Purchase</span> <span class="menu-arrow"></span></a>
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
<a href="orderlist.php">Orders List</a>
</li>
<li>
<a href="customerlist.php" >Add Orders</a>
</li>
<li>
<a href="addcustomers.php" >Add Customers</a>
</li>


</ul>
</li>
<li>
<a href="deliList.php" class="active"><img src="../assets/img/icons/delivery.svg" alt="img"><span>Deliveries</span> </a>
</li>


</ul>
</div>
</div>
</div>

<div class="page-wrapper">
<div class="content">
<div class="page-header">
<div class="page-title">

    <a href="deliList.php" class="btn btn-cancel" style="margin-bottom: 20px;">Back</a>
<h4>Delivery Order Details</h4>
<h6>View delivery info in details</h6>
</div>
</div>
<div class="card">
<div class="card-body">
<div class="card-sales-split">
<h2>Order Code : <?php echo $row1['OrderID'] ?></h2>
<ul>

<li>
<a href="javascript:void(0);"><img src="../assets/img/icons/printer.svg" alt="img" onclick="printPage()"></a>
</li>
</ul>
</div>
<div class="invoice-box table-height" style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">

<table style="width: 100%;line-height: inherit;text-align: left;">
<tbody>
    <tr>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;">
    <font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
    Customer Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <?php echo $row1['CustomerName']; ?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <a href="##" class="__cf_email__" data-cfemail="3a4d5b565117535417594f494e55575f487a5f425b574a565f14595557"><?php echo $row1['Phone']; ?></a></font></font><br>

<br>
</td>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
Order Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Order Code : <?php echo $row1['OrderID']; ?> </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <a href="##" class="__cf_email__" data-cfemail="9ffefbf2f6f1dffae7fef2eff3fab1fcf0f2">Order Date : <?php echo $row1['OrderDate']; ?></a></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Order Status : <?php echo $row1['OrderStatus']; ?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Total Amount : <?php echo $row1['TotalAmount']; ?></font></font><br>
<br>
</td>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">Delivery Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Pick Up Date</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Destination</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Contact to Deliver</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">Payment</font></font><br>
 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Status</font></font><br>
</td>
<td style="padding:5px;vertical-align:top;text-align:right;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">&nbsp;</font></font><br>

<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"> <?php echo $row1['PickUpDate'] ?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"><?php echo $row1['DeliCusAddress'] ?> </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"><?php echo $row1['DeliCusContact'] ?> </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"><?php echo $row1['PaymentTypes'].'/'. $row1['PaymentMethod'] ?> </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"><?php echo $row1['DeliStatus'] ?> </font></font><br>
</td>
</tr>
</tbody>
</table>
</div>
<div class="row" style="margin-top: -80px;">



<form action="deliConfirm.php" method="POST"> 
    <input type="text" name="updDelid" value="<?php echo $row1['DeliveryID'] ?>" readonly hidden>
    <input type="text" name="updOrderID" value="<?php echo $row1['OrderID'] ?>" readonly hidden>
<?php
if ($row1['DeliStatus'] === 'Scheduled') {
?>
<div class="col-lg-3 col-sm-6 col-12">
    <div class="form-group">
        <label>Status</label>
        <select class="select" name="updPurstatus">
            <option disabled>Choose Status</option>
            <option value="Scheduled" selected>Scheduled</option>
            <option value="Delivered">Delivered</option>
            <option value="Failed">Failed</option>
        </select>
    </div>
</div>

<div class="col-lg-12 no-print">
    <input type="submit" class="btn btn-submit me-2" name="btnUpd" value="Update">
</div>
<?php
} elseif ($row1['DeliStatus'] === 'Failed') {
?>
<div class="col-lg-3 col-sm-6 col-12">
    <div class="form-group">
        <label>Status</label>
        <select class="select" name="updPurstatus">
            <option disabled>Choose Status</option>
            <option value="Scheduled">Scheduled</option>
            <option value="Delivered">Delivered</option>
            <option value="Failed" selected>Failed</option>
        </select>
    </div>
</div>

<div class="col-lg-12 no-print">
    <input type="submit" class="btn btn-submit me-2" name="btnUpd" value="Update" disabled>
</div>
<?php
} else {
?>
<div class="col-lg-3 col-sm-6 col-12">
    <div class="form-group">
        <label>Status</label>
        <select class="select" name="updPurstatus">
            <option disabled>Choose Status</option>
            <option value="Scheduled" disabled>Scheduled</option>
            <option value="Delivered" selected disabled>Delivered</option>
            <option value="Failed">Failed</option>
        </select>
    </div>
</div>
<div class="col-lg-12 no-print">
    <input type="submit" class="btn btn-submit me-2" name="btnUpd" value="Update" disabled>
</div>
<?php
}
?>



</form>
</div>
</div>
</div>
</div>
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
                    url: "purchaseconfirm.php",
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

        function printPage() {
    
    window.print();
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