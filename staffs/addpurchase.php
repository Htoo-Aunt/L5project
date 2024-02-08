<?php 

session_start();
include('../connect.php');
include('../AutoID_Functions.php');

//unset($_SESSION['Purchase_Functions']) ;   
 
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
    
} 



if(isset($_GET['action'])) 
{
    $action=$_GET['action'];

    if ($action === 'remove') 
    {
        $ProductID=$_GET['ProductID'];
         $remSize=$_GET['psize'];   
        RemoveProduct($ProductID,$remSize);
    }
    else if($action === 'clearall')
    {
        ClearAll();
    }
}

if (isset($_POST['pursub']) && $_POST['purQtotal'] > 0) {
    $id=$_POST['purid'];
    $date=$_POST['purdate'];
    $supplier=$_POST['cboSupplier'];
    
    $quantity=$_POST['purQtotal'] ;  
    $prc=$_POST['gtotal'];
      $tax=$_POST['Tax'];
      $staff=$_POST['stfid'];
      $Status="Pending";

$sql = "INSERT INTO purchase(`PurchaseID`, `PurchaseDate`, `SupplierID`, `StaffID`, `totalQuantity`, `totalPurchasePrice`, `Tax`,`PurStatus`) VALUES ('$id', '$date','$supplier','$staff','$quantity','$prc','$tax','$Status')";
if ($connect->query($sql) === TRUE) {
    echo "<script>window.alert('Successful')</script>";

   echo "<script>window.location='purchaselist.php'</script>";


} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$size=count($_SESSION['Purchase_Functions']);

    for ($i=0; $i < $size; $i++) 
    { 
        $ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
        $PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
        $PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
        $pursize=$_SESSION['Purchase_Functions'][$i]['ProductSize'];
        $Insert2="INSERT INTO `purchasedetails`(`PurchaseID`, `ProductID`, `Size`, `UnitPrice`, `Quantity`) 
                    VALUES
                  ('$id','$ProductID','$pursize','$PurchasePrice','$PurchaseQuantity')
                  ";
        $result=mysqli_query($connect,$Insert2);

        //Run update statement for product??
    }
    //-----------------------------------------------

    if($result) //true
    {
        unset($_SESSION['Purchase_Functions']);

        echo "<script>window.alert('Successfully Saved!')</script>";
        echo "<script>window.location='purchaselist.php'</script>";
    }
    else
    {
        echo "<p>Something went wrong in purchase form:" . mysql_error($connection) . "</p>";
    }

 

}

elseif (isset($_POST['pursub']) && $_POST['purQtotal'] == 0) {
    
    echo "<script>window.alert('There is something wrong with your purchase submission!!')</script>";
      header('Refresh: 0');

}

function CalculateTotalQuantity()
{
    if(isset($_SESSION['Purchase_Functions'])) 
    {
        $TotalQuantity=0;

        $size=count($_SESSION['Purchase_Functions']);

        for ($i=0; $i < $size; $i++) 
        { 
            $PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
            $TotalQuantity += ($PurchaseQuantity);
        }

        return $TotalQuantity;
    }
    else
    {
        $TotalQuantity=0;

        return $TotalQuantity;
    }
}

function CalculateTotalAmount()
{
    if(isset($_SESSION['Purchase_Functions'])) 
    {
        $TotalAmount=0;

        $size=count($_SESSION['Purchase_Functions']);

        for ($i=0; $i < $size; $i++) 
        { 
            $PurchaseQuantity=$_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'];
            $PurchasePrice=$_SESSION['Purchase_Functions'][$i]['PurchasePrice'];
            $TotalAmount += ($PurchaseQuantity * $PurchasePrice);
        }

        return $TotalAmount;
    }
    else
    {
        $TotalAmount=0;

        return $TotalAmount;
    }
}


