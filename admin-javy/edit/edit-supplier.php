<?php

include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM suppliers WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	echo '<form method="GET" action="../submit/submit-edit-supplier.php" id="editSupplierForm">';

	echo '<div class="col-md-6"><div style="margin-left:20px;"><div class="form-group"><label>Supplier Id:</label>';
	echo '<input name="supplier_id" class="form-control" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Username:</label>';
	echo '<input class="form-control" name="username" value="'.$row['username'].'"></input></div>';

	echo '<div class="form-group"><label>Email:</label>';
	echo '<input class="form-control" name="email" value="'.$row['email'].'"></input></div>';

	echo '<div class="form-group"><label>Phone Number:</label>';
	echo '<div><input class="form-control" name="phone" value="'.$row['phone'].'"></input></div>';

	echo '<div class="form-group"><label>Name:</label>';
	echo '<input class="form-control" name="name" value="'.$row['name'].'"></input></div>';

    echo '<div class="form-group"><label>Registered on:</label>';
  echo '<input class="form-control" name="name" value="'.$row['registered_on'].'"></input></div>';



echo '<div class="form-group"><label>Authorization Status:</label>';

	if($row['authorized']==0){
	$selectstatus0='selected';	
	}else{
		$selectstatus0='';
	}

	if($row['authorized']==1){
	$selectstatus1='selected';	
	}else{
		$selectstatus1='';
	}


echo '<select class="form-control" name="authorization_status">
  <option value="0" '.$selectstatus0.' >NOT AUTHORIZED</option>
  <option value="1" '.$selectstatus1.'>Authorized</option>
</select></div>';



echo '<div class="form-group"><label>.co.ke website:</label>';

  if($row['co_ke']==0){
  $selectstatus0='selected';  
  }else{
    $selectstatus0='';
  }

  if($row['co_ke']==1){
  $selectstatus1='selected';  
  }else{
    $selectstatus1='';
  }


echo '<select class="form-control" name="co_ke">
  <option value="0" '.$selectstatus0.' >.av.ke</option>
  <option value="1" '.$selectstatus1.'>.co.ke</option>
</select></div>';


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


}

?>

<?php include '../footer.php'; ?>

<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editSupplierForm").unbind('submit').bind('submit',function(){


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

        
              

            }//if */
          } //success
        });//ajax
        
      
      
    


      return false;
    });//submit categories form function

});
</script>
