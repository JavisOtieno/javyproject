<?php require_once 'php_action/core.php'; ?>
<?php 
$sqlusers ="SELECT * FROM users WHERE user_id = $userId";
$userResult=$connect->query($sqlusers);
$storeResult=$userResult->fetch_assoc();
$storename=$storeResult['storename'];
$supplier_id=$storeResult['supplier_registered_on'];
$email=$storeResult['email'];
$shop_type=$storeResult['shop_type'];
$validation_status=$storeResult['validation_status'];
$co_ke=$storeResult['.co.ke'];

if($co_ke){
  $website_ke='.co.ke';
}else{
  $website_ke='.av.ke';
}

$phone_verification_status=$storeResult['phone_verification_status'];

if($phone_verification_status==0 && $userId>62010){
  header('location: verify-phone.php');  
}


$sql_supplier_registered_under ="SELECT * FROM suppliers WHERE id = $supplier_id";
$supplierResult=$connect->query($sql_supplier_registered_under);
$supplierResult=$supplierResult->fetch_assoc();
$supplier_name=$supplierResult['name'];
$supplier_username=ucfirst($supplierResult['username']);

date_default_timezone_set("Africa/Nairobi");

?>

<!DOCTYPE html>
<html>
<head>



	<title>Javy | Storename : <?php echo ucfirst($storename); ?></title>
	
	<!--make site responsive on mobile phone-->
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <!--favicon-->
  <link rel="icon" href="http://www.javy.co.ke/images-front/icon.png" />

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
  



  <!-- jquery ui -->  
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">


  <!-- bootstrap and jquery js-->
  <script src="assests/bootstrap/js/bootstrap.min.js"></script>
  <script src="assests/jquery/jquery.min.js"></script>
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  
  <!--Removed because it prevents withdrawals from happening since it interferes with Jquery
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>


  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68172934-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-68172934-6');
</script>
<!--Removed because it prevents withdrawals from happening since it interferes with Jquery
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>


  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
<!------ Include the above in your HEAD tag ---------->


</head>
<body>


	<nav class="navbar navbar-default navbar-static-top">
		<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <a class="navbar-brand" href="#">Brand</a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">    

 

      <ul class="nav navbar-nav navbar-right">        

      	<li id="navDashboard"><a href="dashboard.php"><i class="glyphicon glyphicon-list-alt"></i>  Dashboard</a></li>        
        
        <li id="navBrand"><a href="earnings.php"><i class="glyphicon glyphicon-usd"></i>  Earnings</a></li>        

        <li id="navCategories"><a href="customers.php"> <i class="glyphicon glyphicon-user"></i> Customers</a></li>        

      
       <li class="dropdown" id="navProducts">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-ruble"></i> Products <span class="caret"></span></a>
          <ul class="dropdown-menu">            
           
            <li id="topNavViewProducts"><a href="products.php"> <i class="glyphicon glyphicon-shopping-cart"></i> View Products </a></li> 
             <li id="topNavAddManageProducts"><a href="manage-add-products.php"> <i class="glyphicon glyphicon-edit"></i> Add & Manage Products </a></li>            
          </ul>
        </li>   

        <li id="navOrder"><a href="orders.php?o=manord"> <i class="glyphicon glyphicon-shopping-cart"></i> Orders </a></li>
        <!--<li id="navMessages"><a href="messages.php"> <i class="glyphicon glyphicon-envelope"></i> Messages </a></li>-->

        <li id="navRank"><a href="rank.php"> <i class="fa fa-users"></i> Rank </a></li>

        <li id="navReport"><a href="promote.php"> <i class="glyphicon glyphicon-bullhorn"></i> Promote </a></li>


            <li class="dropdown" id="navSetting">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> Account<span class="caret"></span></a>
          <ul class="dropdown-menu">            
           
            <li id="topNavSetting"><a href="setting.php"> <i class="glyphicon glyphicon-wrench"></i> Settings</a></li> 
             <li id="topNavSetting"><a href="help.php"> <i class="glyphicon glyphicon-question-sign"></i> Help</a></li>            
            <li id="topNavLogout"><a href="logout.php"> <i class="glyphicon glyphicon-log-out"></i> Logout</a></li>            
          </ul>
        </li>    
               
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
	</nav>

	<div class="container">