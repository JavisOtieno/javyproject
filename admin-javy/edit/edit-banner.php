<?php include '../header.php'; 


if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM banners WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	echo '<br>';
	echo '<form method="GET" action="../submit/submit-edit-banner.php" id="editOfferForm">';

	echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Banner Id:</label>';
	echo '<input class="form-control" name="id" value="'.$id.'" readonly></input></div>';

	//save for the view php image button below
	
	echo '<div class="form-group"><label>Banner Title:</label>';
	echo '<input class="form-control" name="title" value="'.$row['title'].'"></input></div>';

	echo '<div class="form-group"><label>Banner Image Link:</label>';
	echo '<input class="form-control" name="imagelink" value="'.$row['image'].'" ></input></div>';

    echo '<div class="form-group"><label>Banner HTTP Link:</label>';
  echo '<input class="form-control" name="link" value="'.$row['link'].'" ></input></div>';



  //echo '<div><input name="status" value="'.$row['status'].'"></input></div>';


  echo '<div class="form-group"><label>Date and Time:</label>';
  echo '<input class="form-control" name="date" value="'.date('d/m/Y \a\t h:iA', $row["date"]).'" readonly></input></div>';

  echo '</div></div>';

  echo '<div class="col-md-6"><div style="margin-left:20px;">';
  echo '<div class="form-group"><label>Price:</label>';
echo '<input class="form-control" name="price" value="'.$row['price'].'" ></input></div>';


  echo '<div class="form-group"><label>Link:</label>';
echo '<input class="form-control" name="link" value="'.$row['link'].'" ></input></div>';

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
  <option value="0" '.$selected0.' >Inactive</option>
  <option value="1" '.$selected1.'>Active</option>
  <option value="2" '.$selected2.'>To Activate</option>
</select></div><br/>';




echo '</div></div></div>';

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
    cursor: pointer;" type="submit" value="UPDATE"></form>';

    echo '<form action="../submit/uploadImageBanner.php?id='.$id.'" method="post" enctype="multipart/form-data"  id="uploadImageForm">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>';




   

   

    echo '<a href="http://promote.javy.co.ke/'.$row["image"].'" target="_blank"><button style="background-color: #F87219;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">View Image</button></a>';


}



?>

<?php include '../footer.php'; ?>


<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editOfferForm").unbind('submit').bind('submit',function(){


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
  
  $(document).ready(function(){
  $("#messages").html("");

$("#uploadImageForm").unbind('submit').bind('submit',function(){


      /*
      $(".text-danger").remove();
    //remove the form error
    $(".form-group").removeClass('has-error').removeClass('has-success');
    */

        var form_data = new FormData($(this)[0]);
        
        var form =$(this);

        $.ajax({
          url : form.attr('action'),
            type: form.attr('method'),
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data : form_data,         
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
          ,
    error: function (request, status, error) {
        alert(request.responseText);
    }
        });//ajax
        
      
      
    


      return false;
    });//submit categories form function

});
</script>
<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#uploadPHPForm").unbind('submit').bind('submit',function(){


      /*
      $(".text-danger").remove();
    //remove the form error
    $(".form-group").removeClass('has-error').removeClass('has-success');
    */

        var form_data = new FormData($(this)[0]);
        
        var form =$(this);

        $.ajax({
          url : form.attr('action'),
            type: form.attr('method'),
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data : form_data,         
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
          ,
    error: function (request, status, error) {
        alert(request.responseText);
    }
        });//ajax
        
      
      
    


      return false;
    });//submit categories form function

});
</script>



