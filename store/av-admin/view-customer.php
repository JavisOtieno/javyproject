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
  <li><a href="customers.php">Customers</a></li>
  <li class="active">View Customer</li>
</ol>





<div class="panel panel-default">
	<div class="panel-heading">
			<i class="glyphicon glyphicon-eye-open"></i> View Customer
		</div> <!--/panel-->	
	<div class="panel-body">
			

		
			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/editMessage.php" id="editOrderForm">

  			<?php 
  			$customerId = $_GET['id'];

  			$sql2 = "SELECT * FROM customers WHERE id = {$customerId}";
			
				$result = $connect->query($sql2);
				$data = $result->fetch_assoc();				

			//making form read only for ordered by client and processed deal

			 		$readonly_text='readonly';


			?>

  			  <div class="form-group">
			    <label for="clientName" class="col-sm-3 control-label">Customer Name</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Customer Name" autocomplete="off" value="<?php echo $data['name'] ?>" <?php echo $readonly_text ?> />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Customer Phone Number</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Customer Phone Number" autocomplete="off" value="<?php echo $data['phone'] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div> <!--/form-group-->		
			    <div class="form-group">
			    <label for="clientEmail" class="col-sm-3 control-label">Customer Email</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientEmail" name="clientEmail" placeholder="Customer Email(optional)" autocomplete="off" value="<?php echo $data['email'] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div> <!--/form-group-->	

			  <div class="form-group">
			    <label for="message" class="col-sm-3 control-label">Delivery Details</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="clientDeliveryDetails" name="clientDeliveryDetails" placeholder="clientDeliveryDetails" autocomplete="off" value="<?php echo $data['deliverydetails'] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div> 


			  <div class="form-group editButtonFooter">
			
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




<script src="custom/js/categories.js"></script>

<?php require_once 'includes/footer.php'; ?>

