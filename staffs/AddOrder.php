<?php 

session_start();
include('../connect.php');
include('orderPurchaseFunction.php');
include('../AutoID_Functions.php');

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


if (isset($_SESSION['customer_id'])) {  



    $cusID=$_SESSION['customer_id'];

    $run="SELECT * FROM customers WHERE CustomerID='$cusID'";
    $cusrun=mysqli_query($connect,$run);
    $cus=mysqli_fetch_array($cusrun);

}



if(isset($_GET['Ivid'])) 
{
    $InvID=$_GET['Ivid'];
    AddProduct($InvID);

    
}

if(isset($_GET['action'])) 
{
    $action=$_GET['action'];

    if ($action === 'remove') 
    {
        $ProductID=$_GET['ProductID'];
        RemoveProduct($ProductID);
    }
    else if($action === 'dec')
    {

        $ProductID=$_GET['ProductID'];
        DecreaseCartItem($ProductID);
    }

    else if($action === 'inc')
    {

        $ProductID=$_GET['ProductID'];
        IncreaseCartItem($ProductID);
    }
}



$check="SELECT i.*,p.* FROM inventory i,products p WHERE i.ProductID=p.ProductID AND i.Quantity>0";
$run=mysqli_query($connect,$check);


if (isset($_POST['ordsub']) && $_POST['Totalqty'] > 0) {

   
    $orderID=$_POST['ordid'];
    $date=$_POST['ordDate'];
    $ttAmount=$_POST['TotalAmount'];
    $staff=$_POST['stfid'];
    $cus=$_POST['ordCusID'] ;  
    
      
      $Status="Pending";

$sql = "INSERT INTO orders(`OrderID`,`OrderDate`, `TotalAmount`, `StaffID`, `OrderStatus`, `CustomerID`) VALUES( '$orderID','$date', '$ttAmount','$staff','$Status','$cus')";

if ($connect->query($sql) === TRUE) {
    echo "<script>window.alert('Successful')</script>";

   echo "<script>window.location='customerlist.php'</script>";

} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$size=count($_SESSION['Order_Functions']);

    for ($i=0; $i < $size; $i++) 
    { 
        $ProductID=$_SESSION['Order_Functions'][$i]['InventoryID'];
        $ordPrice=$_SESSION['Order_Functions'][$i]['OrderQuantity'];
        
        $Insert2="INSERT INTO orderdetails(`InvID`, `OrderID`, `quantity`) VALUES
                  ('$ProductID','$orderID','$ordPrice')
                  ";
        $result=mysqli_query($connect,$Insert2);

        //Run update statement for product??
    }
    //-----------------------------------------------

    if($result)
    {
        unset($_SESSION['Order_Functions']);

        echo "<script>window.alert('Successfully Saved!')</script>";
        echo "<script>window.location='customerlist.php'</script>";
    }
    else
    {
        echo "<p>Something went wrong in purchase form:" . mysql_error($connection) . "</p>";
    }

 

}