function IndexOf($ProductID,$prosize)
{
    if(!isset($_SESSION['Purchase_Functions'])) 
    {
        return -1;
    }

    if(isset($_SESSION['Purchase_Functions'])) 
    {
        $size=count($_SESSION['Purchase_Functions']);

        if ($size < 1) 
        {
            return -1;
        }
        else
        {
            for ($i=0; $i < $size; $i++) 
            { 
                if($ProductID == $_SESSION['Purchase_Functions'][$i]['ProductSKU'] AND $prosize == $_SESSION['Purchase_Functions'][$i]['ProductSize']) 
                {
                    return $i;
                }
            }
            return -1;
        }
    }
}

function RemoveProduct($ProductID,$Rsize)
{
    $Index=IndexOf($ProductID,$Rsize);

    unset($_SESSION['Purchase_Functions'][$Index]);

    $_SESSION['Purchase_Functions']=array_values($_SESSION['Purchase_Functions']);

    echo "<script>window.location='addpurchase.php'</script>";
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
<div class="dropdown-menu menu-drop-user" >
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
<a href="productlist.php">Product List</a>
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
<a href="addpurchase.php" class="active">Add Purchase</a>
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
<a href="orderist.php">Orders List</a>
</li>
<li>
<a href="customerlist.php"  >Add Orders</a>
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


<form action="addpurchase.php" method="POST" enctype="multipart/form-data" >
<div class="page-wrapper">
<div class="content">
<div class="page-header">
<div class="page-title">
<h4>Purchase</h4>
<h6>Create new Purchase record</h6>
</div>
</div>

<div class="card">
<div class="card-body">


<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Purchase ID</label>
<input type="text" name="purid" value="<?php echo AutoID('purchase','PurchaseID',2) ?>"  readonly>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Purchase Date</label>
<input type="date" id="pd" name="purdate" required>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Staff Info</label>
<input type="text" name="proname" value="<?php echo  $staff['StaffName']; ?>" required readonly>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Select Suppliers</label> 
<select class="form-control"  name="cboSupplier" required>
                    
                                        <?php
                                        $result = mysqli_query($connect, "SELECT * FROM suppliers WHERE supstatus='Active' ");
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <option value="<?php echo $row['SupplierID']; ?>"><?php echo $row["SupplierID"]; ?> - <?php echo $row["Bname"]; ?> - <?php echo $row["Pname"]; ?> - <?php echo $row["Location"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
</div>
</div>

<hr style=" border: 1px dashed black;">


<div class="col-lg-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Select Product</label>
<select class="form-control" id="category-dropdown" name="cboProduct">
                    <option value="">Select Product</option>
                                        <?php
                                        $result = mysqli_query($connect, "SELECT * FROM products ");
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <option value="<?php echo $row['ProductID']; ?>"><?php echo $row["ProductName"]; ?> - <?php echo $row["SKU"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
</div>
</div>


<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
                                    <label for="SUBCATEGORY">Size</label>
                                    <select class="form-control" id="sub-category-dropdown">
                                        <option value="">Select Size</option>
                                    </select>
                                </div>
                            </div>


<div class="col-lg-4 col-sm-6" >
<div class="form-group">
<label>Purchased Unit Price</label>

<input type="text" name="txtUnitPrice" id="pup">

</div>
</div>

<div class="col-lg-4">
<div class="form-group">
<label>Purchased quantity</label>

<input type="number" id="pqt" name="txtPurchaseQty" >


</div>
</div>

<div>

<input class="btn btn-primary btn-sm" type="submit" name="btnAdd" onclick="addproduct()" value="Add Product">

</div>

<hr style=" border: 1px dashed black;">

<?php  
if(!isset($_SESSION['Purchase_Functions'])) 
{
    echo "<p>No Record Found!</p>";
}
else{
?>

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
<th>ID</th>
<th>Product Name</th>
<th>Category</th>
<th>Size</th>
<th>SKU</th>
<th>Purchaseprice</th>
<th>Quantity</th>
<th>Actions</th>

</tr>
</thead>
<tbody>

    <?php


$size=count($_SESSION['Purchase_Functions']);


for ($i=0; $i < $size; $i++) 
    { 
        $ProductID=$_SESSION['Purchase_Functions'][$i]['ProductID'];
        $ProductImage1=$_SESSION['Purchase_Functions'][$i]['ProductImage1'];
        $pname=$_SESSION['Purchase_Functions'][$i]['ProductSKU'];
        $psize=$_SESSION['Purchase_Functions'][$i]['ProductSize'];

    echo '

 
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
         <td>'.$ProductID.'</td>
        <td class="productimgname">
        <a href="" class="product-img">
<img src="' . $ProductImage1 . ' " alt="product">
</a>
            <a href="javascript:void(0);">' . $_SESSION['Purchase_Functions'][$i]['ProductName'] . '  </a>
        </td>
        <td>' . $_SESSION['Purchase_Functions'][$i]['ProductCategory'] . '</td>
        <td>' . $_SESSION['Purchase_Functions'][$i]['ProductSize'] . '</td>
        <td>' . $_SESSION['Purchase_Functions'][$i]['ProductSKU'] . '</td>
         <td>' . $_SESSION['Purchase_Functions'][$i]['PurchasePrice'] . '</td>
         <td>' . $_SESSION['Purchase_Functions'][$i]['PurchaseQuantity'] . '</td>
       
       
        <td>
     
            
            <a class="me-3 confirm" name="btndel"  href="addpurchase.php?action=remove&ProductID='.$pname.'&psize='.$psize.'" >
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


<hr style=" border: 1px dashed black;">
<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Total Quantity</label>
<input type="number" name="purQtotal" id="ptotalq" value="<?php echo CalculateTotalQuantity(); ?>" readonly required>
</div>
</div>
<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Total Purchase Price</label>
<input type="number" name="purPtotal" id="ptotalp" value="<?php echo CalculateTotalAmount(); ?>" readonly required>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Tax</label>
<input type="number" name="Tax" id="tax" value="<?php echo CalculateTotalAmount()*0.05; ?>" readonly required>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Grand Total</label>
<input type="number" name="gtotal"  id="gtotal" value="<?php echo CalculateTotalAmount()+(CalculateTotalAmount()*0.05); ?>" readonly required>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group" hidden>
<label>Available Sizes</label>
<input type="text" name="stfid" id="psid" value="<?php echo $_SESSION['sid'] ?>" readonly required >
</div>
</div>






<div class="col-lg-12">
<input type="submit" class="btn btn-submit me-2" name="pursub">
<input type="reset" class="btn btn-cancel" >
</div>

</div>
</div>


</div>

</div>
</form>
</div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"  crossorigin="anonymous"></script>

<script>

 $(document).ready(function() {
                $('#category-dropdown').on('change', function() {
                    var category_id = this.value;
                    $.ajax({
                        url: "pursize.php",
                        type: "POST",
                        data: {
                            category_id: category_id
                        },
                        cache: false,
                        success: function(result) {
                            $("#sub-category-dropdown").html(result);

                        }
                    });
                });
            });


function addproduct() {
    
    var selectedCategory = $('#category-dropdown').val();
    var selectedSize = $('#sub-category-dropdown').val();
    var seprice=$('#pup').val();
    var seqty=$('#pqt').val();

    // AJAX request to insert values into the database
    $.ajax({
        url: 'addtocart.php',
        method: 'POST',
        data: {
           
            category: selectedCategory,
            size: selectedSize,
            price: seprice,
            qty: seqty
        },
        success: function(response) {
             
            location.reload();

        }
    });
}





	 function confirmLog() {
           
            var confirmMessage = "Are you sure you want to Log out!!" ;
            
            // Show the confirmation dialog
            var userConfirmed = confirm(confirmMessage);

            // Send the confirmation result to the server using AJAX
            if (userConfirmed) {
                $.ajax({
                    type:"POST",
                    url: "addsupplier.php",
                    data: { confirmation: "confirmed" },
                    success:function(response) {
               if(response){ 

                    
                    window.location.href = "stfLogin.php";

                }
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