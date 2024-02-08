<?php 
include('../connect.php');
session_start();
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

$sid=$_GET['sid'];

$show="SELECT * FROM staffs WHERE StaffID='$sid'";
$run=mysqli_query($connect,$show);
$row=mysqli_fetch_array($run);




if (isset($_POST['staffsub'])) {
	$staffid=$_POST['stfid'];
	$staffname=$_POST['stfname'];
	$stfUname=$_POST['stfusername'];
	$stfpass=$_POST['stfpsw'];
	$stfreg=$_POST['stfRegdate'];
	$stfrole=$_POST['cboRoles'];
	$stfstatus=$_POST['stfstatus'];

	
	$insert="UPDATE staffs SET Staffname='$staffname' , UserName='$stfUname', Password='$stfpass',RegisteredDate='$stfreg', RoleID='$stfrole', StaffStatus='$stfstatus' WHERE StaffID='$staffid'";

		$result=mysqli_query($connect,$insert);
		if ($result) {
         echo"<script>window.alert('Successful')</script>";
       	echo"<script>window.location='stafflist.php'</script>";
      
	
	
	
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
<li class="submenu">
<a href="javascript:void(0);"><img src="../assets/img/icons/users1.svg" alt="img"><span>Staffs register</span> <span class="menu-arrow"></span></a>
<ul>

	<li>
<a href="stafflist.php" class="active">Staffs List</a>
</li>
<li>
<a href="addstaff.php" > Add Staffs</a>
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

<form action="staffedit.php" method="POST"  >
<div class="page-wrapper">
<div class="content">
<div class="page-header">
<div class="page-title">

<a href="stafflist.php" class="btn btn-cancel">Back</a>



<h4 style="margin-top: 30px;">Update Staff</h4>

</div>
</div>

<div class="card">
<div class="card-body">
<div class="row">

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Staff Name</label>
<input type="text" name="stfname" value="<?php echo $row['StaffName']; ?>" required>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Username</label>
<input type="text" name="stfusername" value="<?php echo $row['UserName']; ?>" required>
</div>
</div>
<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
	<label>Password</label>
<div class="pass-group">
<input type="password" class="pass-input"  value="<?php echo $row['Password']; ?>" name="stfpsw" required>
<span class="fas toggle-password fa-eye-slash"></span>
</div>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
<label>Registered Date</label>
<input type="date" name="stfRegdate" value="<?php echo $row['RegisteredDate']; ?>" required>
</div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
	<div class="form-group">
		<label>Select Staff Roles</label>
<select name="cboRoles" required>

<?php 
$select="SELECT * FROM roles";
$run=mysqli_query($connect,$select);
$count=mysqli_num_rows($run);


for ($i=0; $i < $count; $i++) { 
	
	$ro=mysqli_fetch_array($run);
	$rolID=$ro['RoleID'];
	$rolName=$ro['RoleName'];
	$selected = ($row['RoleID'] == $rolID) ? 'selected' : '';

	echo "<option value='$rolID' $selected>$rolName </option>";
} 


 ?>	

</select>
</div>
</div>


	<div class="col-lg-4 col-sm-6 col-12">
<div class="form-group">
			<label>Active Role?</label>


<?php  

if ($row['StaffStatus']==='Active') {
	

			echo '<input type="radio" name="stfstatus" value="Active" checked>Active

			<input type="radio" name="stfstatus" value="Unactive" style="margin-left: 20px;">Unactive';
			}

			else{

				echo '<input type="radio" name="stfstatus" value="Active">Active

			<input type="radio" name="stfstatus" value="Unactive" style="margin-left: 20px;" checked>Unactive';

			}



			?>

		</div></div>

<input type="text" name="stfid"  value="<?php echo $row['StaffID']; ?>" hidden>


<div class="col-lg-12">
<input type="submit" class="btn btn-submit me-2" name="staffsub">
<input type="reset" class="btn btn-cancel" >
</div>

</div>
</div>
</div>
</div>
</div>
</form>
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