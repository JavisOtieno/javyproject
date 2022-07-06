<?php include '../header.php';
include('../simple_html_dom.php'); ?>

<?php
if(isset($_GET['product_id'])){
	$product_id=$_GET['product_id'];
}
if(isset($_GET['coming_soon'])){
  $coming_soon=$_GET['coming_soon'];
}

if($userId == 1){
$hidden="";
$readonly="";
}else{
$hidden="hidden";
$readonly="readonly";
}

$query='SELECT * FROM products WHERE id='.$product_id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	$highlights=str_replace('<br />', '', $row['highlights']);

  $link=$row['link'];
  $product_name=$row['name'];
  $image=str_replace( '..', 'https://promote.javy.co.ke' , $row['image']);

  if($coming_soon==true){

      $html = file_get_html($link);

      $website_url=str_replace('https://www.phonestablets.co.ke', ' ', $link);

      //echo $html->find('title',0)->plaintext;

      $price_from_website = $html->find('div[class="disp-table"]',0)->plaintext;


      $strip_ksh = str_replace('Ksh.', '', $price_from_website);
      $strip_comma = str_replace(',', '', $strip_ksh);
      $strip_nbsp = str_replace('&nbsp;', '', $strip_comma);
      $strip_space = str_replace(' ', '', $strip_nbsp);
      

      $strip_outofstock = str_replace('OutOfStock', '', $strip_space);
      $trim_outofstock = trim($strip_outofstock);

      $int_price = (int)$trim_outofstock;


      //profit calculated
      $calculated_profit = floor($int_price*0.05);
      $profit_over_hundred=($int_price*0.05)%100;

      if($profit_over_hundred>=50){
        $profit=$calculated_profit-$profit_over_hundred+100;
      }else{
        $profit=$calculated_profit-$profit_over_hundred;
      }

      if($profit==0){
        $profit=100;
      }
      $product_price=$int_price;
      $product_profit=$profit;
  }else{
    $product_price=$row['price'];
    $product_profit=$row['profit'];
  }


	echo '<br>';
	echo '<form method="GET" action="../submit/submit-edit-product.php" id="editProductForm">';
	echo '<div class="row"><div class="col-md-4"><div style="margin-left:20px;"><div class="form-group"><label>Product Name:</label><br/>';
	echo '<input class="form-control" name="name" value="'.$product_name.'"></input></div>';
	echo '<div class="form-group"><label>Product Price:</label><br/>';
	echo '<input class="form-control" name="price" value="'.$product_price.'"></input></div>';
  echo '<div class="form-group">';
  if($userId == 1){echo '<label>Product Profit:</label><br/>';}
  echo '<input class="form-control" name="profit" value="'.$product_profit.'" '.$hidden.'></input></div>';
  echo '<div class="form-group">';
  if($userId == 1){echo '<label>Product Cost:</label><br/>';}
  echo '<input class="form-control" name="cost" value="'.$row['cost'].'" '.$hidden.'></input></div>';
   echo '<div class="form-group"><label>Image:</label><br/>';
  echo '<input class="form-control" name="product_image" value="'.str_replace( 'https://promote.javy.co.ke' ,'..', $image).'" ></input></div>';
  echo '<div class="form-group"><label><a target="_blank" href="'.$row['link'].'">Product Link:</a></label><br/>';
  echo '<input class="form-control" name="link" value="'.$row['link'].'"></input></div></div></div>';
	echo '<div class="col-md-4"><div style="margin-left:20px;"><div class="form-group"><label>Product Highlights:</label><br/>';
	echo '<textarea class="form-control" name="highlights" style="overflow:auto;width:350px;height:200px;" cols="5" rows="5">'.$highlights.'</textarea></div>';

  $store_id=$row['store_id'];
  $query_store='SELECT * FROM users WHERE user_id='.$store_id.'';
$query_run_store=mysqli_query($db_link,$query_store);

if($row_store=mysqli_fetch_assoc($query_run_store)){
  $store_name=$row_store['storename'];
  $store_phone=$row_store['phone'];

  if($userId == 1){echo 'Promoter: '.$store_name.' Phone: '.$store_phone.'</br>';}

      echo '<div class="form-group">';
      if($userId == 1){echo '<label>Store id:</label><br/>';}
      
  echo '<input class="form-control" name="store_id" value="'.$store_id.'" readonly '.$hidden.'></input>';
      
  echo '</div>';

}else{
  if($userId == 1){
  echo 'Promoter ID not found</br>';
}
}



  $supplier_id=$row['supplier_id'];


  $query_supplier='SELECT * FROM suppliers WHERE id='.$supplier_id.'';