elseif (isset($_POST['ordsub']) && $_POST['Totalqty'] == 0) {
    
    echo "<script>window.alert('There is something wrong with your order submission!!')</script>";
     echo "<script>window.location='AddOrder.php'</script>";

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
<h5><?php echo $staff['RoleName']; ?></h5>
</div>
</div>

<hr class="m-0">
<a class="dropdown-item logout pb-0"  onclick="confirmLog();"><img src="../assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
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
<li>
<a href="sizeList.php">Size List</a>
</li>
<li>
<a href="addsize.php" >Add Sizes</a>
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
<a href="inventoriesList.php" class="active">Inventories List</a>

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
<a href="customerlist.php"  class="active">Add Orders</a>
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
<div class="page-header">
<div class="page-title">

<a href="customerlist.php" class="btn btn-cancel" style="margin-bottom: 20px;">Back</a>

<h4>Create Order</h4>

</div>

</div>


<form action="AddOrder.php" method="POST">

<div class="card">
<div class="card-body">

    <div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Order ID</label>
<input type="text" name="ordid" value="<?php echo AutoID('orders','OrderID',1) ?>"  readonly>
</div>
</div>
<h4>
    Customer Info
</h4>
<br> 
<input type="text" name="ordCusID" value="<?php echo $cus['CustomerID'] ?>" hidden>



    <div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Customer Name</label>
<input type="text" name="Ordcusname" value="<?php echo  $cus['CustomerName']; ?>" required readonly>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Contact</label>
<input type="text" name="OrdcusCon" value="<?php echo  $cus['Phone']; ?>" required readonly>
</div>
</div>


<hr>
<br>
<div class="table-top">
<h3>Available Products</h3>
<div class="search-set">

<div class="search-input">
<a class="btn btn-searchset"><img src="../assets/img/icons/search-white.svg" alt="img"></a>
</div>
</div>

</div>



<div class="table-responsive">
<table class="table  datanew">
<thead>
<tr>
<th>
<label class="checkboxs">
<input type="checkbox" id="select-all">
<span class="checkmarks"></span>
</label>
</th>

<th>Products</th>
<th>SKU</th>
<th>Size</th>
<th>Quantity</th>
<th>Unit Selling Price</th>
<th>Action
</th>




</tr>
</thead>
<tbody>

    <?php  
    while ($row= mysqli_fetch_array($run)) {



    

    echo'
<tr>
<td>
<label class="checkboxs">
<input type="checkbox">
<span class="checkmarks"></span>
</label>
</td>

 
        <td class="productimgname">
        <a href="" class="product-img">
<img src="' . $row["ProductPhoto"] . ' " alt="product">
</a>
            <a href="javascript:void(0);">' . $row["ProductName"] . '  </a>
        </td>
        <td>' . $row["SKU"] . '</td>
        <td>' . $row["Size"] . '</td>
        <td>' . $row["Quantity"] . '</td>
        <td>' . $row["SellingPrice"] . '</td>
<td> <a class="me-3" href="AddOrder.php?Ivid=' . $row["InvID"] . '">
<img src="../assets/img/icons/Plu.svg" alt="img" width="25">
</a>  </td>



</tr>';
}
?>

</tbody>
</table>
</div>

<br>
<hr>
<br>
<?php  
if(!isset($_SESSION['Order_Functions'])) 
{
    echo "<p>No Record Found!</p>";
}
else{
?>

<div class="table-responsive">
    <h3>
        Chosen Products
    </h3>
<table class="table  datanew">
<thead>
<tr>
<th>
<label class="checkboxs">
<input type="checkbox" id="select-all">
<span class="checkmarks"></span>
</label>
</th>

<th>Product Name</th>
<th>Size</th>
<th>SKU</th>
<th>Unit price</th>
<th>Quantity</th>
<th>Actions</th>

</tr>
</thead>
<tbody>

    <?php


$size=count($_SESSION['Order_Functions']);


for ($i=0; $i < $size; $i++) 
    { 
        $ProductID=$_SESSION['Order_Functions'][$i]['InventoryID'];
        $ProductImage1=$_SESSION['Order_Functions'][$i]['ProductImage1'];
        

    echo '

 
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
         
        <td class="productimgname">
        <a href="" class="product-img">
<img src="' . $ProductImage1 . ' " alt="product">
</a>
            <a href="javascript:void(0);">' . $_SESSION['Order_Functions'][$i]['ProductName'] . '  </a>
        </td>
                <td>' . $_SESSION['Order_Functions'][$i]['ProductSize'] . '</td>
        <td>' . $_SESSION['Order_Functions'][$i]['ProductSKU'] . '</td>
         <td>' . $_SESSION['Order_Functions'][$i]['SellPrice'] . '</td>
         <td><a class="me-3 confirm" name="btndel"  href="AddOrder.php?action=dec&ProductID= '.$ProductID.'" >
                <img src="../assets/img/icons/min.svg" alt="img" width="12">
            </a> ' . $_SESSION['Order_Functions'][$i]['OrderQuantity'] . '<a class="me-3 confirm" name="btndel"  href="AddOrder.php?action=inc&ProductID= '.$ProductID.'" >
                <img src="../assets/img/icons/Plu.svg" alt="img" width="15" style="margin-left:10px; margin-top:3px; ">
            </a></td>
       
       
        <td>

        
     
            
            <a class="me-3 confirm" name="btndel"  href="AddOrder.php?action=remove&ProductID= '.$ProductID.'" >
                <img src="../assets/img/icons/delete.svg" alt="img">
            </a>
        </td>
    </tr>';

}
// Close the MySQLi connection
mysqli_close($connect);
?>

</tbody>
</table>
</div>


<?php  
}
?>
<hr>
<br>


<div class="form-group">
        <label>Total Amount</label>

        <input type="number" name="TotalAmount" value="<?php echo CalculateTotalAmount() ?>" readonly /> USD
    </div>

    <div class="form-group">
        
    
    <label>Total Quantity</label>

        <input type="number" name="Totalqty" value="<?php echo CalculateTotalQuantity() ?>" readonly /> Pcs
    </div>


    <div class="form-group">
         <label>Order Date</label> 
        <input type="date" name="ordDate" required>
    </div>

    <input type="number" name="stfid" value="<?php echo $_SESSION['sid'] ?>" hidden>

    <div class="col-lg-12">
<input type="submit" class="btn btn-submit me-2" name="ordsub">
<input type="reset" class="btn btn-cancel" >
</div>

</div>
</div>
</form>

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
                    url: "AddOrder.php",
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

<script src="../assets/js/script.js"></script>
</body>
</html>