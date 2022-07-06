<?php include '../header.php';
include('../simple_html_dom.php'); ?>

<?php
if(isset($_GET['id'])){
	$product_id=$_GET['id'];
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




$query="SELECT * FROM products WHERE status=1 AND approval=2 AND link <> '' AND id>'$product_id' ORDER BY id ASC";

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
    cursor: pointer;">Next</button></a>';

}

  echo '<a href=edit-product.php?product_id='.$product_id.' target="_blank"><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;">Edit Product</button></a>';

echo '<a href=https://javis.av.ke/product.php?id='.$product_id.' target="_blank"><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;">View Product</button></a>';

    echo '<a href='.$row['link'].' target="_blank"><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;">Visit Link</button></a>';


$query='SELECT * FROM products WHERE id='.$product_id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	$highlights=str_replace('<br />', '', $row['highlights']);

  $description=$row['description'];

  $link=$row['link'];

    


    $query_2='SELECT * FROM variables WHERE product_id='.$product_id.'';
    $query_run_2=mysqli_query($db_link,$query_2);

    $number_of_variables=mysqli_num_rows($query_run_2);

    echo "<br/><br/>";

    if($number_of_variables==0){
      echo "NO VARIABLES FOUND";
    }else{
      echo "VARIABLES FOUND ON DATABASE<br>";
    }
    while($row_variable=mysqli_fetch_assoc($query_run_2)){
      echo $row_variable['variable'].' -- '.$row_variable['price'].'<br/>';
      $variants_array_string=$variants_array_string."-'".$row_variable['variable']."'@".$row_variable['price'];
    }

    echo "<br/><br/>";

