<?php include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM product_messages WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);



if($row=mysqli_fetch_assoc($query_run)){

		$dealer_id=$row['dealer_id'];
	$query_store="SELECT * FROM users WHERE user_id='$dealer_id'";
	$query_run_store=mysqli_query($db_link,$query_store);

	while($row_store=mysqli_fetch_assoc($query_run_store)){
		echo "<div style='margin-left:20px;'> Store: <strong>".$row_store['storename']."</strong>  Name: <strong>".$row_store['firstname']."</strong> ".$row_store['lastname']."  Number:<strong>".$row_store['phone']."</strong></div>";
	}



	echo '<br>';
	echo '<form method="GET" action="../submit/submit-edit-message.php" id="editMessageForm">';

	echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Message Id:</label>';
	echo '<input class="form-control" name="message_id" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Customer Name:</label>';
	echo '<input class="form-control" name="name" value="'.$row['name'].'"></input></div>';

	echo '<div class="form-group"><label>Customer Phone:</label>';
	echo '<input class="form-control" name="phone" value="'.$row['phone'].'"></input></div>';

	echo '<div class="form-group"><label>Customer Email:</label>';
	echo '<input class="form-control" name="email" value="'.$row['email'].'"></input></div>';

  echo '<div class="form-group"><label>Notes on message:</label>';
  echo '<input class="form-control" name="notes" value="'.$row['notes'].'"></input></div>';

	echo '<div class="form-group"><label>Message:</label>';
	echo '<input class="form-control" name="message" value="'.$row['message'].'" readonly></input></div></div></div>';

	// echo '<div style="margin-top:10px"><label>Product Name:</label><br/></div>';
	// echo '<div><input name="product_name" value="'.$row['product_name'].'" readonly></input></div>';

	// echo '<div style="margin-top:10px"><label>Product Price:</label><br/></div>';
	// echo '<div><input name="product_price" value="'.$row['product_price'].'" ></input></div>';

	// echo '<div style="margin-top:10px"><label>Product Profit:</label><br/></div>';
	// echo '<div><input name="product_profit" value="'.$row['product_profit'].'" ></input></div>';

	echo '<div class="col-md-6"><div style="margin-left:20px;"><div class="form-group"><label>Product Details- id-name-price:</label>';
  //get product details to display on email
$sql_product = "SELECT * FROM products WHERE id = ".$row['product_id'];
$query_product = $connect->query($sql_product);
$result_product = $query_product->fetch_assoc();

$product_name=$result_product['name'];
$product_price=$result_product['price'];
//end of getting 
	echo '<input class="form-control" name="product_id" value="'.$row['product_id'].' - '.$product_name.' - '.$product_price.'" readonly></input></div>';

	// echo '<div style="margin-top:10px"><label>Supplier Id:</label><br/>';
	// echo '<input name="supplier_id" value="'.$row['supplier_id'].'" readonly></input></div>';

	echo '<div class="form-group"><label>Customer Id:</label>';
	echo '<input class="form-control" name="customer_id" value="'.$row['customer_id'].'" readonly></input></div>';

	echo '<div class="form-group"><label>Dealer Id:</label>';
	echo '<input class="form-control" name="dealer_id" value="'.$row['dealer_id'].'" readonly></input></div>';


	


	echo '<div class="form-group"><label>Message Date:</label>';
	echo '<input class="form-control" class="form-control" name="date" value="'.date('d/m/Y \a\t h:iA', $row['date']).'" readonly></input></div>';

	echo '<div class="form-group"><label>Status:</label>';
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


	echo '<select class="form-control" name="status">
  <option value="0" '.$selected0.' >Processing</option>
  <option value="1" '.$selected1.'>Answered</option>
  <option value="2" '.$selected2.'>Not Answered</option>
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
    cursor: pointer;" type="submit" value="UPDATE"></form>';


    	echo '<div><a href="convert-to-order.php?id='.$id.'"><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;">Convert to order</button></a></div>';


}

?>

<?php include '../footer.php'; ?>


<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editMessageForm").unbind('submit').bind('submit',function(){


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
