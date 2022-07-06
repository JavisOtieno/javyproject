<?php require_once 'includes/header.php'; ?>

<?php 

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;


$sqldeals="SELECT * FROM deals WHERE dealer_id='$userId'";
$dealsResult=$connect->query($sqldeals);
$countDeals=$dealsResult->num_rows;

$sqlcustomers="SELECT * FROM customers WHERE dealerid='$userId'";
$customersResult=$connect->query($sqlcustomers);
$countCustomers=$customersResult->num_rows;

$sqlCompleteDeals="SELECT * FROM deals WHERE dealer_id='$userId' AND status=1";
$completeDealsResult=$connect->query($sqlCompleteDeals);
$countCompleteDeals=$completeDealsResult->num_rows;




$sqlearnings= "SELECT product_profit FROM deals WHERE status=1 AND dealer_id=$userId";
$result=$connect->query($sqlearnings);
$totalRevenue=0;
while($row=$result->fetch_assoc()){
	$totalRevenue += $row['product_profit'];
}


$sqlwebvisits="SELECT web_visits FROM users WHERE user_id='$userId'";
$result=$connect->query($sqlwebvisits);
while($row=$result->fetch_assoc()){
	$web_visits=$row['web_visits'];
}

$sqlwithdrawals="SELECT amount FROM withdrawals WHERE user_id='$userId' AND (status=0 OR status=1)";
$result=$connect->query($sqlwithdrawals);
$totalWithdrawals=0;
while($row=$result->fetch_assoc()){
	$totalWithdrawals +=$row['amount'];
}

$availableEarnings=$totalRevenue-$totalWithdrawals;


$sqlProductMessages="SELECT * FROM product_messages WHERE dealer_id='$userId'";
$result=$connect->query($sqlProductMessages);
$numberofproductmessages=$result->num_rows;

$sqlContactMessages= "SELECT * FROM customer_contact_forms WHERE dealer_id=$userId";
$result=$connect->query($sqlContactMessages);
$numberofcontactmessages=$result->num_rows;

$totalnumberofmessages=$numberofproductmessages+$numberofcontactmessages;



?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">



<div id="AndroidApp">
			
		</div> 


<?php

if($validation_status==1) {
echo "<!--";
}else{
	
}
?>

    	<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-envelope"></i> Confirm Email</div>
			</div>
			<div class="panel-body">

			Congratulations on your new account! Kindly confirm your email address by checking the email we've sent you on <strong><?php echo $email ?></strong>.<br/><br/>

			If you do not receive the email message from Javy, check and make sure the message has not been filtered as spam. 

			</div> 
		</div> 	

		<?php
if($validation_status==1) {
echo "-->";
}else{
	
}
?>






