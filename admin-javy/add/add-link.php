<?php include '../header.php'; 
include('../simple_html_dom.php');


	echo '<br>';
	echo '<h2 style="margin-left:30px;">ADD NEW LINK</h2>';
	echo '<form method="GET" action="../submit/submit-link.php" id="submitLinkForm">';

    echo '<div class="row"><div class="col-md-12"><div style="margin-left:20px;">';

	echo '<div class="form-group"><label style="margin-right:20px;">Link:  </label>';
	echo '<input class="form-control" style="display: inline;width:30%;" required name="link" ></input></div>';
	$id=$_GET['id'];

	echo '<input class="form-control" style="display: inline;width:30%;" type="hidden" required name="id" value="'.$id.'"></input></div>';



	echo '<div id="messages"></div>';
	//echo '<div style="margin-top:10px"><label>Status:</label><br/></div>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';



	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 20px;
    cursor: pointer;" type="submit" value="SUBMIT"></form>';

    echo '<h2 style="margin-left:30px;">PREVIOUSLY ADDED LINKS</h2>';

    $query_link='SELECT * FROM products WHERE id='.$id.'';
	$query_run_link=mysqli_query($db_link,$query_link);
	if($row_link=mysqli_fetch_assoc($query_run_link)){
    $main_link=$row_link['link'];
	}

	echo '<h4 style="margin-left:30px;">Current link: '.$main_link.'</h4>';

    	echo '<form method="GET" action="../submit/submit-edit-links.php" id="submitLinkForm">';

    echo '<div class="row"><div class="col-md-12"><div style="margin-left:20px;">';

$query='SELECT * FROM more_links WHERE product_id='.$id.'';
//echo $query;



$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){

			$link=$row['link'];

			$html = file_get_html($link);

			if(!empty($html)){

			//echo $html->find('title',0)->plaintext;

			$value=$html->find('.price',0);

			if(empty($value)){
				$price_from_website='0';
				echo 'No price found on this link-';
			}else{
			if(isset($value->find('bdi',0)->plaintext)){
				$price_from_website = $value->find('bdi',0)->plaintext;
			}else if(isset($value->find('.amount',0)->plaintext)){
				$price_from_website = $value->find('.amount',0)->plaintext;
			}
			else{
				$price_from_website = $value->find('.amount',1)->plaintext;
			}

			}




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


			//echo $product_id."---<a href='".$website_url."' target='_blank'>".$website_url."</a> ---- ".$product_price."---".$int_price;



			if($int_price!=0){
				/* UPDATE PRICES
				$update_prices_query="UPDATE `products` SET price='".$int_price."' WHERE id=".$product_id;
				if(mysqli_query($db_link,$update_prices_query)){
					echo "----UPDATED";
				}

				*/
				//only update if the price is different	
				if($int_price!=$product_price){
					//echo "DIFFERENT";


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

			//echo " ".$profit." ";

					if (isset($_GET['update'])){

						// UPDATE PRICES
						$update=$_GET['update'];
						if($update=='true'){
							$update_prices_query="UPDATE `products` SET price='".$int_price."',profit='".$profit."' WHERE id=".$product_id;
					if(mysqli_query($db_link,$update_prices_query)){
						echo "----UPDATED";
						}
						}


				}

					}
				}

				//echo "</br>";

				}  //empty html




	echo '<div class="form-group" style="margin-bottom:0px;margin-top:0px;padding-bottom:0px;padding-top:0px;"><label style="margin-right:0px;">Link:  </label>';
	echo '<input class="form-control" style="display: inline;width:30%;" required name="link" value="'.$link.'" ></input>';
	echo '<span style="margin-left:20px;margin-right:20px;">KSh. '.number_format($int_price).'</span>';
	
	echo '<a target="_blank" href="../submit/set-as-main-link.php?link='.$link.'&main_link='.$main_link.'&product_id='.$id.'"><button style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;">Set as Main Link</button></a></div>';

}

	echo '<div class="form-group"><label style="margin-right:20px;">Id:  </label>';
	echo '<input class="form-control" required name="product_id" style="display: inline;width:30%;" value="'.$id.'" ></input></div>';





	echo '<div id="messages"></div>';
	//echo '<div style="margin-top:10px"><label>Status:</label><br/></div>';
	//echo '<div><input name="status" value="'.$row['status'].'"></input></div>';



	echo '<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 2px;
    cursor: pointer;" type="submit" value="SUBMIT"></form>';







?>
<?php include '../footer.php'; ?>

 <script src="../jquery/jquery.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
	$("#messages").html("");

$("#submitLinkForm").unbind('submit').bind('submit',function(){


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

							setTimeout(function () {
								//window.location.href = "../edit/edit-product.php?product_id="+response.id;
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