<?php
require_once 'class.user.php';
$user = new USER();

if(empty($_GET['id']) && empty($_GET['code']))
{
$user->redirect('index.php');
}

if(isset($_GET['id']) && isset($_GET['code']))
{
$id = base64_decode($_GET['id']);
$code = $_GET['code'];

$stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid AND tokenCode=:token");
$stmt->execute(array(":uid"=>$id,":token"=>$code));
$rows = $stmt->fetch(PDO::FETCH_ASSOC);

if($stmt->rowCount() == 1)
{
if(isset($_POST['btn-reset-pass']))
{
$pass = $_POST['pass'];
$cpass = $_POST['confirm-pass'];

if($cpass!==$pass)
{
$msg = "<div class='alert alert-block'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry!</strong>  Password Doesn't match. 
</div>";
}
else
{
$password = md5($cpass);
$stmt = $user->runQuery("UPDATE tbl_users SET userPass=:upass WHERE userID=:uid");
$stmt->execute(array(":upass"=>$password,":uid"=>$rows['userID']));

$msg = "<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button>
Password Changed.
</div>";
header("refresh:2;index.php");
}
}	
}
else
{
$msg = "<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button>
No Account Found, Try again
</div>";

}


}

?><!DOCTYPE html><html><head><title>Password Reset</title><link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"><link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen"><link href="assets/styles.css" rel="stylesheet" media="screen"></head><body id="login"><div class="container"><div class='alert alert-success'><strong>Hello !</strong><?php echo $rows['userName'] ?> you are here to reset your forgetton password.
</div><form class="form-signin" method="post"><center><img src="images/app.png"><h4 class="form-signin-heading">Reset Password.</h4></center><hr /><?php
if(isset($msg))
{
echo $msg;
}
?><input type="password" class="input-block-level" placeholder="New Password" name="pass" required /><input type="password" class="input-block-level" placeholder="Confirm New Password" name="confirm-pass" required /><hr /><button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Reset Your Password</button></form></div><script src="bootstrap/js/jquery-1.9.1.min.js"></script><script src="bootstrap/js/bootstrap.min.js"></script></body></html>