$query_run_supplier=mysqli_query($db_link,$query_supplier);
if($row_supplier=mysqli_fetch_assoc($query_run_supplier)){
  $supplier_name=$row_supplier['name'];
  $supplier_phone=$row_supplier['phone'];

    echo '<div class="form-group"><label>Supplier id:</label><br/>';
  echo '<input class="form-control" name="supplier_id" value="'.$supplier_id.'" readonly></input>';

if($userId == 1){
echo 'Supplier:'.$supplier_name.' Phone:'.$supplier_phone;
}

  echo '</div>';

}else{
  echo 'Supplier ID not found</br>';
}
//only display if main user is Javis

    echo '<div class="form-group"><label>Javytech id:</label><br/>';
  echo '<input class="form-control" name="javytech_id" value="'.$row['javytech_id'].'" ></input></div>';

      echo '<div class="form-group"><label>Description:</label><br/>';
  echo '<input class="form-control" disabled name="description" value="'.htmlspecialchars($row['description']).'" ></input></div>';







	echo '<input type="hidden" name="id" value="'.$product_id.'"></input></div></div>';


  $category=$row["category"];
  $brand=$row["brand"];
  $status=$row['status'];
  $approval=$row['approval'];
  $featured=$row['featured'];
  $variable=$row['variable'];
  $delivery=$row['delivery'];
  
 

  ?>


          <div class="col-md-4"><div style="margin-left:20px;"><div class="form-group">
            <label for="editCategoryName">Category : </label>
            
            <select type="text" class="form-control" id="editCategoryName" placeholder="Product Name" name="editCategoryName" >
                <option value="">~~SELECT~~</option>
                <?php 
                $sql = "SELECT categories_id, categories_name,categories_slug, categories_status FROM categories WHERE categories_status = 1";
                $result = $connect->query($sql);

                while($row = $result->fetch_array()) {
                  echo "<option value='".$row[2]."'>".$row[1]."</option>";
                } // while

                //echo "<option value='other'>Other</option>";
                
                ?>
              </select>
            
          </div> <!-- /form-group-->  

          




          <div class="form-group">
            <label for="editBrandName">Brand Name: </label>
          
              <select class="form-control" id="editBrandName" name="editBrandName">
                /*
                <option value="">~~SELECT~~</option>
                <?php 
                $sql = "SELECT brand_id, brand_name, brand_status,brand_slug FROM brands WHERE brand_status = 1 AND brand_category = 1";
                $result = $connect->query($sql);

                while($row = $result->fetch_array()) {
                  echo "<option value='".$row[3]."'>".$row[1]."</option>";
                } // while
                
               ?>
              </select>
        
          </div> <!-- /form-group-->

          <div style="margin-top:10px"><label>Product Status:</label><br/></div>
  <div><select name="productStatus">
    <option value="1"  <?php if($status==1||$coming_soon==true){ echo 'selected';} ?> >Available </option>
    <option value="0" <?php if($status==0&&$coming_soon!=true){ echo 'selected';} ?> >NOT AVAILABLE</option>
    <option value="2" <?php if($status==2){ echo 'selected';} ?> >Removed</option>
  </select></div>

  <div style="margin-top:10px"><label>Approval:</label><br/></div>
  <div><select name="approval">
    <option value="1"  <?php if($approval==1){ echo 'selected';} ?> >Approved on Main </option>
    <option value="0" <?php if($approval==0){ echo 'selected';} ?> >NOT APPROVED</option>
    <option value="2" <?php if($approval==2){ echo 'selected';} ?> >Approved on Javy</option>
  </select></div>


<?php


  
    echo '<!-- Rounded switch --><div style="margin-top:10px"><label>Featured:</label><br/>
<label class="switch">
  <input type="checkbox" name="featured" value="set_featured"';

  if($featured==1){
    echo 'checked="checked"';
  }
  

  echo '>
  <span class="slider round"></span>
</label></div>';

    echo '<!-- Rounded switch --><div style="margin-top:10px"><label>Variable:</label><br/>
<label class="switch">
  <input type="checkbox" name="variable" value="set_variable"';

  if($variable==1){
    echo 'checked="checked"';
  }

    echo '>
  <span class="slider round"></span>
</label></div>';

      echo '<!-- Rounded switch --><div style="margin-top:10px"><label>Pay Before Delivery:</label><br/>
<label class="switch">
  <input type="checkbox" name="delivery" value="set_delivery"';

  if($delivery==1){
    echo 'checked="checked"';
  }
  

  echo '>
  <span class="slider round"></span>
</label></div>';



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
  echo '<a href="https://javis.av.ke/product.php?id='.$product_id.'" target="_blank"><button style="background-color: #2196F3;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    margin-left:20px;
    cursor: pointer;">View product</button></a>';
      echo '<a href="../add/add-link.php?id='.$product_id.'" target="_blank"><button style="background-color: #4F3674;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Links</button></a>';


          echo '<a href="../edit/edit-description.php?id='.$product_id.'" ><button style="background-color: #FFD45C;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Edit Description</button></a>';


    if($variable==1){
  echo '<a href="../edit/edit-variables.php?id='.$product_id.'" target="_blank"><button style="background-color: #778CB3;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Edit Variables</button></a>';
    }

    if($userId == 1){
    echo '<a href="../delete/delete-product.php?id='.$product_id.'" ><button style="background-color: #FF0000;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display:
     inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;">Delete product</button></a>';
  }


    echo  '<div>
    <img style="width: 150px;height: 150px;" src="'.$image.'">
  </div>
   
<form action="../submit/uploadImageFile.php?id='.$product_id.'&type=product" method="post" enctype="multipart/form-data"  id="uploadImageForm">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
    ';
    if(empty($image)&&!empty($link)){
    if((strpos($link, 'phonestablets') !== false) ||  (strpos($link, 'kenyatronics') !== false)){

    $html = file_get_html($link);
    $image_from_website = $html->find('meta[property="og:image"] ',0)->attr['content'];

    if(empty($image_from_website)){
      $image_from_website = $html->find('img[class="wp-post-image"]',0)->attr['src'];
    }
      
    $image_name_array=explode('.', $image_from_website);
    $image_extension=strtolower($image_name_array[sizeof($image_name_array)-1]);

    if (strpos($link, 'kenyatronics') !== false){
      $image_extension='jpg';
    }

    $product_name_lower=strtolower($product_name);
    $product_name_underscore=str_replace(' ', '_', $product_name_lower);
    $product_name_underscore=str_replace('/', '_', $product_name_underscore);
    $image_name=$product_id.'_'.$product_name_underscore.'.'.$image_extension;

    echo "image: ".$image_name;
    echo "<br/> image extension : ".print_r( $image_name_array);

    echo "<a href='../submit/copyImage.php?name=".$image_name."&id=".$product_id."&link=".$image_from_website."'><button>Set Image</button></a>";

    echo '<img style="width: 150px;height: 150px;" src="'.$image_from_website.'">';

  }

  else{
    $html = file_get_html($link);
          if(isset($html->find('.product-images-wrapper',0)->plaintext)){
        $image_wrapper = $html->find('.product-images-wrapper',0);
      }elseif (isset($html->find('.product-images',0)->plaintext)) {
        $image_wrapper = $html->find('.product-images',0);
      }

    

      //if we need to see all the images uncomment the echo 
      //foreach ($image_wrapper->find('img') as $key ) {
        # code...
        //echo "<img src='".$key->attr['src']."'/>";
      //}

      //$image_from_website=$image_wrapper->find('img',0)->attr['src'];
      $image_from_website = $html->find('meta[property="og:image"] ',0)->attr['content'];

      if(empty($image_from_website)){
        $image_from_website = $html->find('img',2)->attr['src'];
      }

      if( strpos($link, 'ballytech') !== false ){


      if(isset($html->find('.product-images-wrapper',0)->plaintext)){
        $image_wrapper = $html->find('.product-images-wrapper',0);
        $image_from_website=$image_wrapper->find('img',0)->attr['src'];
      }
      elseif (isset($html->find('.product-images',0)->plaintext)) {
        $image_wrapper = $html->find('.product-images',0);
        $image_from_website=$image_wrapper->find('img',0)->attr['src'];
      }

      }

      echo "This is the image".$image_from_website->plaintext;

    $image_name_array=explode('.', $image_from_website);
    $image_extension=strtolower($image_name_array[sizeof($image_name_array)-1]);

    $product_name_lower=strtolower($product_name);
    $product_name_underscore=str_replace(' ', '_', $product_name_lower);
    $image_name=$product_id.'_'.$product_name_underscore.'.'.$image_extension;

      echo "<img src='".$image_from_website."'/>";
      echo "<a href='../submit/copyImage.php?name=".$image_name."&id=".$product_id."&link=".$image_from_website."'><button>Set Image</button></a>";
  }

    }








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


  $("#editProductForm").unbind('submit').bind('submit',function(){


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
