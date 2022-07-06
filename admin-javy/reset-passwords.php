<?php include 'header.php'; ?>


<?php

date_default_timezone_set("Africa/Nairobi");

require 'connect.inc.php';


if(isset($_GET['type'])){
	$type=$_GET['type'];

	if($type=="promoters"){
$query='SELECT * FROM reset_password';
}
else if($type=="suppliers"){
$query='SELECT * FROM reset_password_suppliers';
}
else if($type=="customers"){
$query='SELECT * FROM reset_password_customers';
}


}
else{
	$query='SELECT * FROM reset_password';
}





echo '<div style="display:inline-block;margin:10px;"><a href="reset-passwords.php?type=promoters"><button>Promoters</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="reset-passwords.php?type=customers"><button>Customers</button></a></div>';

echo '<div style="display:inline-block;margin:10px;"><a href="reset-passwords.php?type=suppliers"><button>Suppliers</button></a></div>';



echo '<div id="messages"></div>';

echo '<div class="table-responsive"><table class="table table-striped"><thead>
<tr><th>ID</th>
<th>User ID</th>
<th>Name</th>
<th>Date</th>
<th>Delete</th></thead>

<tbody>';

$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){

//get promoter name

	$promoter_id=$row['user_id'];
	$query_store="SELECT * FROM users WHERE user_id='$promoter_id'";
	$query_run_store=mysqli_query($db_link,$query_store);

	while($row_store=mysqli_fetch_assoc($query_run_store)){
		$store="Store: ".$row_store['storename']."  Name: ".$row_store['firstname']." ".$row_store['lastname']."  Number:".$row_store['phone'];
	}

echo '<tr>
<td>'.$row['id'].'</td>
<td>'.$row['user_id'].'</td>
<td>'.$store.'</td>
<td>'.date('d/m/Y \a\t h:iA', $row["date"]).'</td>
<td><button onclick="deletePasswordLink(';
echo $row["id"];
echo ',';
echo "'";
echo $type;
echo "'";
echo ')">Delete</button></td>
</tr>';

}

echo "</tbody></table></div>";

 include 'footer.php'; ?>


<script type="text/javascript">
	function deletePasswordLink(id,type) {
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
   		if (type == null || type.trim() === ""){
   			type="promoters";
   		}
       window.location.href = "reset-passwords.php"+"?type="+type;
    }, 1000);
    
     }else{

      $("#messages").html('<div class="alert alert-danger">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');
     }

    }
  };
  xhttp.open("GET", "delete/delete-reset-password.php?id="+id+"&type="+type, true);
  xhttp.send();

  
}

</script>


