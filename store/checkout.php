<?php
include 'connect.inc.php';
session_start();

   if(isset($_SESSION['customerId'])) {

	$customer_id=$_SESSION['customerId'];
	

	$query="SELECT * FROM `customers` WHERE `id`= '$customer_id'";
	

		if($query_run=mysqli_query($db_link,$query)){
			while($row=mysqli_fetch_assoc($query_run)){

				$customer_name=$row['name'];
				
				$customer_phone=$row['phone'];
				
				$customer_email=$row['email'];
				
				$customer_delivery=$row['delivery_details'];



			}
		}

}


?>
<?php include 'header.php';

?>


<?php
  $sql="SELECT * FROM customers WHERE id='$customerId'";
   $result=$connect->query($sql);

   $count=0;

   while($row=mysqli_fetch_assoc($result)){
    $customer_name=$row['name'];
    $customer_email=$row['email'];
    $customer_phone=$row['phone'];
    $customer_delivery=$row['deliverydetails'];

  }


?>
	<!-- //header --> 	
	<!-- sign up-page -->
	<div class="login-page">
		<div class="container"> 



			<h3 class="w3ls-title w3ls-title1">Check Out</h3> 

      <div id="login-messages"><?php echo $message; ?></div> 
      <div class="login-body">
        <form action="submit-order.php?cart=true" method="post" id='submitOrderForm'>
          <div><div style="text-align: left;">Name:</div> <input style="width: 100%;" type="text" class="user" id="name" name="name" placeholder="Enter your Name" required=""  value="<?php echo $customer_name; ?>"></div>
           <div><div style="text-align: left;">Phone:</div> <input type="text" style="width: 100%;" class="user" id="phone" name="phone_number" placeholder="Enter your phone number" required=""  value="<?php echo $customer_phone; ?>"></div>
           <div><div style="text-align: left;">Email:</div> <input style="width: 100%;" type="text" class="user" id="email"  name="email" placeholder="Enter your email" required="" value="<?php echo $customer_email; ?>"></div>
           <div><div style="text-align: left;">Delivery Details:</div> <input style="width: 100%;" type="text" class="user" id="address" name="delivery_details" placeholder="Enter your delivery details (Location details)"  required="" value="<?php echo $customer_delivery; ?>"></div>
           <div><div style="text-align: left;">Order Summary:</div> </div>

           			<table class="table">
    <thead>
      <tr>
        <td style="width: 15%;"><strong>Items</strong></td>
        <td style="width: 10%;"><strong>Image</strong></td>
        <td><strong>Quantity</strong></td>
        <td><strong>Subtotal</strong></td>
      </tr>
    </thead>
    <tbody>

           <?php 
           if(isset($_SESSION['cart_products'])){
$products_array=$_SESSION['cart_products'];
}else
{
  $products_array=[];
}

//print_r($products_array);

foreach ($products_array as $key => $value) {
  # code...



     $sql="SELECT * FROM products WHERE id='".$key."'";
   $result=$connect->query($sql);

    if($row=mysqli_fetch_assoc($result)){


        if($row['image']==''){
          $large_image='https://promote.javy.co.ke/assests/images/product-images/picture-coming-soon.jpg';
        }else{
          $large_image=str_replace("..", "https://promote.javy.co.ke", $row['image']);
        }

          $product_price=$value['price'];
          $quantity=$value['quantity'];

        echo '<tr class="success">
        <td style="width:40%">'.$row['name'].'</td>
        <td style="width:10%"><img src="'.$large_image.'" height="200" width="200" data-imagezoom="true" class="img-responsive" alt=""></td>
        <td>'.$quantity.'</td>
        <td>'.number_format($quantity*$product_price).'</td>';
        /*
        if ($status=="processing") {
           echo '<td><button>Edit Order</button></td>';
        }else{
          echo '<td><button>View Order</button></td>';
        }*/

      echo '</tr>';
      $final_total=$final_total+$quantity*$product_price;
    }


}

        echo '<tr class="danger">
        <td style="width:40%">TOTAL</td>
        <td style="width:10%"></td>
        <td></td>
        <td>'.number_format($final_total).'</td>';
        /*
        if ($status=="processing") {
           echo '<td><button>Edit Order</button></td>';
        }else{
          echo '<td><button>View Order</button></td>';
        }*/

      echo '</tr>';
           ?>

               </tbody>
  </table>	
        

           
          <input type="submit" value="Place Order">
          <!--
          <div class="forgot-grid">
            <label class="checkbox"><input type="checkbox" name="remember" value="1"><i></i>Remember me</label>
            <div class="forgot">
              <a href="#">Forgot Password?</a>
            </div>-->
            <div class="clearfix"> </div>
          </div>
        </form>
      </div> 
		
		</div>
	</div>
	<!-- //sign up-page --> 
	<?php include 'footer.php'; ?>

  <script type="text/javascript">
    setInterval(function(){
      var link = document.getElementById('login-messages');
      $(link).hide()
  },3000);

    $("#submitOrderForm").unbind('submit').bind('submit',function(){

	$(this).find("input[type='submit']").attr('disabled', 'disabled').val('Submitting'); 
			/*
			$(".text-danger").remove();
		//remove the form error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		*/


			var name=$("#name").val();
			var email=$("#email").val();
			var phone_number=$("#phone").val();
			var delivery_details=$('#address').val();

			if(name&&email&&phone_number&&delivery_details){
				
				var form =$(this);
				$.ajax({
					url: form.attr('action'),
					type: form.attr('method'),
					data: form.serialize(),
					dataType: 'json',
					success:function(response){

						form.find("input[type='submit']").removeAttr('disabled').val('Submit'); 
					
						if(response.success == true){

						
						console.log(response);
							//reload the manage member datatable
							//manageCategoriesTable.ajax.reload(null,false);

							if(response.customer_password==true){
							window.location.href = "login.php?source=order&message="+response.messages;
						}else{
							window.location.href = "orders.php";
						}

							//reset the form text
							$("#submitOrderForm")[0].reset();
						

							$("#add-order-messages").html('<div class="alert  alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');


							//remove the messages after 10 seconds
							

						}else{

							$("#submitOrderForm")[0].reset();
						

							$("#add-order-messages").html('<div class="alert  alert-dismissible" role="alert">'+
  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+response.messages+
'</div>');

						}///if */
					} //success
				});//ajax
				
			
			}//if



			return false;
		});//submit categories form function


  </script>