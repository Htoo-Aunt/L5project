<?php 
session_start();

include('../connect.php');


if (isset($_POST['btnSign'])) {
  $name=$_POST['AdmName'];
  $admmail=$_POST['AdmEmail'];
  $password=$_POST['admPass'];
  $checkemail="SELECT * FROM admin WHERE Username='$admmail'";
  $result=mysqli_query($connect,$checkemail);
  $count=mysqli_num_rows($result);
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    echo "<script>window.alert('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.')</script>";
    echo"<script>window.location='signup.php'</script>";
    

}
else{


  if ($count>0) {

    echo"<script>window.alert('Username already exist')</script>";
    echo"<script>window.location='signup.php'</script>";
  }

  else{
  $insert="INSERT INTO admin(`Adminname`, `Username`, `Password`, `Roles`, `Adminstatus`) VALUES ('$name','$admmail','$password','Admin','Active')";

  $run=mysqli_query($connect,$insert);

  if ($run) {

    echo"<script>window.alert('Register Successful and please Login!')</script>";
    echo"<script>window.location='signin.php'</script>";
    
  }
  else
  {
    echo "<script>window.alert('Error')</script>";
  }
}
            
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
<title>Sign - Jelly ICS</title>

<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

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
<h3>Create an Account</h3>
<h4>Continue where you left off</h4>
</div>

<form action="signup.php" method="POST" name="admform">

    <div class="form-login">
<label>Admin secret code</label>
<div class="form-addons">
<input type="password" class="pass-input" placeholder="Enter secret code" id="sc" name="AdmCode" onchange="secretCodeValidation(document.admform.AdmCode)" required>
<span class="fas toggle-password fa-eye-slash"></span>
</div>
</div>

<div class="form-login">
<label>Full Name</label>
<div class="form-addons">
<input type="text" placeholder="Enter your full name" name="AdmName" required>
<img src="../assets/img/icons/users1.svg" alt="img">
</div>
</div>
<div class="form-login">
<label>Email</label>
<div class="form-addons">
<input type="email" placeholder="Enter your email address" name="AdmEmail" required>
<img src="../assets/img/icons/mail.svg" alt="img">
</div>
</div>
<div class="form-login">
<label>Password</label>
<div class="pass-group">
<input type="password" class="pass-input" placeholder="At least 8 characters,one upper-case, one number and one special character!!" name="admPass" required>
<span class="fas toggle-password fa-eye-slash"></span>
</div>
</div>

<div class="form-login">
<input type="submit" class="btn btn-login" name="btnSign" value="Sign up">
</div>
<div class="signinform text-center">
<h4>Already a user? <a href="signin.php" class="hover-a">Sign In</a></h4>
</div>
</form>

</div>
</div>
<div class="login-img">
<img src="../assets/img/login.jpg" alt="img">
</div>
</div>
</div>
</div>

<script>
    
function secretCodeValidation(c) {
    

  var cardno = /^(?:4[0-9]{3})$/;
  if(c.value.match(cardno))
        {
            alert("a valid Admin code number!");
      return true;
        }
      else
        {
        alert("Not a valid Admin code number!");
        document.getElementById("sc").value= '';

        return false;
        }
}


</script>

<script src="../assets/js/jquery-3.6.0.min.js"></script>

<script src="../assets/js/feather.min.js"></script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/script.js"></script>
</body>
</html>