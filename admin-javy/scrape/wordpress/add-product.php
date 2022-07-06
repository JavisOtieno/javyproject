<?php
include('../simple_html_dom.php');
include '../../header.php'; 



if (isset($_GET['link'])){
$link = $_GET['link'];


	$html = file_get_html($link);

			$website_url=str_replace('https://www.phonestablets.co.ke', ' ', $link);

			//echo $html->find('title',0)->plaintext;
			$value=$html->find('.price',0);


				
			
			if(isset($value->find('.amount',0)->plaintext)){
				$price_from_website = $value->find('.amount',0)->plaintext;
				//echo $price_from_website."--";
			}else{
				$price_from_website = $value->find('.amount',1)->plaintext;
				//echo $price_from_website."--";
			}

			if(strpos($link, 'shopnbuy')!==false){
				$price_from_website = $html->find('meta[property="product:price:amount"]',0)->attr['content'];
				echo "found shopn buy".$price_from_website;
			}

			//get javytech id
			if(strpos($link,'javytech')){
			$javytech_id=str_replace('https://www.javytech.co.ke?p=', ' ', $link);
		}else{
			$javytech_id=0;
		}

			



			if(isset($html->find('.description',0)->plaintext)){
				$specs_from_website = $html->find('.description',0);
			}elseif (isset($html->find('.woocommerce-product-details__short-description',0)->plaintext)) {
				$specs_from_website = $html->find('.woocommerce-product-details__short-description',0);
			}
			elseif (isset($html->find('.product-short-description',0)->plaintext)) {
				$specs_from_website = $html->find('.product-short-description',0);
			}elseif(isset($html->find('div[itemprop="description"]',0)->plaintext)){
				$specs_from_website = $html->find('div[itemprop="description"]',0);
			}elseif(isset($html->find('div[id="tab-description"]',0)->plaintext)){
				$specs_from_website = $html->find('div[id="tab-description"]',0);
			}else{
				$specs_from_website ='';
			}
			if($specs_from_website==''){
				$finalspecs=$specs_from_website;
			}else{
				$finalspecs=trim($specs_from_website->plaintext);
			}

			$image_from_website = $html->find('img',2)->attr['src'];
			echo "image".$image_from_website;

			$heading_from_website = $html->find('.product_title',0)->plaintext;
			$heading_from_website = trim($heading_from_website);
			$heading_from_website = str_replace('"', '', $heading_from_website);
			

			
			

			/*$specs_from_website=str_replace('</ul>','' , $specs_from_website);
			$specs_from_website=str_replace('<li>','' , $specs_from_website);
			$specs_from_website=str_replace('<ul>', '', $specs_from_website);
			
			$specs_from_website=explode("</li>",$specs_from_website);
			$finalspecs="";

			foreach ($specs_from_website as $value){ 
				$finalspecs.=trim($value)."\r\n";
			} 
			$finalspecs=trim($finalspecs);
			*/
			
			

			$strip_ksh = str_replace('KShs', '', $price_from_website);
			$strip_ksh = str_replace('KSh.', '', $strip_ksh);
			$strip_ksh = str_replace('KSh', '', $strip_ksh);
			$strip_ksh = str_replace('KES', '', $strip_ksh);
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
		



}

?>

	
	<form id="submitProductForm" action="../../submit/submit-product.php" method="GET">
	<div class="row"><div class="col-md-6"><div style="margin-left:20px;"><div class="form-group">
	<label>Product Name:</label><br/>
	<input type="text" class="form-control" name="productName" id="productName" value='<?php echo $heading_from_website; ?>' />
	</div>
	<div class="form-group">
	<label>Product Price:</label><br/>
	<input type="text" class="form-control" name="productPrice" id="productPrice" value="<?php echo $int_price; ?>"/>
	</div>
	<div class="form-group">
	<label>Product Cost:</label>
	<input type="text" class="form-control" name="productCost"/>
	</div>
	<div class="form-group">
	<label>Product Highlights:</label><br/>
	<?php echo $specs_from_website; ?>
	<pre><textarea class="form-control" rows="6" name="productHighlights" ><?php echo $finalspecs; ?></textarea></pre>
	</div>
	<div class="form-group">
	<a href='<?php echo $link; ?>' target="_blank"><label>Product Link:</label></a>
	<input type="text" class="form-control" name="productLink" value="<?php echo $link; ?>"/>
	</div>

