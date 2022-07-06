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


$sqldeals="SELECT * FROM deals WHERE supplier_id='$userId'";
$dealsResult=$connect->query($sqldeals);
$countDeals=$dealsResult->num_rows;

$sqlPendingOrders="SELECT * FROM deals WHERE supplier_id='$userId' AND status=0";
$pendingOrdersResult=$connect->query($sqlPendingOrders);
$countPendingOrders=$pendingOrdersResult->num_rows;



$sqlCompleteDeals="SELECT * FROM deals WHERE supplier_id='$userId' AND status=1";
$completeDealsResult=$connect->query($sqlCompleteDeals);
$countCompleteDeals=$completeDealsResult->num_rows;



//not needed
$sqlRevenue= "SELECT product_price FROM deals WHERE status=1 AND supplier_id=$userId";
$result=$connect->query($sqlRevenue);
$totalRevenue=0;
while($row=$result->fetch_assoc()){
	$totalRevenue += $row['product_price'];
}
//not needed


$sqlwebvisits="SELECT web_visits FROM suppliers WHERE id='$userId'";
$result=$connect->query($sqlwebvisits);
while($row=$result->fetch_assoc()){
	$web_visits=$row['web_visits'];
}

$sqlpayments="SELECT amount FROM supplier_payments WHERE supplier_id='$userId' AND (status=0 OR status=1)";
$result=$connect->query($sqlpayments);
$totalPayments=0;
while($row=$result->fetch_assoc()){
	$totalPayments +=$row['amount'];
}

$sqlpendingpayments="SELECT amount FROM supplier_payments WHERE supplier_id='$userId' AND status=0 ";
$result=$connect->query($sqlpendingpayments);
$totalPendingPayments=0;
while($row=$result->fetch_assoc()){
	$totalPendingPayments +=$row['amount'];
}


$sqlProducts="SELECT * FROM products WHERE supplier_id='$userId'";
$result=$connect->query($sqlProducts);
$numberofproducts=$result->num_rows;

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



<?php

