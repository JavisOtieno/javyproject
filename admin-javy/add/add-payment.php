<?php  include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

	$query_order="SELECT * FROM deals WHERE id='$id'";
	$query_run_order=mysqli_query($db_link,$query_order);

	while($row_order=mysqli_fetch_assoc($query_run_order)){

		$supplier_id=$row_order['supplier_id'];
		$product_id=$row_order['product_id'];
		$cost=$row_order['cost'];


	}





	$query_supplier="SELECT * FROM suppliers WHERE id='$supplier_id'";
	$query_run_supplier=mysqli_query($db_link,$query_supplier);

	while($row_supplier=mysqli_fetch_assoc($query_run_supplier)){
		echo "<div style='margin-left:20px'>Supplier : <strong>".$row_supplier['username']."</strong>  Name: <strong>".$row_supplier['name']."</strong> Number: <strong>".$row_supplier['phone']."</strong></div>";
	}

	echo '<br>';
	echo '<form method="GET" action="../submit/submit-payment.php" id="submitPaymentForm">';

    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Order id:</label><br/>';
	echo '<input class="form-control" name="orderId" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Supplier id:</label><br/>';
	echo '<input class="form-control" name="supplierId" value="'.$supplier_id.'" readonly></input></div>';


	echo '<div class="form-group"><label>Cost:</label><br/>';
	echo '<input class="form-control" name="cost" value="'.$cost.'" ></input></div>';

	echo '<div class="form-group"><label>Status:</label><br/>';
	echo '<select class="form-control" name="status">
  	<option value="0" >Unprocessed</option>
  	<option value="1" selected>Complete</option>
  	<option value="2" >Cancelled</option>
	</select></div>';

	echo '<div id="messages"></div>';
	//echo '<div style="margin-top:10px"><label>Status:</label><br/></div>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';



	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;" type="submit" value="SUBMIT"></form>';



?>

<?php include '../footer.php'; ?>

 <script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	$("#messages").html("");

$("#submitPaymentForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/

				
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
								window.location.href = "../payments.php";
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
				
			
			
		


			return false;
		});//submit categories form function

});
</script>