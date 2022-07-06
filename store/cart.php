<?php
session_start();

   if(!isset($_SESSION['customerId'])) {
	//header('location: login.php');		
}else{
	$customerId=$_SESSION['customerId'];
}


?>
<?php include 'header.php';


  ?>
	<!-- //header --> 	
	<!-- sign up-page -->
	<div class="login-page">
		<div class="container">


			<h3 class="w3ls-title w3ls-title1">Shopping Cart</h3> 

			<table class="table">
    <thead>
      <tr>
        <td style="width: 15%;"><strong>Items</strong></td>
        <td style="width: 10%;"><strong>Image</strong></td>
        <td><strong>Quantity</strong></td>
        <td><strong>Price</strong></td>
        <td><strong>Remove</strong></td>
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



        echo '<tr class="success">
        <td style="width:40%">'.$row['name'].'</td>
        <td style="width:10%"><img src="'.$large_image.'" height="200" width="200" data-imagezoom="true" class="img-responsive" alt=""></td>
        <td>


          <div class="center" style="width: 150px; margin: 0px auto;">
    
   
      <div class="input-group">
          <span class="input-group-btn">
              <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="'.$key.'" id="'.$key.'">
                <span class="glyphicon glyphicon-minus"></span>
              </button>
          </span>
          <input type="text" name="'.$key.'" class="form-control input-number" value="'.$value['quantity'].'" min="1" max="100" style="margin-top:12px;">
          <span class="input-group-btn">
              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="'.$key.'" id="'.$key.'">
                  <span class="glyphicon glyphicon-plus"></span>
              </button>
          </span>
      </div>
  <p></p>
</div>





        </td>
        <td><div id="'.$key.'">'.number_format($product_price).'</div></td>'.'<td><a href="remove-item-from-cart.php?id='.$key.'"><button>Remove</button></a></td>';
        /*
        if ($status=="processing") {
           echo '<td><button>Edit Order</button></td>';
        }else{
          echo '<td><button>View Order</button></td>';
        }*/

      echo '</tr>';
    }


}






   if(sizeof($products_array)==0){
   	echo "<tr class='danger'><td colspan=4>You have not added any products yet.<td/><tr/>";
   }else{
    echo "<tr class='danger'><td colspan=2></td><td><a href='checkout.php'><button type='button' class='btn btn-primary btn-lg' style='background-color: #F44336;'>Check Out</button></a><td/><td></td><tr/>";
    
   }


   ?>

    </tbody>
  </table>	

		
		</div>
	</div>
	<!-- //sign up-page --> 
	<?php include 'footer.php'; ?>


  <script type="text/javascript">
    
    //plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    product_id  = $(this).attr('id');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();

            $.ajax({
                type: "GET",
                url: "edit-quantity-on-cart.php" ,
                data: { action: "minus", id : product_id },
                success : function() { 

                }
            });


            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();

            $.ajax({
                type: "GET",
                url: "edit-quantity-on-cart.php" ,
                data: { action: "add" , id : product_id },
                success : function() { 

                }
            });

            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

  </script>

