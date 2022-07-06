<?php include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];

$query='SELECT * FROM brands WHERE brand_id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){


	echo '<br>';
	echo '<form method="GET" action="../submit/submit-edit-brand.php" id="editBrandForm">';

    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Brand Id:</label>';
	echo '<input class="form-control" name="id" value="'.$id.'" readonly></input></div>';

	echo '<div class="form-group"><label>Brand Name:</label>';
	echo '<input class="form-control" name="brand_name" value="'.$row['brand_name'].'" ></input></div>';

	echo '<div class="form-group"><label>Brand Slug:</label>';
	echo '<input class="form-control" name="brand_slug" value="'.$row['brand_slug'].'" ></input></div>';
  echo '<input name="previous_brand_slug" type="hidden" value="'.$row['brand_slug'].'" ></input>';


  echo '<div class="form-group"><label>Javytech Id:</label>';
  echo '<input class="form-control" name="javytech_id" value="'.$row['javytech_id'].'" ></input></div>';

	$brand_category=$row['brand_category'];
    echo '<div><label>Product Brand:</label>
    <select class="form-control" id="brandCategory" name="brandCategory">
    <option value="">~~SELECT~~</option>';
        
        $sql = "SELECT categories_id, categories_name,categories_slug, categories_status FROM categories WHERE categories_status = 1";
                $result = $connect->query($sql);

                while($row = $result->fetch_array()) {
                    echo "<option value='".$row[0]."'";
                    if($row[0]==$brand_category){
                    	echo "selected";
                    }
                    echo ">".$row[1]."</option>";
                } // while

          echo "<option value='other'>Other</option>";
                                
    echo '</select></div>';

  echo '<input name="previous_brand_category" type="hidden" value="'.$brand_category.'" ></input>';


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

    echo '<a href="../delete/delete-brand.php?id='.$id.'" ><button style="background-color: #FF0000;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left: 20px;

    cursor: pointer;">Delete brand</button></a>';




?>

<?php include '../footer.php'; ?>


<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editBrandForm").unbind('submit').bind('submit',function(){


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
