<?php include '../header.php'; 

if(isset($_GET['id'])){
	$id=$_GET['id'];
}

$query='SELECT * FROM deals WHERE id='.$id.'';

$query_run=mysqli_query($db_link,$query);


if($row=mysqli_fetch_assoc($query_run)){

	//$highlights=str_replace('<br />', '', $row['highlights']);

	echo "<div style='margin-left:20px;'><h2>Are you sure you want to delete this?</h2>";


	echo '<br>';
	
	echo '<label>Order Id:</label><br/>';
	echo '<div><strong>'.$id.'</strong></div>';
	echo '<div style="margin-top:10px"><label>Phone:</label><br/>';
	echo '<div><strong>'.$row['phone'].'</strong></div>';
	echo '<div style="margin-top:10px"><label>Product Name:</label><br/>';
	echo '<div><strong>'.$row['product_name'].'</strong></div>';
	echo '<div style="margin-top:10px"><label>Date and time:</label><br/>';
	echo '<div><strong>'.$row["dealDate"].'</strong></div>';

	if($row['status']==0){
		$status='cancelled';
	}elseif($row['status']==1){
		$status='complete';
	}elseif ($row['status']==2) {
		$status='complete';
	}

	echo '<div style="margin-top:10px"><label>Status:</label><br/>';
	echo '<div><strong>'.$status.'</strong></div>';

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
    cursor: pointer;" onclick="deleteOrder('.$id.')">Delete order</button></a></div>';


}

include '../footer.php'; ?>


<script type="text/javascript">
	function deleteOrder(id) {
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
       window.location.href = "../orders.php";
    }, 1000);
    
     }else{

      $("#messages").html('<div class="alert alert-danger">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');
     }

    }
  };
  xhttp.open("GET", "../submit/order-deleted.php?id="+id, true);
  xhttp.send();

  
}

</script>
