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
  <li><a href="messages.php">Messages</a></li>
  <li class="active">View Message</li>
</ol>





<div class="panel panel-default">
	<div class="panel-heading">
			<i class="glyphicon glyphicon-eye-open"></i> View Message
		</div> <!--/panel-->	
	<div class="panel-body">
			

		
			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/editMessage.php" id="editOrderForm">

  			<?php 
  			$messageId = $_GET['id'];
  			$type = $_GET['type'];

  			 if($type=='contact'){
			  	$sql2 = "SELECT * FROM customer_contact_forms WHERE id = {$messageId}";
			  }
			  else{
			  	$sql2 = "SELECT * FROM product_messages WHERE id = {$messageId}";
			  }
			  
			

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
			    <label for="message" class="col-sm-3 control-label">Message</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="message" name="clientDeliveryDetails" placeholder="Message" autocomplete="off" value="<?php echo $data['message'] ?>" <?php echo $readonly_text ?>/>
			    </div>
			  </div> 

			  <?php 
			  if($type=='contact'){
			  	echo "<!--";
			  }
			  ?>

			  	<div class="form-group">

			  	<label for="productName" class="col-sm-3 control-label">Product Name</label>
			  	<div class="col-sm-9">
			  					<select class="form-control" name="productName" id="productName" <?php echo $readonly_text ?> onchange="getPriceAndProfit()" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM products WHERE status = 1 ";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {	

			  							if($data['product_id']==$row['id'])	{
			  								$selected="selected='selected'";
			  							}
			  							else{
			  								$selected="";
			  							}						 		
			  								echo "<option value='".$row['id']."' id='changeProduct".$row['id']."'  ".$selected.">".$row['name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
		  						</div>
			  					</div>

			  					   <?php 
			  if($type=='contact'){
			  	echo "-->";
			  }
			  ?>


			  	<div class="form-group">
			    <label for="status" class="col-sm-3 control-label">Status</label>
			    <div class="col-sm-9">
			      					<?php if($data['status'] == 1) {
								 		echo "<label class='label label-success'>Answered</label>";
								 	} else if($data['status'] == 0) {
								 		echo "<label class='label label-warning'>Processing ...</label>";
								 	}else{
								 		echo "<label class='label label-danger'>Not Answered</label>";
								 	}
					?>			 	
			    </div>
			  </div> 

			 			

			  					<div class="form-group">
			    <label for="messageNotes" class="col-sm-3 control-label">Message Notes</label>
			    <div class="col-sm-9">
			      <textarea readonly type="text" class="form-control" id="messageNotes" name="messageNotes" placeholder="<?php echo $data['notes'] ?>" autocomplete="off" value="<?php echo $data['notes'] ?>" ></textarea>
			    </div>
			  </div>

			 	

			  <div class="form-group">
			    <label for="Date" class="col-sm-3 control-label">Date</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="date" name="date" placeholder="Date" autocomplete="off" value="<?php echo date('d/m/Y \a\t h:iA' , $data['date']); ?>" readonly/>
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




<script src="custom/js/messages.js"></script>

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

