<?php include 'header.php';

if(isset($_GET['id'])){
	$order_id=$_GET['id'];
}


//CODE USED TO REMOVE ONLINE SHOP.COM FROM DESCRIPTION
/*
$query="SELECT * FROM `products` WHERE description LIKE '%our online shop.com%'";
$query_run=mysqli_query($db_link,$query)
;
while($row=mysqli_fetch_assoc($query_run)){
$description=$row['description'];
$product_id=$row['id'];
$description=str_replace('https://www.our online shop.com', '', $description);
$description=str_replace('http://www.our online shop.com', '', $description);
$description=str_replace('https:/www.our online shop.com', '', $description);
$new_description=addslashes($description);


$query_update="UPDATE `products` SET description='$new_description' WHERE id=$product_id";
if($query_run_update=mysqli_query($db_link,$query_update)){
  echo $product_id.'-updateds';
}

}
*/
//CODE USED TO REMOVE ONLINE SHOP.COM FROM DESCRIPTION

$query="SELECT * FROM products WHERE status=1 AND approval=2 AND link <> '' AND id<'$product_id' ORDER BY id DESC";

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){
  echo '<a href=edit-description.php?id='.$row['id'].'><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;">Previous</button></a>';

}





  echo '<a href=edit/edit-order.php?id='.$order_id.' ><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;">Back to Edit Order</button></a>';


$query='SELECT * FROM cart_items WHERE order_id='.$order_id.'';

$query_run=mysqli_query($db_link,$query);

echo "<br><br>";

while($row=mysqli_fetch_assoc($query_run)){

	$quantity=$row['quantity'];
  $name=$row['name'];
  $profit=$row['profit'];
  $price=$row['price'];
  $cost=$row['cost'];
  $order_id=$row['order_id'];

echo "<div style='margin-left:20px;font-size:20px;'>".$row['order_id'].' -- '.$row['name'].' -- Qty: '.$row['quantity'].' -- Price: '.$row['price'].' -- Cost: '.$row['cost'].' -- Profit: '.$row['profit'].'</div>';


     }

    


    //$description=htmlentities($description);







	echo '<input type="hidden" name="id" value="'.$product_id.'"></input></div></div>';


  $category=$row["category"];
  $brand=$row["brand"];
  $status=$row['status'];
  $approval=$row['approval'];
  $featured=$row['featured'];
  $image=str_replace( '..', 'https://promote.javy.co.ke' , $row['image']);

  ?>


          <div class="col-md-4"><div style="margin-left:20px;">

          



<?php




echo '</div></div></div>';


echo '<div id="messages"></div>';









?>


<?php include 'footer.php'; ?>



<style type="text/css">
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #4CAF50;
}

input:focus + .slider {
  box-shadow: 0 0 1px #4CAF50;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>


 
  
 <script type="text/javascript">


//edit product function
$('#editCategoryName').val('<?php echo $category; ?>');

            function setbrands() {

              
    
          $('#editBrandName').html('');


    
              <?php 
              $sql_category = "SELECT * FROM categories WHERE categories_status=1";
                    $result = $connect->query($sql_category);
                    $number_of_categories = mysqli_num_rows($result);
                    $number_of_categories = $number_of_categories+1;

                    echo "var brandsFromACategory = [];";
                    echo "var brandCategoryArray = [];";

                  
                $count_category=1;
                  while($count_category<$number_of_categories){


                    $sql_category_slug = "SELECT * FROM categories WHERE categories_id='$count_category'";
                    $result_category_slug = $connect->query($sql_category_slug);

                    while($row = $result_category_slug->fetch_array()) {
                $category_slug=$row['categories_slug'];
                } // while

                    

                    $sql = "SELECT * FROM brands WHERE brand_category='$count_category' AND brand_status=1";
                    $result = $connect->query($sql);

                    while($row = $result->fetch_array()) {
                  echo "brandsFromACategory.push('".$row['brand_slug']."');";
                } // while

                echo "brandCategoryArray['".$category_slug."']=brandsFromACategory;";
                echo "brandsFromACategory = [];";

                    $count_category++;
                  }

    
                    ?>



    if($('#editCategoryName').val()){
 
        $('#editBrandName').append('<option value="">~~SELECT~~</option>');
      var categoryPicked=$('#editCategoryName').val();
      
             var brandPicked=brandCategoryArray[categoryPicked];      
          var arrayLength = brandPicked.length;
        for (var i = 0; i < arrayLength; i++) {
          brandLowercase=brandPicked[i];
          brandUppercase=brandLowercase.charAt(0).toUpperCase() + brandLowercase.substr(1);
            $('#editBrandName').append('<option value='+brandLowercase+'>'+brandUppercase+'</option>');
            //Do something
        }
        $('#editBrandName').append('<option value="other">Other</option>');

        
         
    }else{
      $('#editBrandName').append('<option value="other">Other</option>');
    }
}
setbrands();


$('#editBrandName').val('<?php echo $brand; ?>');
$('#productStatus').val('<?php echo $status; ?>');
        


            $('#editCategoryName').on('change', function(){
          setbrands();
        });

          </script>


<script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
  
  $(document).ready(function(){
  $("#messages").html("");

$("#editVariablesForm").unbind('submit').bind('submit',function(){


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
          ,
    error: function (request, status, error) {
        alert(request.responseText);
    }
        });//ajax
        
      
      
    


      return false;
    });//submit categories form function

});
</script>
