<?php 
session_start();
include('../connect.php');





if (isset($_POST['btnSignin'])) {
    
    $mail=$_POST['logmail'];
    $pass=$_POST['logpass'];
    $check="SELECT * FROM admin WHERE Username='$mail' AND Password='$pass' AND Adminstatus='Active'";
    $run=mysqli_query($connect,$check);
    $count=mysqli_num_rows($run);
    if ($count>0) {
        $data=mysqli_fetch_array($run);
        $admid=$data['AdminID'];
        $_SESSION['aid']=$admid;
        if ($data['Roles']==='Admin') {
            echo "<script>window.alert('Admin Login Successful')</script>";
        
            echo "<script>window.location='stafflist.php'</script>";
            
        }

    }

    else{
        echo "<script>window.alert('Admin account does not exist')</script>";

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
<title>Login - Jelly ICS</title>

<link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">

<link rel="stylesheet" href="../assets/css/bootstrap.min.css">

<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="account-page">
    
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper">
<div class="account-content">
<div class="login-wrapper">
<div class="login-content">
<div class="login-userset">
<div class="login-logo">
<img src="../assets/img/logo.png" alt="img">
</div>
<div class="login-userheading">
<h3>Sign In</h3>
<h4>Please login to your account</h4>
</div>

<form action="signin.php" method="POST">

<div class="form-login">
<label>Email</label>
<div class="form-addons">
<input type="Email" placeholder="Enter your email address" name="logmail" required>
<img src="../assets/img/icons/mail.svg" alt="img">
</div>
</div>
<div class="form-login">
<label>Password</label>
<div class="pass-group">
<input type="password" class="pass-input" placeholder="Enter your password" name="logpass" required >
<span class="fas toggle-password fa-eye-slash"></span>
</div>
</div>

<div class="form-login">
<input type="submit" class="btn btn-login" value="Sign in" name="btnSignin">
</div>

</form>
<div class="signinform text-center">
<h4>Don’t have an account? <a href="signup.php" class="hover-a">Sign Up</a></h4>
</div>


</div>
</div>
<div class="login-img">
<img src="../assets/img/login.jpg" alt="img">
</div>
</div>
</div>
</div>


<script src="../assets/js/jquery-3.6.0.min.js"></script>

<script src="../assets/js/feather.min.js"></script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/script.js"></script>
</body>
</html>