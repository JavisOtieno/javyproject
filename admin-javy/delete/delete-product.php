<?php include '../header.php'; 


if(isset($_GET['id'])){
	$product_id=$_GET['id'];
}

$query='SELECT * FROM products WHERE id='.$product_id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	//$highlights=str_replace('<br />', '', $row['highlights']);

	echo "<h2>Are you sure you want to delete this?</h2>";


	echo '<br>';
	
	echo '<label>Product Name:</label><br/>';
	echo '<div><strong>'.$row['name'].'</strong></div>';
	echo '<div style="margin-top:10px"><label>Product Price:</label><br/>';
	echo '<div><strong>'.$row['price'].'</strong></div>';
	echo '<div style="margin-top:10px"><label>Product Highlights:</label><br/>';
	echo '<div><strong>'.$row['highlights'].'</strong></div>';

	echo '<div id="messages"></div>';

    echo '<button style="background-color: #FF0000;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;" onclick="deleteProduct('.$product_id.')">Delete product</button>';


}

include '../footer.php'; ?>


<script type="text/javascript">
	function deleteProduct(id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
   //  document.getElementById("success-messages").innerHTML = this.response;
   var object = JSON.parse(this.responseText);

     if(object.success==true){

      $("#messages").html('<div class="alert alert-success">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');

   	setTimeout(function () {
       window.location.href = "../products.php";
    }, 1000);
    
     }else{

      $("#messages").html('<div class="alert alert-danger">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');
     }

    }
  };
  xhttp.open("GET", "../submit/product-deleted.php?id="+id, true);
  xhttp.send();

  
}

</script>

