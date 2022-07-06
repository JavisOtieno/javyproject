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



$sqlcompletepayments="SELECT amount FROM supplier_payments WHERE supplier_id='$userId' AND status=1";
$result=$connect->query($sqlcompletepayments);
$totalCompletePayments=0;
while($row=$result->fetch_assoc()){
	$totalProductPayments +=$row['amount'];
}

$sqlpayments="SELECT * FROM withdrawals WHERE user_id IN (SELECT user_id FROM users WHERE supplier_registered_on=$userId) AND status=1 ORDER BY withdrawal_id DESC";
$result=$connect->query($sqlpayments);
$totalPayments=0;
while($row=$result->fetch_assoc()){
	$totalPaymentsToPromoters +=$row['amount'];
}





?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Payments</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Payments </div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<div class="col-md-6" style="margin-top: 10px;">
			<div class="card">
		  <div class="cardHeader" style="background-color:#F27800;">
		    <h1><?php 
		    	echo "KSh. ".number_format($totalProductPayments);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p> Complete Product Payments</p>
		  </div>
		  </div>
		  </div>

		  <div class="col-md-6" style="margin-top: 10px;">
		  <div class="card" style="margin-bottom: 20px;">
		  <div class="cardHeader" id="EarningsToDateCardHeader" >
		    <h1><?php 
		    	echo "KSh. ".number_format($totalPaymentsToPromoters);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Complete Payments to Promoters</p>
		  </div>
		  </div>

		 

		  </div>

		

			

				<div class="remove-messages"></div>


			<style type="text/css">

				@media 
only screen and (max-width: 414px),(max-device-width: 414px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	td:nth-of-type(1):before { content: "Date and Time: "; }
	td:nth-of-type(2):before { content: "Order id: "; }
	td:nth-of-type(3):before { content: "Withdrawal Amount: "; }
	td:nth-of-type(4):before { content: "Product name: "; }
	td:nth-of-type(5):before { content: "Status: "; }
	
}
			</style>				
			
			<div id="tableHolder">


			<table class="table" id="manageBrandTable2">
					<thead>
					<caption style="text-align: center; font-size: 20px;color: #000000;">PRODUCT PAYMENTS</caption>
						<tr>							
							<th>Date and Time</th>
							<th>Order id</th>
							<th>Payment Amount</th>
							<th>Product Name</th>
							<th style="width:15%;">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqlwithdrawals="SELECT * FROM supplier_payments WHERE supplier_id='$userId' ORDER BY payment_id DESC";
						$withdrawalsResult=$connect->query($sqlwithdrawals);

						if($withdrawalsResult->num_rows>0){
							while($row=$withdrawalsResult->fetch_assoc()){
								echo "<tr>";
								echo '<td>'.date('d/m/Y \a\t h:iA', $row["date"]).'</td>';
								echo '<td>'.$row['order_id'].'</td>';

								echo '<td>'.number_format($row['amount']).'</td>';

								$order_id=$row['order_id'];


								$sql_order="SELECT * FROM deals WHERE id='$order_id'";
								$order_result=$connect->query($sql_order);
								while($row_order=$order_result->fetch_assoc()){
									echo '<td>'.$row_order['product_name'].'</td>';
								}


								if($row['status'] == 1) {
								 		// activate member
								 		$withdrawalStatus = "<label class='label label-success'>Completed</label>";
								 	} else if($row['status'] == 0) {
								 		// deactivate member
								 		$withdrawalStatus = "<label class='label label-warning'>Processing ...</label>";
								 	}else{
								 		$withdrawalStatus = "<label class='label label-danger'>Cancelled</label>";
								 	}

								echo '<td>'.$withdrawalStatus.'</td>';

								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No payments so far</td></tr>";
						}
						
						//$connect->close();
						?>
					</tbody>
			</table>

						<table class="table" id="manageBrandTable2">
					<thead>
					<caption style="text-align: center; font-size: 20px;color: #000000;">PAYMENTS TO PROMOTERS</caption>
						<tr>							
							<th>Date and Time</th>
							<th>Promoter</th>
							<th>Amount</th>
							<th style="width:15%;">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqlwithdrawals="SELECT * FROM withdrawals WHERE user_id IN (SELECT user_id FROM users WHERE supplier_registered_on=$userId) ORDER BY withdrawal_id DESC";
						//echo $sqlwithdrawals;
						$withdrawalsResult=$connect->query($sqlwithdrawals);

						if($withdrawalsResult->num_rows>0){
							while($row=$withdrawalsResult->fetch_assoc()){
								echo "<tr>";
								echo '<td>'.date('d/m/Y \a\t h:iA', $row["date"]).'</td>';

								$user_id=$row['user_id'];
								$sqlusers="SELECT * FROM users WHERE user_id=$user_id";
								$userResult=$connect->query($sqlusers);

								if($row2=$userResult->fetch_assoc()){
									$storename=$row2['storename'];
									$name=ucfirst($row2['firstname']).' '.ucfirst($row2['lastname']);
								}

								echo '<td>www.'.$storename.'.av.ke - '.$name.'</td>';

								echo '<td>'.number_format($row['amount']).'</td>';


								if($row['status'] == 1) {
								 		// activate member
								 		$withdrawalStatus = "<label class='label label-success'>Completed</label>";
								 	} else if($row['status'] == 0) {
								 		// deactivate member
								 		$withdrawalStatus = "<label class='label label-warning'>Processing ...</label>";
								 	}else{
								 		$withdrawalStatus = "<label class='label label-danger'>Cancelled</label>";
								 	}

								echo '<td>'.$withdrawalStatus.'</td>';

								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No payments so far</td></tr>";
						}
						
						$connect->close();
						?>
					</tbody>
			</table
			</div>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- edit brand -->
<div class="modal fade" id="editBrandModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="editBrandForm" action="php_action/editBrand.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Brand</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-brand-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>

		      <div class="edit-brand-result">
		      	<div class="form-group">
		        	<label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editBrandName" placeholder="Brand Name" name="editBrandName" autocomplete="off">
					    </div>
		        </div> <!-- /form-group-->	         	        
		        <div class="form-group">
		        	<label for="editBrandStatus" class="col-sm-3 control-label">Status: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <select class="form-control" id="editBrandStatus" name="editBrandStatus">
					      	<option value="">~~SELECT~~</option>
					      	<option value="1">Available</option>
					      	<option value="2">Not Available</option>
					      </select>
					    </div>
		        </div> <!-- /form-group-->	
		      </div>         	        
		      <!-- /edit brand result -->

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer editBrandFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-success" id="editBrandBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->
<!-- /edit brand -->

<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Brand</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeBrandBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->

<script src="custom/js/brand.js"></script>

<?php require_once 'includes/footer.php'; ?>