<?php include '../header.php';  

if(isset($_GET['shop_id'])){
		$shop_id=$_GET['shop_id'];
		$shop_name=$_GET['shop_name'];

	}else{
		$shop_id=61710;
		$shop_name="Javytech";
	}

?>

	
	<form id="submitOrderForm" action="../submit/submit-order.php" method="GET">
	<div class="row"><div class="col-md-6"><div style="margin-left:20px;">
	<div class="form-group">
	<label>Shop : </label><?php echo $shop_name ?><br/>
	<input type="text" class="form-control" name="shopId"  id="shopId" value="<?php echo $shop_id ?>" readonly="readonly" />
	<a href="../searchshop.php"><button type="button" style="margin-top: 10px;" class="btn btn-primary">Change Shop</button></a>
	</div>
	<div class="form-group">
	<label>Customer Name:</label><br/>
	<input type="text" class="form-control" name="customerName" id="customerName"/>
	</div>
	<div class="form-group">
	<label>Customer Phone:</label><br/>
	<input type="text" class="form-control" name="customerPhone" id="customerPhone"/>
	</div>
	<div class="form-group">
	<label>Customer Email:</label>
	<input type="text" class="form-control" name="customerEmail" id="customerEmail"/>
	</div>
	<div class="form-group">
	<label>Customer Address:</label><br/>
	<pre><textarea class="form-control" rows="6" name="customerAddress"></textarea></pre>
	</div></div></div>

	<div class="col-md-6"><div style="margin-left:20px;"><div class="form-group">
	<label>Product Name:</label><br/>
	<input type="text" class="form-control" name="productName"  id="productName"/></div>
	<div class="form-group">
	<label>Product Price:</label><br/>
	<input type="text" class="form-control" name="productPrice"  id="productPrice"/>
	</div>
	<div class="form-group">
	<label>Order Notes:</label><br/>
	<pre><textarea class="form-control" rows="6" name="orderNotes"></textarea></pre>
	</div>

	


				     
	
	
	
	

	</div></div></div>
<div id="messages"></div>
	<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="SUBMIT ORDER">

	</form>
	
<?php include '../footer.php'; ?>

<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	$("#messages").html("");

$("#submitOrderForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/

			var customerName=$("#customerName").val();
			var customerPhone=$("#customerPhone").val();
		

			if(customerName&&customerPhone){

				
				var form =$(this);

				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){
					
						if(response.success == true){


						
							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);

							//reset the form text
							//$("#submitOrderForm")[0].reset();
						

							$("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

							//remove the messages after 10 seconds

							setTimeout(function () {
								window.location.href = "../../orders.php";
							}, 1000);
							

						}//if */
						else if(response.success == false){

						
						//console.log(response);
							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);

							//reset the form text
						

							$("#messages").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

							//remove the messages after 10 seconds
							

						}//if */
					} //success
				});//ajax
				
			
			}//if
		


			return false;
		});//submit categories form function

});
</script>