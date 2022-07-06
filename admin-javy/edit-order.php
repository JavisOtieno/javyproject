<?php include '../header.php'; 


if($userId == 1){
$hidden="";
$readonly="";
}else{
$hidden="hidden";
$readonly="readonly";
}

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM deals WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

		$dealer_id=$row['dealer_id'];
		$supplier_id=$row['supplier_id'];


	$query_store="SELECT * FROM users WHERE user_id='$dealer_id'";
	$query_run_store=mysqli_query($db_link,$query_store);

	$order_by_dealer=$row['order_by_dealer'];

	if($order_by_dealer==1){
		$order_by='ORDER BY DEALER';
	}else if($order_by_dealer==0){
		$order_by='ORDER BY CLIENT ON SITE';
	}else if($order_by_dealer==3){
		$order_by="ORDER BY DEALER ON APP";
	}else if($order_by_dealer==4){
		$order_by="ORDER BY CLIENT ON APP";
	}else if($order_by_dealer==5){
		$order_by="ORDER BY SUPPLIER'S CLIENT ON SITE";
	}

	if($order_by_dealer!=5){
	while($row_store=mysqli_fetch_assoc($query_run_store)){
		echo "<div style='margin-left:20px;''><strong>Store:</strong> ".$row_store['storename']."  <strong>Name: </strong>".$row_store['firstname']." ".$row_store['lastname']."  <strong>Number:</strong>".$row_store['phone'].'</strong></div>';

		if($row_store['supplier_registered_on']){
			echo "  <strong>SUPPLIER'S PROMOTER</strong>  ";
			$supplier_registered_on=$row_store['supplier_registered_on'];

			$query_supplier="SELECT * FROM suppliers WHERE id='$supplier_registered_on'";
			$query_run_supplier=mysqli_query($db_link,$query_supplier);

			while($row_supplier=mysqli_fetch_assoc($query_run_supplier)){
			echo "<div style='margin-left:20px;''><strong>Supplier name:</strong> ".$row_supplier['username']."  <strong>Name: </strong>".$row_supplier['name']."  <strong>Number:</strong>".$row_supplier['phone'].'</strong></div>';
	}
		}

	}
		}else{

	$query_supplier="SELECT * FROM suppliers WHERE id='$supplier_id'";
	$query_run_supplier=mysqli_query($db_link,$query_supplier);

	while($row_supplier=mysqli_fetch_assoc($query_run_supplier)){
	echo "<div style='margin-left:20px;''><strong>Supplier name:</strong> ".$row_supplier['username']."  <strong>Name: </strong>".$row_supplier['name']."  <strong>Number:</strong>".$row_supplier['phone'].'</strong></div>';
	}

		}

	echo ' order by:<strong>'.$order_by;



	echo '<br>';
	echo '<form method="GET" action="../submit/submit-edit-order.php" id="EditOrderForm">';

	echo '<div class="row"><div class="col-md-4"><div style="margin-left:20px;"><div class="form-group"><label>Deal Id:</label><br/>';
	echo '<input name="deal_id" class="form-control" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Customer Name:</label><br/>';
	echo '<input name="name" class="form-control" value="'.$row['name'].'"></input></div>';

	echo '<div class="form-group"><label>Customer Phone:</label><br/>';
	echo '<input name="phone" class="form-control" value="'.$row['phone'].'"></input></div>';

	echo '<div class="form-group"><label>Customer Email:</label><br/>';
	echo '<input class="form-control" name="email"  value="'.$row['email'].'"></input></div>';

	echo '<div class="form-group"><label>Delivery Details:</label><br/>';
	echo '<input  class="form-control" name="delivery_details" value="'.$row['delivery_details'].'"></input></div>';

	echo '<div class="form-group"><label>Order Notes:</label><br/>';
	echo '<input class="form-control" name="notes"  value="'.$row['notes'].'"></input></div></div></div>';

	echo '<div class="col-md-4"><div style="margin-left:20px;"><div class="form-group"><label>Product Name:</label><br/>';
	echo '<input class="form-control" name="product_name" value="'.$row['product_name'].'" ></input></div>';

	echo '<div class="form-group"><label>Product Price:</label><br/>';
	echo '<input class="form-control" name="product_price" value="'.$row['product_price'].'" ></input></div>';

	echo '<div class="form-group">';
	if($userId == 1){echo '<label>Product Cost:</label><br/>';}
	echo '<input class="form-control" class="form-control" name="cost" value="'.$row['cost'].'" '.$hidden.'></input></div>';

	echo '<div class="form-group">';
	if($userId == 1){echo '<label>Product Profit:</label><br/>';}
	echo '<input class="form-control" name="product_profit" value="'.$row['product_profit'].'" '.$hidden.'></input></div>';

	echo '<div class="form-group"><label>Product Id:</label><br/>';
	echo '<input class="form-control" name="product_id" value="'.$row['product_id'].'" 
	'.$readonly.'></input></div>';

	$query_product="SELECT * FROM products WHERE id='".$row['product_id']."'";
	$query_run_product=mysqli_query($db_link,$query_product);

	while($row_product=mysqli_fetch_assoc($query_run_product)){
	echo "<strong>Product name:</strong> <a href='/edit/edit-product.php?product_id=".$row_product['id']."' target='_blank'>".$row_product['name']."  <a/>";
	if($userId == 1){
	echo "<strong>Product Store: </strong>".$row_product['store_id']." <a href='/edit/edit-promoter.php?id=".$row_product['store_id']."'>view store</a>   <strong>Product Supplier: </strong>".$row_product['supplier_id']." <a href='/edit/edit-supplier.php?id=".$row_product['supplier_id']."'>view supplier</a>";
	}
	}


	echo '</div></div>';

	echo '<div class="col-md-4"><div style="margin-left:20px;"><div class="form-group">';

	if($userId == 1){echo '<label>Supplier Id:</label><br/>';}
	echo '<input class="form-control" name="supplier_id" value="'.$row['supplier_id'].'" 
	'.$hidden.'></input></div>';

	echo '<div class="form-group">';
	if($userId == 1){echo '<label>Customer Id:</label><br/>';}
	echo '<input  class="form-control" name="customer_id" value="'.$row['customer_id'].'" readonly '.$hidden.'></input></div>';

	echo '<div class="form-group">';
	if($userId == 1){echo '<label>Promoter Id:</label><br/>';}
	echo '<input  class="form-control" name="dealer_id" value="'.$row['dealer_id'].'" readonly '.$hidden.'></input></div>';


	echo '<div class="form-group"><label>Deal Date:</label><br/>';
	echo '<input  class="form-control" name="date" value="'.date('d/m/Y \a\t h:iA',$row['dealDate']).'" readonly></input></div>';

	echo '<div class="form-group">';
	if($userId == 1){echo '<label>Payment:</label><br/>';}
	if($row['payment']==0){
	$selected0='selected';	
	}else{
		$selected0='';
	}

	if($row['payment']==1){
	$selected1='selected';	
	}else{
		$selected1='';
	}



	echo '<select name="status"  class="form-control" '.$hidden.'>
  <option value="0" '.$selected0.' >Unpaid</option>
  <option value="1" '.$selected1.'>Complete payment</option>