//consider changing true to number of variables is 0;
    if(true){
    if((strpos($link, 'phonestablets') !== false) ){

/*
No longer works
      $html = file_get_html($link);
    $variants_from_website = $html->find('input[name="products_variant"]',0)->attr['value'];

    echo "<br><br>Variants found : ".$variants_from_website."<br><br>";

    

    $variants_from_website = str_replace(',0', '0', $variants_from_website);

    $variants_strings=explode(",", $variants_from_website);

    $variables_size=sizeof($variants_strings);
    $variable_count=0;

    while($variable_count<$variables_size){
      $variant_variable=$variants_strings[$variable_count+1];
      $variant_price=$variants_strings[$variable_count+2];
      $variable_count=$variable_count+4;

      $variant_variable=str_replace('"', "", $variant_variable);
      $variant_price=str_replace('"', "", $variant_price);

      $variants_array[$variant_variable]=$variant_price;

      $variants_array_string=$variants_array_string.'-'.$variant_variable.'@'.$variant_price;

      echo $variant_variable.' @ '.$variant_price.'<br>';

    }
    echo '<br><br>';

*/

  }

  else if (strpos($link, 'kenyatronics') !== false){

    $html = file_get_html($link);

    $description_from_website = $html->find('div[class="p_desc"]',0);

    foreach($description_from_website ->find('pre') as $item) {
    $item->outertext = '';
    }
    $description_from_website->save();

if((strpos($description_from_website, 'Kenyatronics') !== false) || (strpos($description_from_website, 'KENYATRONICS') !== false) || (strpos($description_from_website, 'kenyatronics') !== false) ){

      $description_from_website= str_replace('https://www.kenyatronics.com', '' , $description_from_website);

    $description_from_website= str_replace('KENYATRONICS', 'our online shop' , $description_from_website);
    $description_from_website= str_replace('Kenyatronics', 'our online shop' , $description_from_website);
    $description_from_website= str_replace('kenyatronics', 'our online shop' , $description_from_website);

  }else{
        $description_from_website='Get the '.$row['name'].' at the best price from our online shop in Nairobi, Kenya.<br><br>'.$description_from_website;

  }




    $description_from_website= str_replace('https://254mobiles.com/', '' , $description_from_website);
    $description_from_website= str_replace('https://www.bnt.co.ke', '' , $description_from_website);

    $description_from_website= str_replace('Location:Rehema house 1st flr 01,Standard street,', '' , $description_from_website);
    $description_from_website= str_replace('Location:Rehema house 1st flr 03,Standard street,', '', $description_from_website);
    $description_from_website= str_replace('(Behind Sarova Stanley)', '' , $description_from_website);
    $description_from_website= str_replace('For Inquiries. Call/Whatsapp:', '' , $description_from_website);
    $description_from_website= str_replace('+254725231726', '' , $description_from_website);
    

    



    //$description_from_website=str_replace('&nbsp;', ' ', $description_from_website);
    //remove images -- "" in place of required image
     $description_from_website = preg_replace("/<img[^>]+\>/i", "", $description_from_website);
    //remove images

     if (strpos($description_from_website, 'kenyatronics') === false && strpos($description_from_website, 'Rehema') === false && strpos($description_from_website, 'Sarova') === false) {
      echo '<br>CLEAR<br><br>';
     }else{
      echo 'WARNING <br>WARNING <br>WARNING !!!<br><br>';
     }

    echo 'NOT YET UPDATED: <br/>'.$description_from_website->plaintext;

    $description=$description_from_website;

  }else{


            $html = file_get_html($link);

    if (strpos($html->plaintext, 'woodmart-tab-wrapper')) {
      echo 'tab';
      $description_from_website = $html->find('div[class="woodmart-tab-wrapper"]',0);
     }else if (strpos($html->plaintext, 'rey-wcPanel-inner')){
      echo 'rey';
      $description_from_website = $html->find('div[class="rey-wcPanel-inner"]',0);
     }else if (strpos($html->plaintext, 'electro-description')){
      echo 'electro';
      $description_from_website = $html->find('div[class="electro-description"]',0);
     }else if (strpos($html->plaintext, 'tabpanel')){
      echo 'tabpanel';
      $description_from_website = $html->find('div[role="tabpanel"]',0);
     }
     else{
  
      $description_from_website = $html->find('div[id="tab-description"]',0);
     }

            
    
    //print_r($description_from_website);
     if(!empty($description_from_website)){
    foreach($description_from_website ->find('div[class="product_meta"]') as $item) {
    $item->outertext = '';
    }
    $description_from_website->save();

    foreach($description_from_website ->find('div[style="mso-element:para-border-div;border:solid #CCCCCC 1.0pt;mso-border-alt:
solid #CCCCCC .75pt;padding:7.0pt 7.0pt 7.0pt 7.0pt;background:whitesmoke"]') as $item) {
    $item->outertext = '';
    }
    $description_from_website->save();

  foreach($description_from_website ->find('div[style="mso-element:para-border-div;border:solid #CCCCCC 1.0pt;mso-border-alt:  solid #CCCCCC .75pt;padding:7.0pt 7.0pt 7.0pt 7.0pt;background:whitesmoke"]') as $item) {
    $item->outertext = '';
    }
    $description_from_website->save();

    

    
    }

   // echo $description_from_website->plaintext;
    if((strpos($description_from_website, 'Starmac Technologies') !== false) || (strpos($description_from_website, 'Cellular Kenya') !== false) || (strpos($description_from_website, 'CELLULAR KENYA') !== false)  ){

    $description_from_website= str_replace('Starmac Technologies', 'our online shop' , $description_from_website);
    $description_from_website= str_replace('Cellular Kenya', 'our online shop' , $description_from_website);
    $description_from_website= str_replace('CELLULAR KENYA', 'our online shop' , $description_from_website);

  }else{
        $description_from_website='Get the '.$row['name'].' at the best price from our online shop in Nairobi, Kenya.<br><br>'.$description_from_website;

  }

    //$description_from_website= str_replace(' Nairobi ', ' ', $description_from_website); 
    //$description_from_website=str_replace('&nbsp;', ' ', $description_from_website);
    //remove images -- "" in place of required image
     $description_from_website = preg_replace("/<img[^>]+\>/i", "", $description_from_website);
    //remove images

    $description_from_website= str_replace('https://www.starmac.co.ke', '/' , $description_from_website);
    $description_from_website= str_replace('https://cellularkenya.co.ke', '/' , $description_from_website);

    //$description_from_website=str_replace('&nbsp;', ' ', $description_from_website);
    //remove images -- "" in place of required image
     $description_from_website = preg_replace("/<img[^>]+\>/i", "", $description_from_website);
    //remove images

     if (strpos($description_from_website, 'starmac') === false && strpos($description_from_website, 'cellular') === false) {
      echo '<br>CLEAR<br><br>';
     }else{
      echo 'WARNING <br>WARNING <br>WARNING !!!<br><br>';
     }

    echo 'NOT YET UPDATED: <br/>'.$description_from_website->plaintext;

    $description=$description_from_website;


  }

    }


    //$description=htmlentities($description);

	echo '<br>';
	echo '<form method="POST" action="../submit/submit-product-variables.php?edit=true" id="editVariablesForm">';
	echo '<div class="row"><div class="col-md-10"><div style="margin-left:20px;"><div class="form-group"><label>Product Variables:</label><br/>';
    echo '<input class="form-control" name="variables" value="'.$variants_array_string.'" /></div>';
	echo '<div class="col-md-10"><div style="margin-left:20px;"><div class="form-group"><br/>';


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



	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="UPDATE"></form>';




  echo '<form method="POST" action="../submit/submit-product-variables.php" id="addVariablesForm">';
  echo '<div class="row"><div class="col-md-10"><div style="margin-left:20px;"><div class="form-group"><label>Product Variables:</label><br/>';
    echo '<input class="form-control" name="variables" /></div>';
  echo '<div class="col-md-10"><div style="margin-left:20px;"><div class="form-group"><br/>';


  echo '<input type="hidden" name="id" value="'.$product_id.'"></input></div></div>';

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
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="UPDATE"></form>';

      








}





?>


<?php include '../footer.php'; ?>



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
