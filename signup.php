<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
$reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
$uname = trim($_POST['txtuname']);
$email = trim($_POST['txtemail']);
$upass = trim($_POST['txtpass']);
$code = md5(uniqid(rand()));

$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
$stmt->execute(array(":email_id"=>$email));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($stmt->rowCount() > 0)
{
$msg = "

<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry !</strong>  email allready exists , Please Try another one

</div>
";
}
else
{
if($reg_user->register($uname,$email,$upass,$code))
{     
$id = $reg_user->lasdID();    
$key = base64_encode($id);
$id = $key;

$message = "          
Hello $uname,

<br /><br />
Welcome to 
websms.mywebdeal.in !
<br/>
To complete your registration  please , just click following link
<br/><br /><br /><b><a href='http://websms.mywebdeal.in/verify.php?id=$id&code=$code'>Click here to activate your account</a></b><br /><br />
Thanks,";

$subject = "Confirm Registration";

$reg_user->send_mail($email,$message,$subject); 
$msg = "

<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>Success!</strong>  We've sent an email to $email.
Please click on the confirmation link in the email to create your account. 

</div>
";
}
else
{
echo "sorry , Query could no execute...";
}   
}
}
?><!DOCTYPE html><html><head><title>Signup | allvisa.in</title><link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"><link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen"><link href="assets/styles.css" rel="stylesheet" media="screen"><script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script></head><body id="login"><div class="container"><?php if(isset($msg)) echo $msg;  ?><form class="form-signin" method="post"><center><img src="images/app.png"><h4 class="form-signin-heading">SignUp.</h4></center><hr /><input type="text" class="input-block-level" placeholder="Username" name="txtuname" autocomplete="off"   required /><input type="email" class="input-block-level" placeholder="Email address" name="txtemail" autocomplete="off" required /><input type="password" class="input-block-level" placeholder="Password" name="txtpass" autocomplete="off" required /><hr /><button class="btn btn-sm btn-info" type="submit" name="btn-signup">Sign Up</button><a href="index.php" style="float:right;">Sign In</a></form></div><script src="vendors/jquery-1.9.1.min.js"></script><script src="bootstrap/js/bootstrap.min.js"></script></body></html>