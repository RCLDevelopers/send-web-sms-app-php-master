<?php
session_start();
require_once 'class.user.php';
$user_pro = new USER();

if(!$user_pro->is_logged_in())
{
$user_pro->redirect('index.php');
}
$stmt = $user_pro->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

error_reporting( ~E_NOTICE ); // avoid notice

if(isset($_POST['update']))
{

$userName = $_POST['name'];


if(!isset($errMSG))
{
$stmt = $user_pro->runQuery("UPDATE tbl_users SET userName=:name WHERE userID=:id");
$stmt->bindParam(":name",$userName);
$stmt->bindParam(":id",$row[userID]);
if($stmt->execute())
{
$successMSG = "update Successfully";
header('refresh:1;  home.php');
}
else
{
$errMSG = "error something wrong ! please try later...";
}
}
}
?>
<!DOCTYPE html>
<html class="no-js">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
<?php echo $row['userEmail']; ?>
</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="assets/styles.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery-1.5.js"></script>

</head>
<body>
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container-fluid">
<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</a>
<a class="brand" href="http://websms.mywebdeal.in/home.php">
<small>Welcome  
<b>
<?php echo $row['userName']; ?>
</b>
</small>
</a>
<div class="nav-collapse collapse">
<ul class="nav pull-right">
<li class="dropdown">
<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
<i class="icon-user"></i>
<?php echo $row['userName']; ?>
<i class="caret"></i>
</a>
<ul class="dropdown-menu">
<li>
<a tabindex="-1" href="logout.php">Logout</a>
</li>
</ul>
</li>
</ul>
<ul class="nav">
<li>
<a href="http://websms.mywebdeal.in/logout.php">Logout</a>
</li>
</ul>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-sm-12">
<img src="images/sms.png">
<div class="panel panel-body" style="padding: 20px 20px 20px 20px; height: auto; width: 90%; background-color: #eee !important; color: black !important;">

<?php
if(isset($errMSG))
{
?>
<div class="alert alert-danger">
<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
</div>
<?php
}
else if(isset($successMSG))
{
?>
<div class="alert alert-success">
<strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
</div>
<?php
}
?>
<form method="post" >
<label >Update username</label>
<input type="text"  class="form-control" name="name" value="<?php echo $row[userName] ;?>" required="required" />
<br>
<input  type="submit" class="btn btn-primary" name="update"  value="update">
</form>
</div>
</div>
</div>
<div style="height:300px;"></div>
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="assets/scripts.js"></script>
</body>
</html>