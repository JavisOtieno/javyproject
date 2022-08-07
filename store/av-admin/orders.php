<?php 
require_once 'php_action/db_connect.php'; 
require_once 'includes/header.php'; 

if($_GET['o'] == 'add') { 
// add order
	echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manord') { 
	echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['o'] == 'editOrd') { 
	echo "<div class='div-request div-hide'>editOrd</div>";
} // /else manage order

//set timezone
date_default_timezone_set("Africa/Nairobi");

?>

<ol class="breadcrumb">
  <li><a href="dashboard.php">Home</a></li>
  <li>Orders</li>
  <li class="active">
  	<?php if($_GET['o'] == 'add') { ?>
  		Add Order
		<?php } else if($_GET['o'] == 'manord') { ?>
			Manage Orders
		<?php } // /else manage order ?>
  </li>
</ol>





<div class="panel panel-default">
	<div class="panel-heading">

		<?php if($_GET['o'] == 'add') { ?>
  		<i class="glyphicon glyphicon-plus-sign"></i>	Add New Order
		<?php } else if($_GET['o'] == 'manord') { ?>
			<i class="glyphicon glyphicon-edit"></i> Manage Orders
		<?php } else if($_GET['o'] == 'editOrd') { ?>
			<i class="glyphicon glyphicon-edit"></i> Order
		<?php } ?>

	</div> <!--/panel-->	
	<div class="panel-body">
			
		<?php if($_GET['o'] == 'add') { 
			// add order
			?>			

			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/createOrder.php" id="createOrderForm">

  		<!--NO NEED FOR DATE
			  <div class="form-group">
			    <label for="orderDate" class="col-sm-2 control-label">Order Date</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="orderDate" name="orderDate" autocomplete="off" />
			    </div>
			  </div>--> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientName" class="col-sm-3 control-label">Customer Name</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Customer Name" autocomplete="off" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Customer Phone Number</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Customer Number" autocomplete="off" />
			    </div>
			  </div> <!--/form-group-->		
			    <div class="form-group">
			    <label for="clientEmail" class="col-sm-3 control-label">Customer Email</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientEmail" name="clientEmail" placeholder="Customer Email(optional)" autocomplete="off" />
			    </div>
			  </div> <!--/form-group-->	

			  <div class="form-group">
			    <label for="clientDeliveryDetails" class="col-sm-3 control-label">Delivery Details</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientDeliveryDetails" name="clientDeliveryDetails" placeholder="Delivery Details(optional)" autocomplete="off" />
			    </div>
			  </div> 

			  	<div class="form-group">

			  	<label for="productName" class="col-sm-3 control-label">Product Name</label>
			  	<div class="col-sm-9">
			  					<select class="form-control" name="productName" id="productName" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM products WHERE status = 1 ";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {		

			  							if($_GET['id']){
			  								if($_GET['id']==$row['id']){
			  								$selected='selected';
			  							}else{
			  								$selected='';
			  							}
			  							}	

			  								echo "<option value='".$row['id']."' ".$selected." id='changeProduct".$row['id']."'>".$row['name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
		  						</div>
			  					</div>

			  <!-- 
			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Product</th>
			  			<th style="width:20%;">Rate</th>
			  			<th style="width:15%;">Quantity</th>			  			
			  			<th style="width:15%;">Total</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>-->
			  	<?php
			  		/*
			  		$arrayNumber = 0;
			  		for($x = 1; $x < 4; $x++) { ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."'>".$row['product_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />			  					
			  					<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label">VAT 13%</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="vat" disabled="true" />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true"/>
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Discount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
				    </div>
				  </div> <!--/form-group-->			  		  
			  </div> <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Due Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
				    </div>
				  </div> <!--/form-group-->		
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentType" id="paymentType">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Cheque</option>
				      	<option value="2">Cash</option>
				      	<option value="3">Credit Card</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentStatus" id="paymentStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Full Payment</option>
				      	<option value="2">Advance Payment</option>
				      	<option value="3">No Payment</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
			  </div> <!--/col-md-6-->

			  -->

			 

			    
			  <div class="form-group submitButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>

			     //commenting out everything irrelevant
			*/ 

			    ?>

			    
			    <div class="col-sm-offset-3">
			      <button type="submit" id="createOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Order</button>

			      <button type="reset" class="btn btn-default" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i> Reset</button>
			      </div>
			    </div>
			  </div>
			</form>

			

		<?php } else if($_GET['o'] == 'manord') { 

			
						$sqldeals="SELECT * FROM deals WHERE dealer_id='$userId' ORDER BY id DESC";
						$dealsResult=$connect->query($sqldeals);

						$numberofDeals=$dealsResult->num_rows;

						$sqlSuccesfulDeals="SELECT * FROM deals WHERE dealer_id='$userId' AND status='1'";
						$succesfulDealsResult=$connect->query($sqlSuccesfulDeals);
						$numberOfSuccesfulDeals=$succesfulDealsResult->num_rows;


						
			// manage order
			?>

			<div id="success-messages"></div>
			
			<!--<table class="table" id="manageOrderTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Deal Date</th>
						<th>Client Name</th>
						<th>Product Name</th>
						<th>Profit</th>
						<th>Status</th>
						<th>Options</th>
					</tr>
				</thead>
			</table>-->

			<div class="col-md-6" style="margin-top: 10px;" >
			<div class="card">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php 
		    	echo number_format($numberofDeals);
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Total Orders</p>
		  </div>
		  </div>
		   <!--<div style="margin-top:20px;padding-bottom:20px;" >
					<a href="messages.php"><button style="width: 100%;" class="btn btn-default button1"> <i class="glyphicon glyphicon-cart"></i> View Messages </button></a>
				</div>  /div-action -->	
		  </div>	

					<div class="col-md-6" style="margin-top: 10px;">
			<div class="card">
		  <div class="cardHeader" >
		    <h1><?php 
		    	echo $numberOfSuccesfulDeals;
		    	 ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p>Succesful Orders</p>
		  </div>
		  </div>
		   <!--<div style="margin-top:20px;padding-bottom:20px;" >
					<a href="orders.php?o=add"><button style="width: 100%;" class="btn btn-default button1"> <i class="glyphicon glyphicon-cart"></i> Add New Order </button></a>
				</div>  -->	
		  </div>



		  

		  <style type="text/css">

				@media 
only screen and (max-width: 550px),(max-device-width: 550px)  {

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
	td:nth-of-type(1):before { content: "#  : "; }
	td:nth-of-type(2):before { content: "Deal Date: "; }
	td:nth-of-type(3):before { content: "Client Name: "; }
	td:nth-of-type(4):before { content: "Product Name: "; }
	td:nth-of-type(5):before { content: "Profit: "; }
	td:nth-of-type(6):before { content: "Status: "; }
	td:nth-of-type(7):before { content: "Options: "; }
	
}
			</style>	

<div id="tableHolder">


			<table class="table" id="manageBrandTable2">
					<thead>

					<caption style="text-align: center; font-size: 20px;color: #000000;margin-top: 20px;">ORDERS</caption>
						<tr>
						<th>#</th>
						<th>Order Date</th>
						<th>Customer Name</th>
						<th>Product Name</th>
						<th>Profit</th>
						<th>Status</th>
						<th>Options</th>
						<th>Actions</th>
							
						</tr>
					</thead>
					<tbody>
						
						<?php

						if($dealsResult->num_rows>0){
							while($row=$dealsResult->fetch_assoc()){
								echo "<tr>";
								$deal_id=$row['id'];
								echo '<td>'.$deal_id.'</td>';
								echo '<td>'.date('d/m/Y \a\t h:iA' , $row['dealDate']).'</td>';
								echo '<td>'.$row['name'].'</td>';
								echo '<td>'.$row['product_name'].'</td>';
								echo '<td>'.$row['product_profit'].'</td>';


								if($row['status'] == 1) {
								 		// activate member
								 		$dealStatus = "<label class='label label-success'>Completed</label>";
								 	} else if($row['status'] == 0) {
								 		// deactivate member
								 		$dealStatus = "<label class='label label-warning'>Processing ...</label>";
								 	}else{
								 		$dealStatus = "<label class='label label-danger'>Cancelled</label>";
								 	}




								echo '<td>'.$dealStatus.'</td>';
								
								

								if($row['order_by_dealer'] == 0) {
								 		// order ena
								 		$edit_button_text='<i class="glyphicon glyphicon-eye-open"></i> View';
								 	} else{
								 		

								 	if($row['status'] == 0) {
								 		// deactivate member
								 		$edit_button_text='<i class="glyphicon glyphicon-edit"></i> Edit';
								 	}else{

								 		$edit_button_text='<i class="glyphicon glyphicon-eye-open"></i> View';
								 	}

								 	}


								$button = '<!-- Single button -->

								<div class="btn-group">

								<a href="orders.php?o=editOrd&i='.$deal_id.'" id="editOrderModalBtn"><button type="button" class="btn btn-default " 
								  aria-haspopup="true" > '.$edit_button_text.'</button></a>
								  <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    Action <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu">
								    <li><a href="orders.php?o=editOrd&i='.$deal_id.'" id="editOrderModalBtn"> '.$edit_button_text.'</a></li>
								    
								    <!--<li><a type="button" data-toggle="modal" id="paymentOrderModalBtn" data-target="#paymentOrderModal" onclick="paymentOrder('.$deal_id.')"> <i class="glyphicon glyphicon-save"></i> Payment</a></li>

								    <li><a type="button" onclick="printOrder('.$deal_id.')"> <i class="glyphicon glyphicon-print"></i> Print </a></li>
								    
								    <li><a type="button" data-toggle="modal" data-target="#removeOrderModal" id="removeOrderModalBtn" onclick="removeOrder('.$deal_id.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>  -->     
								  </ul>
								</div>';

								echo '<td>'.$button.'</td>';
								if($row['status']==0){
									echo '<td><a href="php_action/cancel-order.php?orderId='.$deal_id.'"><button type="button" class="btn btn-danger">Cancel</button></a></td>';
								}else if($row['status']==1){
									echo '<td><a href="view-invoice.php?id='.$deal_id.'"><button type="button" class="btn btn-success">View Invoice</button></a></td>';
								}else{
									echo ' ';
								}
								
							

								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='4' style='text-align: center;'>No orders so far</td></tr>";
						}
						
						$connect->close();
						?>
					</tbody>
			</table>
			</div>



		<?php 
		// /else manage order
		} else if($_GET['o'] == 'editOrd') {
			// get order
			?>
		
			<div class="success-messages"></div> <!--/success-messages-->

			  			<?php $orderId = $_GET['i'];

  		


					$sql2 = "SELECT * FROM deals	
					WHERE id = {$orderId}";

				$result = $connect->query($sql2);
				$data = $result->fetch_row();				

			//making form read only for ordered by client and processed deal

			if($data[14] == 0) {
			 		$readonly_text='readonly';
			 	} else{
			 		
			 	if($data[16] == 0) {
			 		$readonly_text='';
			 	}else{

			 		$readonly_text='readonly';
			 	}

			 	}


			 	//getting the product name
			 	$productSql = "SELECT * FROM products WHERE status = 1 ";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {	

			  							if($data[10]==$row['id'])	{
			  								$selected="selected='selected'";
			  							}
			  							else{
			  								$selected="";
			  							}						 		
			  							$ordered_product_name=$row['name'];
			  							$ordered_product_id=$row['id'];
										 	} // /while 

			?>

  		<form class="form-horizontal" method="POST" action="php_action/editOrder.php" id="editOrderForm">



  			  <div class="form-group">
			    <label for="clientName" class="col-sm-3 control-label">Customer Name</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Customer Name" autocomplete="off" value="<?php echo $data[1] ?>" <?php echo $readonly_text ?> />
			    </div>

			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Customer Phone Number</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Customer Phone Number" autocomplete="off" value="<?php echo $data[2] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div> <!--/form-group-->		
			    <div class="form-group">
			    <label for="clientEmail" class="col-sm-3 control-label">Customer Email</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientEmail" name="clientEmail" placeholder="Customer Email(optional)" autocomplete="off" value="<?php echo $data[3] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div> <!--/form-group-->	

			  <div class="form-group">
			    <label for="clientDeliveryDetails" class="col-sm-3 control-label">Delivery Details</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientDeliveryDetails" name="clientDeliveryDetails" placeholder="Delivery Details(optional)" autocomplete="off" value="<?php echo $data[4] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div> 

			  	<div class="form-group">

			  	<label for="productName" class="col-sm-3 control-label">Product Name</label>
			  	<div class="col-sm-9">
			  		<input type="text" class="form-control" id="productNameDisplayed" name="productNameDisplayed" placeholder="Product Name" autocomplete="off" value="<?php echo $ordered_product_name ?>" <?php echo $readonly_text ?> readonly />
			  		<input type="text" id="productName" name="productName" placeholder="Product Name" autocomplete="off" value="<?php echo $ordered_product_id ?>" hidden />
			  					<!--<select class="form-control" name="productName" id="productName" <?php //echo $readonly_text ?> onchange="getPriceAndProfit()" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
						 		
			  								//echo "<option value='".$ordered_product_id."' id='changeProduct".$ordered_product_id."'  ".$selected.">".$ordered_product_id."</option>";
										 	 

			  						?>
		  						</select>-->
		  						</div>
			  					</div>


			  	  <div class="form-group">
			    <label for="productPrice" class="col-sm-3 control-label">Product Price</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="productPrice" name="productPrice" placeholder="Product Price" autocomplete="off" value="<?php echo $data[7] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div>

			   <div class="form-group">
			    <label for="productProfit" class="col-sm-3 control-label">Product Profit</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="productProfit" name="productProfit" placeholder="Product Profit" autocomplete="off" value="<?php echo $data[8] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div>


			  	<div class="form-group">
			    <label for="clientDeliveryDetails" class="col-sm-3 control-label">Status</label>
			    <div class="col-sm-9">
			      					<?php if($data[16] == 1) {
								 		echo "<label class='label label-success'>Completed</label>";
								 	} else if($data[16] == 0) {
								 		echo "<label class='label label-warning'>Processing ...</label>";
								 	}else{
								 		echo "<label class='label label-danger'>Cancelled</label>";
								 	}
					?>			 	
			    </div>
			  </div> 				

			  					<div class="form-group">
			    <label for="orderNotes" class="col-sm-3 control-label">Order Notes</label>
			    <div class="col-sm-9">
			      <textarea readonly type="text" class="form-control" id="orderNotes" name="orderNotes" placeholder="<?php echo $data[5] ?>" autocomplete="off" value="<?php echo $data[5] ?>" ></textarea>
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="Date" class="col-sm-3 control-label">Date</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="date" name="date" placeholder="Date" autocomplete="off" value="<?php echo date('d/m/Y \a\t h:iA' , $data[15]); ?>" readonly/>
			    </div>
			  </div>  

<!--
			  <div class="form-group">
			    <label for="orderDate" class="col-sm-2 control-label">Order Date</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="orderDate" name="orderDate" autocomplete="off" value="<?php
			      /* echo $data[1] ?>" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">Client Name</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" value="<?php echo $data[1] ?>" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Contact Number" autocomplete="off" value="<?php echo $data[2] ?>" />
			    </div>
			  </div> <!--/form-group-->			  

			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Product</th>
			  			<th style="width:20%;">Rate</th>
			  			<th style="width:15%;">Quantity</th>			  			
			  			<th style="width:15%;">Total</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php

			  		$orderItemSql = "SELECT order_item.order_item_id, order_item.order_id, order_item.product_id, order_item.quantity, order_item.rate, order_item.total FROM order_item WHERE order_item.order_id = {$orderId}";
						$orderItemResult = $connect->query($orderItemSql);
						// $orderItemData = $orderItemResult->fetch_all();						
						
						// print_r($orderItemData);
			  		$arrayNumber = 0;
			  		// for($x = 1; $x <= count($orderItemData); $x++) {
			  		$x = 1;
			  		while($orderItemData = $orderItemResult->fetch_array()) { 
			  			// print_r($orderItemData); ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['product_id'] == $orderItemData['product_id']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />			  					
			  					<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />			  					
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $orderItemData['quantity']; ?>" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $orderItemData['total']; ?>"/>			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['total']; ?>"/>			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
		  			$x++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $data[4] ?>" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $data[4] ?>" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label">VAT 13%</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="vat" disabled="true" value="<?php echo $data[5] ?>"  />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" value="<?php echo $data[5] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data[6] ?>" />
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?php echo $data[6] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Discount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" value="<?php echo $data[7] ?>" />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" value="<?php echo $data[8] ?>"  />
				      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="<?php echo $data[8] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  		  
			  </div> <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" value="<?php echo $data[9] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Due Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" value="<?php echo $data[10] ?>"  />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data[10] ?>"  />
				    </div>
				  </div> <!--/form-group-->		
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentType" id="paymentType" >
				      	<option value="">~~SELECT~~</option>
				      	<option value="1" <?php if($data[11] == 1) {
				      		echo "selected";
				      	} ?> >Cheque</option>
				      	<option value="2" <?php if($data[11] == 2) {
				      		echo "selected";
				      	} ?>  >Cash</option>
				      	<option value="3" <?php if($data[11] == 3) {
				      		echo "selected";
				      	} ?> >Credit Card</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentStatus" id="paymentStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1" <?php if($data[12] == 1) {
				      		echo "selected";
				      	} ?>  >Full Payment</option>
				      	<option value="2" <?php if($data[12] == 2) {
				      		echo "selected";
				      	} ?> >Advance Payment</option>
				      	<option value="3" <?php if($data[10] == 3) {
				      		echo "selected";
				      	} ?> >No Payment</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
			  </div> <!--/col-md-6-->

			  UNNECESSARY STUFF

*/?>-->

			  <div class="form-group editButtonFooter">
			  <!--NO NEED FOR ADD ROW
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>
			    -->
			    <div class="col-sm-offset-3 col-sm-9">
			    <input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET['i']; ?>" />
			    <?php
			    if($readonly_text!="readonly"){
			    	echo '<button type="submit" id="editOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign "></i> Save Changes</button>';
			    }
			    ?>
			    
			      
			    </div>
			  </div>
			</form>

			<?php
		} // /get order else  ?>


	</div> <!--/panel-->	
</div> <!--/panel-->	


<!-- edit order -->
<div class="modal fade" tabindex="-1" role="dialog" id="paymentOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Edit Payment</h4>
      </div>      

      <div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;" >

      	<div class="paymentOrderMessages"></div>

      	     				 				 
			  <div class="form-group">
			    <label for="due" class="col-sm-3 control-label">Due Amount</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="due" name="due" disabled="true" />					
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="payAmount" class="col-sm-3 control-label">Pay Amount</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="payAmount" name="payAmount"/>					      
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentType" id="paymentType" >
			      	<option value="">~~SELECT~~</option>
			      	<option value="1">Cheque</option>
			      	<option value="2">Cash</option>
			      	<option value="3">Credit Card</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->							  
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentStatus" id="paymentStatus">
			      	<option value="">~~SELECT~~</option>
			      	<option value="1">Full Payment</option>
			      	<option value="2">Advance Payment</option>
			      	<option value="3">No Payment</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->							  				  
      	        
      </div> <!--/modal-body-->
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="updatePaymentOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>	
      </div>           
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /edit order-->

<!-- remove order -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Order</h4>
      </div>
      <div class="modal-body">

      	<div class="removeOrderMessages"></div>

        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove order-->




<script src="custom/js/order1.js"></script>

<?php require_once 'includes/footer.php'; ?>


<script type="text/javascript">


	<?php 

		$query="SELECT * FROM `products`";
		$result = $connect->query($query);

		echo "var products_price_array=[];";
		echo "var products_profit_array=[];";
		
		while($row=mysqli_fetch_assoc($result)){
			$price=$row['price'];
			$profit=$row['profit'];
			$id=$row['id'];

			echo "products_price_array[".$id."]=[".$price."];";
			echo "products_profit_array[".$id."]=[".$profit."];";



		}



	?>

	function getPriceAndProfit() {



	var base_price = 10;

	var product_selected = document.getElementById("productName");
	var product_id = product_selected.options[product_selected.selectedIndex].value;






// boolean outputs "" if false, "1" if true
var price = products_price_array[product_id];
var profit =  products_profit_array[product_id];


	document.getElementById('productPrice').value = price;
	document.getElementById('productProfit').value = profit;

}

</script>

	