<?php include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM customers WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);



	


if($row=mysqli_fetch_assoc($query_run)){

	$query_promoter='SELECT * FROM users WHERE user_id='.$row['dealerid'];

	$query_run_promoter=mysqli_query($db_link,$query_promoter);


	if($row_promoter=mysqli_fetch_assoc($query_run_promoter)){

		echo '<div style="margin:20px;"><label>Store Details:</label><br/>
		Store Name: <strong>'.ucfirst($row_promoter['storename'])."</strong>  
		Phone: <strong>".$row_promoter['phone']."</strong>  
		Email: <strong>".$row_promoter['email'].'</strong><br/></div>';

	}

	echo '<form method="GET" action="../submit/submit-edit-customer.php" id="editCustomerForm">';


	echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';


	echo '<div class="form-group"><label>Customer Id:</label><br/>';
	echo '<input class="form-control" name="id" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Name:</label><br/>';
	echo '<input class="form-control" name="name" value="'.$row['name'].'"></input></div>';

	echo '<div class="form-group"><label>Phone Number:</label><br/>';
	echo '<input class="form-control" name="phone" value="'.$row['phone'].'"></input></div>';

	echo '<div class="form-group"><label>Email:</label><br/>';
	echo '<input class="form-control" name="email" value="'.$row['email'].'"></input></div></div></div>';

	echo '<div class="col-md-6"><div style="margin-left:20px;"><div class="form-group"><label>Delivery Details:</label><br/>';
	echo '<input class="form-control" name="deliverydetails" value="'.$row['deliverydetails'].'"></input></div>';

	echo '<div class="form-group"><label>Promoter ID:</label><br/>';
	echo '<input class="form-control" name="dealerid" value="'.$row['dealerid'].'" readonly></input></div></div></div></div>';


	echo '<div id="messages"></div>';

	echo '<br/><br/><input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="UPDATE"></form>';




}

?>

<?php include '../footer.php'; ?>


<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editCustomerForm").unbind('submit').bind('submit',function(){


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
