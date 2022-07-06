<?php require_once 'includes/header.php'; 

date_default_timezone_set("Africa/Nairobi");

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


$sqlearnings= "SELECT product_profit FROM deals WHERE status=1 AND dealer_id=$userId";
$result=$connect->query($sqlearnings);
$totalRevenue=0;
while($row=$result->fetch_assoc()){
	$totalRevenue += $row['product_profit'];
}

$sqlwithdrawals="SELECT amount FROM withdrawals WHERE user_id='$userId' AND (status=0 OR status=1)";
$result=$connect->query($sqlwithdrawals);
$totalWithdrawals=0;
while($row=$result->fetch_assoc()){
	$totalWithdrawals +=$row['amount'];
}

$totalEarningsToDate=$totalRevenue;
$totalEarningsAvailable=$totalRevenue-$totalWithdrawals;



?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Earnings</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Withdraw your earnings / View withdrawals</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<div class="col-md-6" style="margin-top: 10px;">
			<div class="card">
		  <div class="cardHeader" style="background-color:#F27800;">
		    <h1><?php 
		    	echo "KSh. ".number_format($totalEarningsToDate);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Total Earnings to date</p>
		  </div>
		  </div>
		  </div>

		  <div class="col-md-6" style="margin-top: 10px;">
		  <div class="card" style="margin-bottom: 20px;">
		  <div class="cardHeader" id="EarningsToDateCardHeader" >
		    <h1><?php 
		    	echo "KSh. ".number_format($totalEarningsAvailable);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Current Earnings</p>
		  </div>
		  </div>

		  <div style="padding-bottom:20px;" >
					<button style="width: 100%;" class="btn btn-default button1" data-toggle="modal" data-target="#addBrandModal"> <i class="glyphicon glyphicon-usd"></i> Withdraw Cash </button>
				</div> <!-- /div-action -->	

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
	td:nth-of-type(2):before { content: "withdrawal Amount: "; }
	td:nth-of-type(3):before { content: "Payment Method: "; }
	td:nth-of-type(4):before { content: "Status: "; }
	
}
			</style>				
			
			<div id="tableHolder">


			<table class="table" id="manageBrandTable2">
					<thead>
					<caption style="text-align: center; font-size: 20px;color: #000000;">WITHDRAWALS</caption>
						<tr>							
							<th>Date and Time</th>
							<th>Withdrawal Amount</th>
							<th>Payment Method</th>
							<th style="width:15%;">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$sqlwithdrawals="SELECT * FROM withdrawals WHERE user_id='$userId' ORDER BY Withdrawal_id DESC";
						$withdrawalsResult=$connect->query($sqlwithdrawals);

						if($withdrawalsResult->num_rows>0){
							while($row=$withdrawalsResult->fetch_assoc()){
								echo "<tr>";
								echo '<td>'.date('d/m/Y \a\t h:iA' , $row['date']).'</td>';
								echo '<td>'.$row['amount'].'</td>';
								echo '<td>'.$row['method'].'</td>';

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
							echo "<tr><td colspan='4' style='text-align: center;'>No withdrawals so far</td></tr>";
						}
						
						$connect->close();
						?>
					</tbody>
			</table>
			</div>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="submitBrandForm" action="php_action/createWithdrawal.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-usd"></i> Withdraw Cash</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-brand-messages"></div>

	        <div class="form-group">
	        	<label for="brandName" class="col-sm-4 control-label">Withdraw Earnings</label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="text" style="font-weight: bold;" readonly="readonly" class="form-control" id="brandName" placeholder="Brand Name" name="brandName" autocomplete="off" value="<?php 
		    	echo "KSh. ".$totalEarningsAvailable ; ?>">
		    		<input type="hidden"  name="revenue" id="revenue" value="<?php echo $totalEarningsAvailable; ?>">
				    </div>
	        </div> <!-- /form-group-->	         	        
	        <div class="form-group">
	        	<label for="brandStatus" class="col-sm-4 control-label">Payment Method</label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <select class="form-control" id="brandStatus" name="brandStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="Cash">Cash</option>
				      	<option value="Mpesa">Mpesa</option>
				      	<option value="Airtel Money">Airtel Money</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
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

<script src="custom/js/earnings-2.js"></script>

<?php require_once 'includes/footer.php'; ?>