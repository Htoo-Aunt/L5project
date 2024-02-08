<?php 

session_start();
include('../connect.php');

if (!isset($_SESSION['sid'])) {

echo "<script>window.alert('Please Login First!')</script>";
echo "<script>window.location='stfLogin.php'</script>";


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

$query = "SELECT SUM(totalPurchasePrice) AS total_purchase_amount FROM purchase";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);

$query = "SELECT SUM(TotalAmount) AS total_order_amount FROM orders";
$result2 = mysqli_query($connect, $query);
$row2 = mysqli_fetch_array($result2);

$query = "SELECT * FROM orders";
$result3 = mysqli_query($connect, $query);
$countOrd=mysqli_num_rows($result3);

$query = "SELECT * FROM customers";
$result4 = mysqli_query($connect, $query);
$countCus=mysqli_num_rows($result4);

$query = "SELECT * FROM suppliers";
$result5 = mysqli_query($connect, $query);
$countSup=mysqli_num_rows($result5);

$query = "SELECT * FROM purchase";
$result6 = mysqli_query($connect, $query);
$countPur=mysqli_num_rows($result6);


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
<a href="dashboard.php" class="active"><img src="../assets/img/icons/dashboard.svg" alt="img"><span>Dashboard</span> </a>
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
<a href="productlist.php">Product List</a>
</li>
<li>
<a href="addproduct.php">Add Products</a>
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
<a href="orderlist.php">Orders List</a>
</li>
<li>
<a href="customerlist.php" >Add Orders</a>
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

<div class="page-wrapper">
<div class="content">
    <div class="row">
<div class="col-6">
<div class="dash-widget">
<div class="dash-widgetimg">
<span><img src="../assets/img/icons/dash1.svg" alt="img"></span>
</div>
<div class="dash-widgetcontent">
<h5>$<span class="counters" data-count="<?php echo $row['total_purchase_amount'] ?>"><?php echo $row['total_purchase_amount'] ?></span></h5>
<h6>Total Purchase Amount</h6>
</div>
</div>
</div>

<div class=" col-6">
<div class="dash-widget dash2">
<div class="dash-widgetimg">
<span><img src="../assets/img/icons/dash3.svg" alt="img"></span>
</div>
<div class="dash-widgetcontent">
<h5>$<span class="counters" data-count="<?php echo $row2['total_order_amount'] ?>"><?php echo $row2['total_order_amount'] ?></span></h5>
<h6>Total Sale Amount</h6>
</div>
</div>
</div>


<div class="col-lg-3 col-sm-6 col-12 d-flex">
<div class="dash-count">
<div class="dash-counts">
<h4><?php echo $countCus ?></h4>
<h5>Customers</h5>
</div>
<div class="dash-imgs">
<i data-feather="user"></i>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12 d-flex">
<div class="dash-count das1">
<div class="dash-counts">
<h4><?php echo $countSup ?></h4>
<h5>Suppliers</h5>
</div>
<div class="dash-imgs">
<i data-feather="user-check"></i>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12 d-flex">
<div class="dash-count das2">
<div class="dash-counts">
<h4><?php echo $countPur ?></h4>
<h5>Purchase Invoice</h5>
</div>
<div class="dash-imgs">
<i data-feather="file-text"></i>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12 d-flex">
<div class="dash-count das3">
<div class="dash-counts">
<h4><?php echo $countOrd ?></h4>
<h5>Sales Invoice</h5>
</div>
<div class="dash-imgs">
<i data-feather="file"></i>
</div>
</div>
</div>
</div>
<hr>

<div class="col-12">
<div class="card">
<div class="card-header">
<h5 class="card-title">Analysis Chart</h5>
</div>
<div class="card-body">
<div id="s-line" class="chart-set"></div>
</div>
</div>
</div>
<hr>

<div class="table-responsive">
<table class="table  datanew">
<thead>
    <h3>
        Available Products
    </h3>
<tr>
<th>
<label class="checkboxs">
<input type="checkbox" id="select-all">
<span class="checkmarks"></span>
</label>
</th>
<th>Product ID</th>
<th>Product Name</th>
<th>SKU</th>
<th>Category</th>


</tr>
</thead>
<tbody>

    <?php
$check = "SELECT p.*, c.* FROM products p, category c WHERE p.CategoryID=c.CategoryID";
$run = mysqli_query($connect, $check);

// Initialize user_id outside the loop


while ($row = mysqli_fetch_assoc($run)) {
    // Assign the user_id only once, outside the loop
    

    echo '
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
         <td>' . $row["ProductID"] . '</td>
        <td class="productimgname">
        <a href="" class="product-img">
<img src="' . $row["ProductPhoto"] . ' " alt="product">
</a>
            <a href="javascript:void(0);">' . $row["ProductName"] . '  </a>
        </td>
        <td>' . $row["SKU"] . '</td>
        <td>' . $row["Category"] . '</td>
       
       
       
    </tr>';
}

// Close the MySQLi connection
mysqli_close($connect);
?>

</tbody>
</table>
</div>
</div>
</div>

<hr>
<br>


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
                    url: "addcategory.php",
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
<script src="../assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="../assets/plugins/apexchart/chart-data.js"></script>

<script src="../assets/js/script.js"></script>
</body>
</html>