if($authorization_status==1) {
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

			If you haven't received the email on your inbox, check and make sure the message has not been filtered as spam. 

			</div> 
		</div> 	

		<?php
if($authorization_status==1) {
echo "-->";
}else{
	
}
?>




<div class="row">
	
	<div class="col-md-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Total Orders
					<span class="badge pull pull-right"><?php echo $countDeals; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

		<div class="col-md-4">
			<div class="panel panel-success">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Complete Orders
					<span class="badge pull pull-right"><?php echo $countCompleteDeals; ?></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<a href="products.php" style="text-decoration:none;color:black;">
					Products
					<span class="badge pull pull-right"><?php echo $numberofproducts; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-4">



		<?php 
		if($registered_on!=0){
			//get the store on which the supplier registered
			$sqlstorereg ="SELECT * FROM users WHERE user_id = '$registered_on'";
$storeResult=$connect->query($sqlstorereg);
$storeResult=$storeResult->fetch_assoc();
$storename=$storeResult['storename'];

			echo '<div class="card">
		<a href="'.'https://'.$storename.$website_ke.'" target="_blank">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h2>'.'Registered on'.'</h2>
		  </div></a> 

		  <div class="cardContainer">
		    <p>https://www.'.$storename.$website_ke.'</p>
		 
		  </div>
		</div>
		<br/>';

		}

		

		?>



		<div class="card">
		<a href="<?php echo "https://".$username.$website_ke; ?>" target="_blank">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h2><?php echo "View your Website"; ?></h2>
		  </div></a> 

		  <div class="cardContainer">
		    <p><?php echo "Copy link:  https://www.".$username.$website_ke; ?></p>
		 
		  </div>
		</div>
		<br/>

		<div class="card">
	
		  <div class="cardHeader" style="background-color:#FF0000;">
		    <h2><?php echo number_format($web_visits); ?></h2>
		  </div> 

		  <div class="cardContainer">
		    <p><?php echo "Website Visits"; ?></p>
		 
		  </div>
		</div>
		<br/>
	
		


			<div class="card">
		  <div class="cardHeader" style="background-color:#F27800;">
		    <h1><?php if($totalPayments) {
		    	echo number_format($totalPayments);
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-usd"></i> Total Payments to date</p>
		  </div>
		</div> 

		<br/>

		<div class="card">
		  <div class="cardHeader" >
		    <h1><?php if($totalPendingPayments) {
		    	echo number_format($totalPendingPayments);
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-usd"></i> Pending Payments</p>
		  </div>
		</div>

	</div>




	<div class="col-md-8">

	<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-shopping-cart"></i> Recent Orders</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>#</th>
							<th>Product</th>
							<th>Customer Price</th>
							<th style="width:15%;">Date</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqldeals="SELECT * FROM deals WHERE supplier_id='$userId' OR dealer_id IN (SELECT user_id FROM users WHERE supplier_registered_on='$userId') ORDER BY id DESC LIMIT 5 ";
						$dealsResult=$connect->query($sqldeals);

						if($dealsResult->num_rows>0){
							while($row=$dealsResult->fetch_assoc()){
								echo "<tr>";
								echo '<td>'.$row['id'].'</td>';
								echo '<td>'.$row['product_name'].'</td>';
								echo '<td>'.number_format($row['product_price']).'</td>';
								echo '<td>'.date('d/m/Y \a\t h:iA', $row['dealDate']).'</td>';
								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No orders from Javy so far</td></tr>";
						}
						
						?>
					</tbody>
			</table>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	




		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-ruble"></i> Recent Products</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<table class="table">
					<thead>
						<tr>							
							<th>Photo</th>
							<th>Product Name</th>
							<th>Product Price</th>
							<th style="width:15%;">Profit</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqlproducts="SELECT * FROM products WHERE supplier_id='$userId' ORDER BY id DESC LIMIT 10 ";
						$productsResult=$connect->query($sqlproducts);

						



						if($productsResult->num_rows>0){
							while($row=$productsResult->fetch_assoc()){
								
								$imageUrl = substr($row['image'], 3);
	$imageUrl=str_replace("..", "https://promote.javy.co.ke/", $row['image']);

	$noImageUploaded='https://promote.javy.co.ke/assests/images/product-images/no-image-uploaded.jpg';

	if($imageUrl==''){
		$imageUrl=$noImageUploaded;
	}
								
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:50px; width:50px;'  />";

								echo "<tr>";
								echo "";
								echo '<td>'.$productImage.'</a></td>';
								echo '<td>'.$row['name'].'</a></td>';
								echo '<td>'.$row['price'].'</td>';
								echo '<td>'.$row['profit'].'</td>';
								
								echo "</tr>";
															}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No products so far</td></tr>";
						}
						?>
					</tbody>
			</table>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	

		<br/>
			<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-th-list"></i> Current Running Promotions</div>
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
	$image_url=str_replace("assests","https://promote.javy.co.ke/assests", $row['original_image']);
	$product_id=$row['product_id'];

	$sqlproduct="SELECT name,image,price,profit FROM products WHERE id='$product_id'";
	$result2=$connect->query($sqlproduct);
	while($row=$result2->fetch_assoc()){
		$supplier_id=$row['supplier_id'];


    if($userId==$supplier_id){

        $more_than_one_offer=true;

	if($count==0){
	echo '<div class="item active">';
}else{
	echo '<div class="item">';
}
      echo '<a href="promotions.php#offer'.$offer_id.'"><img style="width:100%;" src="'.$image_url.'" alt="'.$title.'" ></a>
    </div>
';

}
}


$count=1;

}

 if($more_than_one_offer==false){
    echo "<h3 style='text-align:center; margin:30px;'>No promotions running at the moment.</h3>";
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

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');

      //Date for the calendar events (dummy data)
      var date = new Date();
      var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

      $('#calendar').fullCalendar({
        header: {
          left: '',
          center: 'title'
        },
        buttonText: {
          today: 'today',
          month: 'month'          
        }        
      });


    });
</script>

<?php require_once 'includes/footer.php'; ?>