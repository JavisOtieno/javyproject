<?php
require('connect.inc.php');

session_start();

   if(!isset($_SESSION['customerId'])) {
  header('location: login.php');    
}else{
  $customerId=$_SESSION['customerId'];
}



if(isset($_GET['id'])){


$orderId=$_GET['id'];
  
				
	$sql_order_update = "UPDATE deals SET payment = 1 WHERE id = {$orderId}";	

  //echo $sql_order_update;
	
	if($connect->query($sql_order_update)){



echo '
<html>
    <head>
        <meta http-equiv="refresh" content="3;url=orders.php" />
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
        <h3 style="margin-left:10px;">Payment confirmed. Redirecting you ...</h3>
    </body>
</html>';

}

}





?>