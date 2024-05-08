<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
$user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
$email = trim($_POST['txtemail']);
$upass = trim($_POST['txtupass']);

if($user_login->login($email,$upass))
{
$user_login->redirect('home.php');
}
}
?><!DOCTYPE html><html><head><title>Send free web sms </title><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"><link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen"><link href="assets/styles.css" rel="stylesheet" media="screen"><script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script></head><body id="login"><div class="container"><?php 
if(isset($_GET['inactive']))
{
?><div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
</div><?php
}
?><form class="form-signin" method="post"><center><img src="images/app.png"><h4 class="form-signin-heading">Sign In.</h4></center><hr /><?php
if(isset($_GET['error']))
{
?><div class='alert alert-warning'><button class='close' data-dismiss='alert'>&times;</button><strong>Invalid UserName Password!</strong></div><?php
}
?><input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required /><input type="password" class="input-block-level" placeholder="Password" name="txtupass" required /><hr /><button class="btn btn-info" type="submit" name="btn-login">Sign In</button><a href="signup.php" style="float:right;" >Sign Up</a><hr /><a href="fpass.php">Lost your Password ? </a></form></div><script src="bootstrap/js/jquery-1.9.1.min.js"></script><script src="bootstrap/js/bootstrap.min.js"></script></body></html>