<div class="row">
	
	<div class="col-md-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Total Sales
					<span class="badge pull pull-right"><?php echo $countDeals; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

		<div class="col-md-4">
			<div class="panel panel-success">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Successful Sales
					<span class="badge pull pull-right"><?php echo $countCompleteDeals; ?></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<a href="customers.php" style="text-decoration:none;color:black;">
					Customers
					<span class="badge pull pull-right"><?php echo $countCustomers; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-4">
	
		<div class="card">
		<a href="<?php echo 'http://'.$storename.$website_ke; ?>" target="_blank">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php echo ' View Website'//echo date('d'); ?></h1>
		  </div></a> 

		  <div class="cardContainer">
		    <p><?php echo 'Copy link:  http://www.'.$storename.$website_ke; //date('l') .' '.date('d').', '.date('Y'); ?></p>
		  </div>
		</div>
		
		<br/>

		<div class="card">
		  <div class="cardHeader" >
		    <h1><?php echo number_format($web_visits); ?>
		    	</h1>
		  </div>

		  <div class="cardContainer">
		    <p>Website Visits</p>
		  </div>
		</div> 
		<br/>

			<div class="card">
		  <div class="cardHeader" style="background-color:#F27800;">
		    <h1><?php if($totalRevenue) {
		    	echo number_format($totalRevenue);
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-usd"></i> Total Earnings to date</p>
		  </div>
		</div> 

		<br/>

		<div class="card">
		  <div class="cardHeader" >
		    <h1><?php if($availableEarnings) {
		    	echo number_format($availableEarnings);
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-usd"></i> Earnings available</p>
		  </div>
		</div>

		<br/>

		<!--<div class="card" >
			<a href="messages.php">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php //echo number_format($totalnumberofmessages); ?>
		    	</h1>
		  </div>

		  <div class="cardContainer">
		    <p>Messages received on website</p>
		  </div></a>
		</div> -->

	</div>




	<div class="col-md-8">
	<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-th-list"></i> Offers</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

	<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
    <li data-target="#myCarousel" data-slide-to="4"></li>
  </ol>



  <!-- Wrapper for slides -->
  <div class="carousel-inner">

  		<?php
$sql="SELECT * FROM offers2 WHERE on_slider=1 AND status=1 ORDER BY id DESC LIMIT 5";
$result=$connect->query($sql);
$count=0;

while ($row=$result->fetch_assoc()){

	$offer_id=$row['id'];
	$title=$row['title'];
	$image_url=$row['image'];
	if($image_url==''){
		$image_url=$row['original_image'];
	}
	$product_id=$row['product_id'];

	if($count==0){
	echo '<div class="item active">';
}else{
	echo '<div class="item">';
}
      echo '<a href="promote.php#offer'.$offer_id.'"><img style="width:100%;" src="'.$image_url.'" alt="'.$title.'" ></a>
    </div>
';


$count=1;

}
?>
    
  

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>
</div>
</div>
<br/>

<style type="text/css">
	@import url(http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css);
.col-item
{
    border: 1px solid #E1E1E1;
    border-radius: 5px;
    background: #FFF;
}
.col-item .photo img
{
    margin: 0 auto;
    width: 100%;
}

.col-item .info
{
    padding: 10px;
    border-radius: 0 0 5px 5px;
    margin-top: 1px;
}

.col-item:hover .info {
    background-color: #F5F5DC;
}
.col-item .price
{
    /*width: 50%;*/
    float: left;
    margin-top: 5px;
}

.col-item .price h5
{
    line-height: 20px;
    margin: 0;
}

.price-text-color
{
    color: #219FD1;
}

.col-item .info .rating
{
    color: #777;
}

.col-item .rating
{
    /*width: 50%;*/
    float: left;
    font-size: 17px;
    text-align: right;
    line-height: 52px;
    margin-bottom: 10px;
    height: 52px;
}

.col-item .separator
{
    border-top: 1px solid #E1E1E1;
}

.clear-left
{
    clear: left;
}

.col-item .separator p
{
    line-height: 20px;
    margin-bottom: 0;
    margin-top: 10px;
    text-align: center;
}

.col-item .separator p i
{
    margin-right: 5px;
}
.col-item .btn-add
{
    width: 50%;
    float: left;
}

.col-item .btn-add
{
    border-right: 1px solid #E1E1E1;
}

.col-item .btn-details
{
    width: 50%;
    float: left;
    padding-left: 10px;
}
.controls
{
    margin-top: 20px;
}
[data-slide="prev"]
{
    margin-right: 10px;
}

</style>



	<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-shopping-cart"></i> Recent Orders</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>#</th>
							<th>Client</th>
							<th>Product</th>
							<th style="width:15%;">Profit</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqldeals="SELECT * FROM deals WHERE dealer_id='$userId' ORDER BY id DESC LIMIT 5 ";
						$dealsResult=$connect->query($sqldeals);

						if($dealsResult->num_rows>0){
							while($row=$dealsResult->fetch_assoc()){
								echo "<tr>";
								echo '<td>'.$row['id'].'</td>';
								echo '<td>'.$row['name'].'</td>';
								echo '<td>'.$row['product_name'].'</td>';
								echo '<td>'.$row['product_profit'].'</td>';
								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No deals so far</td></tr>";
						}
						
						?>
					</tbody>
			</table>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	



				<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-user"></i> New Customers</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>#</th>
							<th>Client Name</th>
							<th style="width:15%;">Deals</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqldeals="SELECT * FROM customers WHERE dealerid='$userId' ORDER BY id DESC LIMIT 5 ";
						$dealsResult=$connect->query($sqldeals);

						if($dealsResult->num_rows>0){
							while($row=$dealsResult->fetch_assoc()){

								$customer_id=$row['id'];
								$sqldealspercustomer="SELECT * FROM deals WHERE customer_id='$customer_id' AND status=1";
								$query=$connect->query($sqldealspercustomer);
								$numberofdeals=$query->num_rows;

								echo "<tr>";
								echo '<td>'.$row['id'].'</td>';
								echo '<td>'.$row['name'].'</td>';
								echo '<td>'.$numberofdeals.'</td>';
								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No customers so far</td></tr>";
						}
						
						?>
					</tbody>
			</table>


			</div> <!-- /panel-body -->
		</div> <!-- /panel -->




			<!--calender not necessary
		<div class="panel panel-default">
			<div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Calendar</div>
			<div class="panel-body">
				<div id="calendar"></div>
			</div>	
		</div>
		-->
		
	</div>

	
</div> <!--/row-->

<?php 
if ($shop_type==4 || $shop_type==1 ){  echo "<!--";  }
?>





 <div class="row"style="margin-top: 30px;margin-bottom: 40px;">
        <div class="row">
            <div class="col-md-9">
                <h3>
                    Latest Products</h3>
            </div>
            <div class="col-md-3">
             
                
                <div class="controls pull-right">
                <a href="products.php" style="margin-right:30px;font-size:15px;">View all products</a>
                    <a class="left fa fa-chevron-left btn btn-success" href="#carousel-example"
                        data-slide="prev"></a><a class="right fa fa-chevron-right btn btn-success" href="#carousel-example"
                            data-slide="next"></a>
                </div>
            </div>
        </div>
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
           
            <div class="carousel-inner">
                <div class="item active">
                    <div class="row">


                    	<?php 
						$sqlproducts='SELECT * FROM products WHERE status="1" AND (approval="2" OR (approval="1" AND store_id='.$userId.')) ORDER BY id DESC LIMIT 4';
						$productsResult=$connect->query($sqlproducts);

						



						if($productsResult->num_rows>0){
							while($row=$productsResult->fetch_assoc()){
								
								
								$imageUrl = str_replace('../', '', $row['image']);;
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:260px; width:260px;'  />";

								echo ' <div class="col-sm-3">
                            <div class="col-item">
                                <div class="photo">
                                    <a href="product.php?id='.$row['id'].'">'.$productImage.'</a>
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-12">
                                            <h5>
                                                '.$row['name'].'</h5>
                                            <h5 class="price-text-color">
                                                KSh. '.number_format($row['price']).'</h5>
                                                <h5 class="price-text-color" style="color:green;">
                                                KSh. '.number_format($row['profit']).'</h5>
                                        </div>
                                       
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="orders.php?o=add&id='.$row['id'].'" >Sell Now</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="product.php?id='.$row['id'].'" >View Product</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>';
															}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No products so far</td></tr>";
						}
						?>



                    </div>
                </div>
                <div class="item">
                    <div class="row">

                       <?php 
						$sqlproducts='SELECT * FROM products WHERE status="1" AND (approval="2" OR (approval="1" AND store_id='.$userId.')) ORDER BY id DESC LIMIT 4 OFFSET 4';
						$productsResult=$connect->query($sqlproducts);

						



						if($productsResult->num_rows>0){
							while($row=$productsResult->fetch_assoc()){
								
								
								$imageUrl = str_replace('../', '', $row['image']);;
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:260px; width:260px;'  />";

								echo ' <div class="col-sm-3">
                            <div class="col-item">
                                <div class="photo">
                                    <a href="product.php?id='.$row['id'].'" >'.$productImage.'</a>
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-12">
                                            <h5>
                                                '.$row['name'].'</h5>
                                            <h5 class="price-text-color">
                                                KSh.'.number_format($row['price']).'</h5>
                                                <h5 class="price-text-color" style="color:green;">
                                                KSh.'.number_format($row['profit']).'</h5>
                                        </div>
                                       
                                    </div>
                                    <div class="separator clear-left">
                                         <p class="btn-add">
                                            <i class="fa fa-shopping-cart"></i><a href="orders.php?o=add&id='.$row['id'].'" >Sell Now</a></p>
                                        <p class="btn-details">
                                            <i class="fa fa-list"></i><a href="product.php?id='.$row['id'].'" >View Product</a></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                        </div>';
															}
						}
						?>
                    </div>
                </div>
            </div>
        </div>
 

</div>

<?php 
if ($shop_type==4 || $shop_type==1 ){  echo "-->";  }
?>


<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');

    });

    window.mobilecheck = function() {
  var check = false;
var ua = navigator.userAgent.toLowerCase();
var isAndroid = ua.indexOf("android") > -1; 
  return isAndroid;
};
if(!window.mobilecheck()){
	$('#AndroidApp').html('');
}else{
	//temporarily disabling android app till when needed in the future due to inability to maintain app and website
	//$('#AndroidApp').html('<div class="panel panel-default"><div class="panel-heading"><div class="page-heading"> <i class="glyphicon glyphicon-envelope"></i> Use Mobile App. If the app does not work on your phone then you can always use this website instead to access your account</div></div><div class="panel-body">Download the Javy Promote App on the Google Playstore <a href="https://play.google.com/store/apps/details?id=javytechnologies.javypromoter"><button type="button" class="btn btn-primary">Download</button></a></div></div>'); 
}

</script>

<?php require_once 'includes/footer.php'; ?>