</div></div>

	<div class="col-md-6"><div style="margin-left:20px;"><div class="form-group">
	<label>Product Profit:</label><br/>
	<input type="text" class="form-control" name="productProfit"  id="productProfit" value="<?php echo $profit; ?>"/></div>
	<div class="form-group">
	<label>Product Category:</label><br/>
	<select class="form-control" id="categoryName" name="categoryName" >
	<option value="" >~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT categories_id, categories_name,categories_slug, categories_status FROM categories WHERE categories_status = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[2]."'>".$row[1]."</option>";
								} // while

								echo "<option value='other'>Other</option>";
								
				      	?>
				      	</select>
	</div>
	<div class="form-group">
	<label>Product Brand:</label><br/>
	<select class="form-control" id="brandName" name="brandName" >
				      
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT brand_id, brand_name, brand_status,brand_slug FROM brands WHERE brand_status = 1 AND brand_category = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[3]."'>".$row[1]."</option>";
								} // while
								
								
				      	?>
				      </select></div>


				      	        <script type="text/javascript">

	        	 

	        	$('#categoryName').on('change', function(){
  				$('#categoryName').val();
  				$('#brandName').html('');


    
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



    if($('#categoryName').val()){
 
        $('#brandName').append('<option value="">~~SELECT~~</option>');
    	var categoryPicked=$('#categoryName').val();
    	
	        	 var brandPicked=brandCategoryArray[categoryPicked];     	
			    var arrayLength = brandPicked.length;
				for (var i = 0; i < arrayLength; i++) {
					brandLowercase=brandPicked[i];
					brandUppercase=brandLowercase.charAt(0).toUpperCase() + brandLowercase.substr(1);
				    $('#brandName').append('<option value='+brandLowercase+'>'+brandUppercase+'</option>');
				    //Do something
				}
				$('#brandName').append('<option value="other">Other</option>');
         
    }else{
    	$('#brandName').append('<option value="other">Other</option>');
    }
});

	        </script>
	
	
	<div class="form-group"><label>Product Status:</label><br/>
	<select name="productStatus" class="form-control">
		<option value="1" >Available</option>
		<option value="0" >NOT AVAILABLE</option>
		<option value="2" >Requested</option>
	</select></div>
	<div class="form-group"><label>Approval:</label><br/>
	<select name="approval" class="form-control">
		<option value="2" >Approved JAVY</option>
		<option value="1" >Approved Main</option>
		<option value="0" >NOT APPROVED</option>
	</select></div>
	<div class="form-group">
	<label>Product Featured:</label>
	<select name="productFeatured" class="form-control">
		<option value="0" >not featured</option>
		<option value="1" >FEATURED</option>
	</select></div>
	<div>
	<label>Product Image:</label>
    <img style="width: 150px;height: 150px;" src="<?php echo $image_from_website; ?>">
  </div>
<div class="form-group">
	<label>Javytech ID:</label><br/>
	<input type="text" class="form-control" name="javytech_id"  id="javytech_id" value="<?php echo $javytech_id; ?>"/></div>
</div></div></div>
<div id="messages"></div>
	<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    margin-left:20px;
    cursor: pointer;" type="submit" value="SUBMIT PRODUCT">

	</form>

	<?php 
	

			if(isset($html->find('.product-images-wrapper',0)->plaintext)){
				$image_wrapper = $html->find('.product-images-wrapper',0);
				echo "<img src='".$image_wrapper->find('img',0)->attr['src']."'/>";
			}elseif (isset($html->find('.product-images',0)->plaintext)) {
				$image_wrapper = $html->find('.product-images',0);
				echo "<img src='".$image_wrapper->find('img',0)->attr['src']."'/>";
			}

			//if we need to see all the images uncomment the echo 
			//foreach ($image_wrapper->find('img') as $key ) {
				# code...
				//echo "<img src='".$key->attr['src']."'/>";
			//}
			
			
			$image_from_website = $html->find('meta[property="og:image"] ',0)->attr['content'];
			echo "<img src='".$image_from_website."'/>";

?>
	
<?php include '../../footer.php'; ?>

<script src="../../jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	$("#messages").html("");

$("#submitProductForm").unbind('submit').bind('submit',function(){


			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/

			var productName=$("#productName").val();
			var productPrice=$("#productPrice").val();
			var productProfit=$("#productProfit").val();

			

			if(productName&&productPrice&&productProfit){

				
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

							setTimeout(function () {
								window.location.href = "../../edit/edit-product.php?product_id="+response.id;
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
				
			
			}//if
		


			return false;
		});//submit categories form function

});
</script>