</select></div>';



	echo '<div class="form-group"><label>Status:</label><br/>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';

	if($row['status']==0){
	$selected0='selected';	
	}else{
		$selected0='';
	}

	if($row['status']==1){
	$selected1='selected';	
	}else{
		$selected1='';
	}

	if($row['status']==2){
	$selected2='selected';	
	}else{
		$selected2='';
	}


	echo '<select name="status"  class="form-control" '.$readonly.'>
  <option value="0" '.$selected0.' >Unprocessed</option>
  <option value="1" '.$selected1.'>Complete</option>
  <option value="2" '.$selected2.'>Cancelled</option>
</select></div></div></div></div>';

echo '<div id="messages"></div>';




	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="UPDATE"></form>';

  

  //prompt for payment once deal is complete
if($userId == 1){
  if($row['status']==1){ 
$query_payment='SELECT * FROM supplier_payments WHERE order_id='.$id;

$query_run_payment=mysqli_query($db_link,$query_payment);

if(mysqli_num_rows($query_run_payment)>0){


if($row_payment=mysqli_fetch_assoc($query_run_payment)){

	$status=$row_payment['status'];

	if($status==0){
		echo "Payment Cancelled";
	}
	elseif($status==1){
		echo "Payment Complete";
	}else{
		echo "Payment Processing";
	}
}

}else{
	echo '<a href="../add/add-payment.php?id='.$id.'" ><button style="background-color: #FF9900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer; ">Make payment</button></a>';
}

} 


	
		echo '<a href="../delete/delete-order.php?id='.$id.'" ><button style="background-color: #FF0000;
	}
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Delete Order</button></a>
    ';

	}


    	echo '<a href="../view-invoice.php?id='.$id.'" ><button style="background-color: #0079D7;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer; ">View Invoice</button></a>';

    	echo '<button style="background-color: #FF9900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer; " onclick="sendInvoice('.$id.')">Send Invoice to Email</button>';

    if($userId == 1){

        	echo '<a href="../orders.php?type=promoter&&id='.$row['dealer_id'].'"><button style="background-color: #DB7BFF;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer;" >View Promoters Orders</button></a>';



    echo '<a href="../edit/edit-promoter.php?id='.$row['dealer_id'].'"><button style="background-color: #0079D7;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer;" >View Promoter</button></a>';

    if(!$row['product_id']){
    	echo '<a href="../view-cart.php?id='.$id.'"><button style="background-color: #0079D7;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer;" >View Cart</button></a>';
    }

}

	


}

?>

<?php include '../footer.php'; ?>

<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	$("#messages").html("");

$("#EditOrderForm").unbind('submit').bind('submit',function(){


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
							setTimeout(function() {
              // Do something after 5 seconds
              $("#messages").html('');
              location.reload();
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

<script type="text/javascript">
	function sendInvoice(id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
   //  document.getElementById("success-messages").innerHTML = this.response;
   var object = JSON.parse(this.responseText);

     if(object.success==true){

      $("#messages").html('<div class="alert alert-success">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');

   	setTimeout(function () {
       window.location.href = "../edit/edit-order.php?id="+id;
    }, 2000);
    
     }else{

      $("#messages").html('<div class="alert alert-danger">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');
     }

    }
  };
  xhttp.open("GET", "../send-invoice.php?id="+id, true);
  xhttp.send();

  
}

</script>