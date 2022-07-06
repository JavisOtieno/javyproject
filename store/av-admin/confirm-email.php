<?php

require_once 'php_action/db_connect.php';
if(isset($_GET['code']))
{
$codeToVerify=$_GET['code'];
}


$sqlUpdateStatus ="UPDATE users SET validation_status=1 WHERE validation_code='$codeToVerify'";
$connect->query($sqlUpdateStatus);

$sqlUserid ="SELECT user_id FROM users WHERE validation_code='$codeToVerify'";
$connect->query($sqlUserid);

$result=$connect->query($sqlUserid);
while($row=$result->fetch_assoc()){
  $user_id=$row['user_id'];
}


$sqlResetCode ="UPDATE users SET validation_code=' ' WHERE validation_code='$codeToVerify'";
$connect->query($sqlResetCode);


session_start();
// set session
        $_SESSION['userId'] = $user_id;



echo '
<html>
    <head>
        <meta http-equiv="refresh" content="3;url=dashboard.php" />
        <!--make site responsive on mobile phone-->
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <!--favicon-->
  <link rel="icon" href="images-front/icon.png" />

	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">

	<!-- DataTables -->
  <link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">

  <!-- file input -->
  <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">
  

  <!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
  <!-- jquery ui -->  
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <h3 style="margin-left:10px;">Email confirmed. Redirecting you ...</h3>
    </body>
</html>';




?>


