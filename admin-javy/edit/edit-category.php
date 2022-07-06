<?php include '../header.php'; 


if(isset($_GET['id'])){
	$id=$_GET['id'];

$query='SELECT * FROM categories WHERE categories_id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){


	echo '<br>';
	echo '<form method="GET" action="../submit/submit-edit-category.php" id="editCategoryForm">';

    echo '<div class="row"><div class="col-md-6"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label>Category Id:</label>';
	echo '<input class="form-control" name="id" value="'.$id.'" readonly></input></div>';

  echo '<div class="form-group"><label>New Category Id:</label>';
  echo '<input class="form-control" name="new_category_id" value="'.$id.'" ></input></div>';

	echo '<div class="form-group"><label>Category Name:</label>';
	echo '<input class="form-control" name="categoryName" value="'.$row['categories_name'].'" ></input></div>';

  echo '<div class="form-group"><label>Javytech Id:</label>';
  echo '<input class="form-control" name="javytech_id" value="'.$row['javytech_id'].'" ></input></div>';

	echo '<div class="form-group"><label>Category Slug:</label>';
	echo '<input class="form-control" name="categorySlug" value="'.$row['categories_slug'].'" ></input></div>';
  echo '<input name="previousCategorySlug" type="hidden" value="'.$row['categories_slug'].'" ></input>';

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
    cursor: pointer;" type="submit" value="UPDATE"></div</div></div></div></div></form>';





}
}
    echo '<a href="../delete/delete-category.php?id='.$id.'" ><button style="background-color: #FF0000;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-left: 20px;
    cursor: pointer;">Delete Category</button></a>';






?>

<?php include '../footer.php'; ?>


<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editCategoryForm").unbind('submit').bind('submit',function(){


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
              setTimeout(function() {
              // Do something after 5 seconds
              $("#messages").html('');
              }, 1000);

              //remove the messages after 10 seconds

              

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
