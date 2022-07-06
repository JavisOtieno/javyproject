<?php include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

	$query_payment="SELECT * FROM supplier_payments WHERE payment_id='$id'";
	$query_run_payment=mysqli_query($db_link,$query_payment);

	while($row_payment=mysqli_fetch_assoc($query_run_payment)){
		$supplier_id=$row_payment['supplier_id'];
		$order_id=$row_payment['order_id'];
		$amount=$row_payment['amount'];
		$date=date('d/m/Y \a\t h:iA', $row_payment["date"]);
		$status=$row_payment['status'];
	}


	
	$query_supplier="SELECT * FROM suppliers WHERE id='$supplier_id'";
	$query_run_supplier=mysqli_query($db_link,$query_supplier);

	while($row_supplier=mysqli_fetch_assoc($query_run_supplier)){
		echo "<div style='margin-left:20px;'> Supplier : ".$row_supplier['username']."  Name: ".$row_supplier['name']." Number:".$row_supplier['phone'].'</div>';
	}

	echo '<form method="GET" action="../submit/submit-edit-payment.php" id="editPaymentForm">';

	echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';


	echo '<div class="form-group"><label>Payment id:</label>';
	echo '<input class="form-control" name="id" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Order id:</label>';
	echo '<input class="form-control" name="orderId" value="'.$order_id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Supplier id:</label>';
	echo '<input class="form-control" name="supplierId" value="'.$supplier_id.'" readonly></input></div>';



	echo '<div class="form-group"><label>Cost:</label>';
	echo '<input class="form-control" name="cost" value="'.$amount.'" ></input></div>';

	echo '<div class="form-group"><label>Status:</label><br/>';
	if($status==0){
	$selected0='selected';	
	}else{
		$selected0='';
	}

	if($status==1){
	$selected1='selected';	
	}else{
		$selected1='';
	}

	if($status==2){
	$selected2='selected';	
	}else{
		$selected2='';
	}


	echo '<select class="form-control" name="status">
  <option value="0" '.$selected0.' >Unprocessed</option>
  <option value="1" '.$selected1.'>Complete</option>
  <option value="2" '.$selected2.'>Cancelled</option>
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

$("#editPaymentForm").unbind('submit').bind('submit',function(){


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
