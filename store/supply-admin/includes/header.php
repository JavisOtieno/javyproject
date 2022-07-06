<?php require_once 'php_action/core.php'; ?>

<!DOCTYPE html>
<html>
<head>

<?php 
date_default_timezone_set("Africa/Nairobi");

$sqlusers ="SELECT * FROM suppliers WHERE id = $userId";
$userResult=$connect->query($sqlusers);
$userResult=$userResult->fetch_assoc();
$username=$userResult['username'];
$email=$userResult['email'];
$authorization_status=$userResult['authorized'];
$website_status=$userResult['website_status'];
$registered_on=$userResult['registered_on'];
$products_type=$userResult['products'];


$co_ke=$userResult['.co.ke'];

if($co_ke){
  $website_ke='.co.ke';
}else{
  $website_ke='.av.ke';
}



?>

	<title>Javy | Supplier : <?php echo ucfirst($username); ?></title>
	
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

  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-68172934-6"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-68172934-6');
</script>


<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '267215030895608');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=267215030895608&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


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
        
        <li id="navBrand"><a href="payments.php"><i class="glyphicon glyphicon-usd"></i>  Payments</a></li>        

        <!--<li id="navCategories"><a href="customers.php"> <i class="glyphicon glyphicon-user"></i> Customers</a></li>  -->      
        <li id="navProduct"><a href="products.php"> <i class="glyphicon glyphicon-ruble"></i> Products </a></li>
       <!-- <li id="navProduct"><a href="product.php"> <i class="glyphicon glyphicon-ruble"></i> Product </a></li> -->    

        <li id="navOrder"><a href="orders.php?o=manord"> <i class="glyphicon glyphicon-shopping-cart"></i> Orders </a></li>
        <!--<li id="navMessages"><a href="messages.php"> <i class="glyphicon glyphicon-envelope"></i> Messages </a></li>-->
        <li id="navCategories"><a href="customers.php"> <i class="glyphicon glyphicon-user"></i> Customers</a></li>  
        <li id="navPromoters"><a href="promoters.php"> <i class="glyphicon glyphicon-user"></i> Promoters</a></li>

        <li id="navReport"><a href="promotions.php"> <i class="glyphicon glyphicon-bullhorn"></i> Promotions </a></li>

        <li class="dropdown" id="navSetting">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> Account<span class="caret"></span></a>
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