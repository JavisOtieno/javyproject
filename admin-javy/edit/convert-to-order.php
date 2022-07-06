<?php include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM product_messages WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	echo '<br>';

	echo '<form method="GET" action="../submit/submit-order-from-message.php" id="convertToOrderForm">';

	echo '<div class="row"><div class="col-md-4"><div style="margin-left:20px;"><div class="form-group"><label>Customer Name:</label><br/>';
	echo '<input class="form-control" name="name" value="'.$row['name'].'"></input></div>';

	echo '<div class="form-group"><label>Customer Phone:</label><br/>';
	echo '<input class="form-control" name="phone" value="'.$row['phone'].'"></input></div>';

	echo '<div class="form-group"><label>Customer Email:</label><br/>';
	echo '<input class="form-control" name="email" value="'.$row['email'].'"></input></div>';

	$customer_id=$row['customer_id'];
$query_customer='SELECT * FROM customers WHERE id='.$customer_id.'';
$query_run_customer=mysqli_query($db_link,$query_customer);
if($row_customer=mysqli_fetch_assoc($query_run_customer)){
	$customer_address=$row_customer['deliverydetails'];
	}

	echo '<div class="form-group"><label>Customer Email:</label><br/>';
	echo '<input class="form-control" name="email" value="'.$customer_address.'"></input>
	</div></div></div>';

	// echo '<div style="margin-top:10px"><label>Product Name:</label><br/></div>';
	// echo '<div><input name="product_name" value="'.$row['product_name'].'" readonly></input></div>';

	// echo '<div style="margin-top:10px"><label>Product Price:</label><br/></div>';
	// echo '<div><input name="product_price" value="'.$row['product_price'].'" ></input></div>';

	// echo '<div style="margin-top:10px"><label>Product Profit:</label><br/></div>';
	// echo '<div><input name="product_profit" value="'.$row['product_profit'].'" ></input></div>';
$product_id=$row['product_id'];

$query_product='SELECT * FROM products WHERE id='.$product_id.'';
$query_run_product=mysqli_query($db_link,$query_product);
if($row_product=mysqli_fetch_assoc($query_run_product)){
	$supplier_id=$row_product['supplier_id'];
	$product_price=$row_product['price'];
	$product_profit=$row_product['profit'];
	$product_name=$row_product['name'];
	}

	echo '<div class="col-md-4"><div style="margin-left:20px;">';
	echo '<div class="form-group"><label>Product Name:</label><br/>';
	echo '<input class="form-control" name="product_name" value="'.$product_name.'"></input></div>';

	echo '<div class="form-group"><label>Product Price:</label><br/>';
	echo '<input class="form-control" name="product_price" value="'.$product_price.'"></input></div>';

	echo '<div class="form-group"><label>Product Profit:</label><br/>';
	echo '<input class="form-control" name="product_profit" value="'.$product_profit.'"></input></div>';

	echo '<div class="form-group"><label>Product Id:</label><br/>';
	echo '<input class="form-control" name="product_id" value="'.$product_id.'"></input></div></div></div>';
	
	echo '<div class="col-md-4"><div style="margin-left:20px;">';
	echo '<div class="form-group"><label>Supplier Id:</label><br/>';
	echo '<input class="form-control" name="supplier_id" value="'.$supplier_id.'" readonly></input></div>';
	// echo '<div style="margin-top:10px"><label>Supplier Id:</label><br/>';
	// echo '<input name="supplier_id" value="'.$row['supplier_id'].'" readonly></input></div>';


	echo '<div class="form-group"><label>Customer Id:</label><br/>';
	echo '<input class="form-control" name="customer_id" value="'.$row['customer_id'].'" readonly></input></div>';

	echo '<div class="form-group"><label>Dealer Id:</label><br/>';
	echo '<input class="form-control" name="dealer_id" value="'.$row['dealer_id'].'" readonly></input></div>';

	

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


	echo '<select class="form-control" name="status" >  <option value="0" '.$selected0.' >Processing</option>
  	<option value="1" '.$selected1.'>Complete</option>
  	<option value="2" '.$selected2.'>Cancelled</option></select></div></div></div></div>';
	
	echo '<div id="messages"></div>';


	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="CONVERT"></form>';




}

?>

<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#convertToOrderForm").unbind('submit').bind('submit',function(){


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
        
              }, 1000);

              setTimeout(function () {
								window.location.href = "../orders.php";
							}, 2000);

              

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