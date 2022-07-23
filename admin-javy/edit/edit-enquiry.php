<?php include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];

$query='SELECT * FROM enquiries WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){


	echo '<br>';
	echo '<form method="GET" action="../submit/submit-edit-enquiry.php" id="editEnquiryForm">';

    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Enquiry Id:</label>';
	echo '<input class="form-control" name="id" value="'.$id.'" readonly></input></div>';

  echo '<div class="form-group"><label>Enquiry Date:</label>';
  echo '<input class="form-control" name="enquiry_date" value="'.$row['enquiry_date'].'" readonly></input></div>';

	echo '<div class="form-group"><label>Enquiry Phone:</label>';
	echo '<input class="form-control" name="enquiry_phone" value="'.$row['enquiry_phone'].'" ></input></div>';

	echo '<div class="form-group"><label>Enquiry Item:</label>';
	echo '<input class="form-control" name="enquiry_item" value="'.$row['enquiry_item'].'" ></input></div>';

    echo '<div class="form-group"><label>Enquiry Description:</label>';
  echo '<input class="form-control" name="enquiry_description" value="'.$row['enquiry_description'].'" ></input></div>';

      echo '<div class="form-group"><label>Enquiry Notes:</label>';
  echo '<input class="form-control" name="enquiry_notes" value="'.$row['enquiry_notes'].'" ></input></div>';







    echo '<div id="messages"></div></div></div>
    </div>';

    	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left:20px;
     margin-top: 10px;
    cursor: pointer;" type="submit" value="UPDATE"/></form>';




}



}

    echo '<a href="../delete/delete-enquiry.php?id='.$id.'" ><button style="background-color: #FF0000;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left: 20px;

    cursor: pointer;">Delete Enquiry</button></a>';




?>

<?php include '../footer.php'; ?>


<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editEnquiryForm").unbind('submit').bind('submit',function(){


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

               setTimeout(function() {
              // Do something after 5 seconds
              location.reload();
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
