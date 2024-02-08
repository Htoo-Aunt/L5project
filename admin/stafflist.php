<?php 

session_start();
include('../connect.php');



if (!isset($_SESSION['aid'])) {

echo "<script>window.alert('Please Login First!')</script>";
echo "<script>window.location='signin.php'</script>";


}

function logout() {
     
     unset($_SESSION['aid']);

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






if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirmation = $_POST['confirmation'];
    $sessionId = $_POST['session_id'];

    if ($confirmation === 'delete') {
      $del="DELETE FROM staffs WHERE StaffID='$sessionId' ";

	  $run=mysqli_query($connect,$del);
       // echo "<script>window.location='stafflist.php'</script>";

    } 
    else {
        // Handle the case where the user canceled
        echo "User canceled. No action taken.";
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
<a href="stafflist.php" class="logo">
<img src="../assets/img/logo.png" alt="">
</a>
<a href="stafflist.php" class="logo-small">
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

    $tempaid=$_SESSION['aid'];
    $admQuery="SELECT * FROM admin WHERE AdminID='$tempaid'";
    $admrun=mysqli_query($connect,$admQuery);
    $admin=mysqli_fetch_array($admrun);


     ?>
<h6><?php echo $admin['Adminname']; ?></h6>
<h5><?php echo $admin['Roles']; ?></h5>
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

<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/users1.svg" alt="img"><span>Staffs register</span> <span class="menu-arrow"></span></a>
<ul>
	<li>
<a href="stafflist.php" class="active">Staffs List</a>
</li>
<li>
<a href="addstaff.php"> Add Staffs</a>
</li>

<li>
<a href="addroles.php"> Add roles</a>
</li>
<li>
<a href="roleslist.php">Roles list</a>
</li>
</ul>
</li>


</ul>
</div>
</div>
</div>

<div class="page-wrapper">
<div class="content">
<div class="page-header">
<div class="page-title">
<h4>Staffs list</h4>
<h6>View/Search Staffs</h6>
</div>
<div class="page-btn">
<a href="addstaff.php" class="btn btn-added">
<img src="../assets/img/icons/plus.svg" class="me-1" alt="img" width="30px">Add Staff
</a>
</div>
</div>

<div class="card">
<div class="card-body">
<div class="table-top">
<div class="search-set">
<div class="search-path">

</div>
<div class="search-input">
<a class="btn btn-searchset"><img src="../assets/img/icons/search-white.svg" alt="img"></a>
</div>
</div>
<div class="wordset">
<ul>
    <li>
<a data-bs-toggle="tooltip" data-bs-placement="top" title="print" onclick="printPage()"><img src="../assets/img/icons/printer.svg" alt="img"></a>
</li>

</ul>
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
<th>Staff name</th>
<th>Username</th>
<th>Password</th>
<th>Registered Date</th>
<th>Status</th>
<th>Role</th>
<th>Actions</th>

</tr>
</thead>
<tbody>

	<?php
$check = "SELECT s.*, r.* FROM staffs s, roles r WHERE s.RoleID=r.RoleID";
$run = mysqli_query($connect, $check);

// Initialize user_id outside the loop
$_SESSION['user_id'] = '';

while ($row = mysqli_fetch_assoc($run)) {
    // Assign the user_id only once, outside the loop
    $_SESSION['user_id'] = $row['StaffID'];

    echo '
    <tr>
        <td>
            <label class="checkboxs">
                <input type="checkbox">
                <span class="checkmarks"></span>
            </label>
        </td>
        <td class="productimgname">
            <a href="javascript:void(0);">' . $row["StaffName"] . '  </a>
        </td>
        <td>' . $row["UserName"] . '</td>
        <td>' . $row["Password"] . '</td>
        <td>' . $row["RegisteredDate"] . '</td>
        <td>' . $row["StaffStatus"] . '</td>
        <td>' . $row["RoleName"] . '</td>
        <td>
            <a class="me-3" href="staffedit.php?sid=' . $row["StaffID"] . '">
                <img src="../assets/img/icons/edit.svg" alt="img">
            </a>
            <a class="me-3 confirm" name="btndel" onclick="confirmDelete(' . $row["StaffID"] . ');">
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
</div>
</div>

</div>
</div>
</div>


<script>
	 
 function confirmDelete(staffID) {
           
            var confirmMessage = "Are you sure you want to delete this";
            
            // Show the confirmation dialog
            var userConfirmed = confirm(confirmMessage);

            // Send the confirmation result to the server using AJAX
            if (userConfirmed) {
                $.ajax({
                    type:"POST",
                    url: "stafflist.php",
                    data: { confirmation: "delete", session_id: staffID },
                    success: function(html) {
                        location.reload();
                    }
                });
            } else {
                // Handle the case where the user canceled
                alert("User canceled. No action taken.");
            }
        }


        function confirmLog() {
           
            var confirmMessage = "Are you sure you want to Log out!!" ;
            
            // Show the confirmation dialog
            var userConfirmed = confirm(confirmMessage);

            // Send the confirmation result to the server using AJAX
            if (userConfirmed) {
                $.ajax({
                    type:"POST",
                    url: "stafflist.php",
                    data: { confirmation: "confirmed" },
                    success:function(response) {
               if(response){ // check whether response is received
                    window.location.href = "signin.php";}
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