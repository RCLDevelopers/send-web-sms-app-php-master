<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
$user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
error_reporting( ~E_NOTICE ); // avoid notice
if(isset($_POST['mob']) && isset($_POST['msg']))
{


$numbers = $_POST['mob'];
$message = $_POST['username'].":  ".$_POST['msg'];
$message = urlencode($message);
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"https://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=*****&MobileNo=$numbers&SenderID=*********&Message=$message&ServiceName=PROMOTIONAL_HIGH");
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output =curl_exec($ch);

if($output == true)
{
$successMSG = "Message sent Successfully";

}
else{
$errMSG = "message not sent unknown error uccer..";

}

curl_close($ch);
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
function countTextAreaChar(txtarea, l){
var len = $(txtarea).val().length;
if (len > l) $(txtarea).val($(txtarea).val().slice(0, l));
else $('#charNum').text(l - len);
}
</script>
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
<a href="http://websms.mywebdeal.in/profile.php">change username</a>
</li>
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
<form method="post" >
<?php
if(isset($errMSG))
{
?>
<div class="alert alert-danger">
<span class="glyphicon glyphicon-info-sign"></span>
<strong>
<?php echo $errMSG; ?>
</strong>
</div>
<?php
}
else if(isset($successMSG))
{
?>
<div class="alert alert-success">
<strong>
<span class="glyphicon glyphicon-info-sign"></span>
<?php echo $successMSG; ?>
</strong>
</div>
<?php
}
?>
<input type="text" style="display:none;"  name="username" value="
<?php echo $row[userName]; ?>" />
<label >mobile number's with 91</label>
<input type="text" style="width: 280px; height:60px;" class="form-control" name="mob" required="required" />
<br>
<label >Message  
<span style="color:red" id="charNum"></span>
</label>
<textarea type="text" onkeyup="countTextAreaChar(this, 300)"   style="width: 280px; height:150px;" class="form-control"  name="msg" required="required"></textarea>
<br>
<input  type="submit" class="btn btn-primary "  value="Send" id="btn">
<div id="fn" hidden>
<input type="text" style="width: 280px; height:60px;" class="form-control" name="test" />
</div>
</form>


<script type="text/javascript">
$("#btn").click(function() {
$("#fn").show();
$("#ln").show();
});
</script>

</div>
</div>
</div>
<div style="height:300px;"></div>
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="assets/scripts.js"></script>
</body>
</html>