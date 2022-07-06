<?php

include 'header.php';

if(isset($_GET['source'])){
	$source=$_GET['source'];
}
if(isset($_GET['file'])){
	$file_name=$_GET['file'];
	echo "This is the filename: ".$file_name;
	echo ". This is the source: ".$source;
}
if( (isset($_GET['category'])) && (isset($_GET['brand'])) ) {

	$category=$_GET['category'];
	$brand=$_GET['brand'];
	}
	$image=str_replace('../store/admin/', 'http://promote.javy.co.ke/', $source);
echo'<div class="row"><div class="col-md-4"><img style="width:300px;height:300px;" src="'.$image.'"></img></div>';
?>
<div class="col-md-6">
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
				      	/*
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



    if($('#categoryName').val()&&$('#categoryName').val()!='other'){
 
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

	        <?php


	echo '<button style="background-color: #FF9900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer; " class="btn btn-default " onclick="moveFile(';
	echo "'".$source."'";
	echo ',';
	echo "'".$category."'";
	echo ',';
	echo "'".$brand."'";
	echo ',';
	echo "'".$file_name."'";
	echo ')">Move Image</button>';





     echo '<button style="background-color: #FF0000;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;" class="btn btn-default " 
								  aria-haspopup="true" onclick="deleteFile(';
	echo "'".$source."'";
	echo ',';
	echo "'".$category."'";
	echo ',';
	echo "'".$brand."'";
	echo ')"> Delete Image </button></td> ';
	echo '<div id="messages"></div>
    ';

    echo '<div class="form-group">
	<label>New Image Name(include extension .jpg):</label>
	<input type="text" class="form-control" name="new_file_name" id="new_file_name"/>
	</div>';


	echo '<button style="background-color: #FF9900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer; " class="btn btn-default "  

    onclick="renameFile(';
	echo "'".$source."'";
	echo ',';
	echo "'".$file_name."'";
	echo ')">Rename Image</button>

  <a href="submit/download-file.php?file=../'.$source.'"><button style="background-color: #FF9900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    display:inline-block;
    margin-left:20px;
    cursor: pointer; " class="btn btn-default " >Download Image</button></a>

  </div>';





include 'footer.php';

?>

<script type="text/javascript">
	function deleteFile(source,category,brand) {
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
       window.location.href = "../media.php?category="+category+"&brand="+brand;
    }, 1000);
    
     }else{

      $("#messages").html('<div class="alert alert-danger">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');
     }
    }
  };
  xhttp.open("GET", "delete/delete-file.php?source="+source+"&category="+category+"&brand="+brand, true);
  xhttp.send();
  location.reload();
}


function moveFile(source,category,brand,file_name) {
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
   		var new_category= $("#categoryName").val();
   		var new_brand= $("#brandName").val();
   		new_source='../store/admin/assests/images/product-images/'+new_category+'/'+new_brand+'/'+file_name;
       window.location.href = 'display-image.php?file='+file_name+'&source='+new_source;
    }, 1000);
    
     }else{

      $("#messages").html('<div class="alert alert-danger">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');
     }
    }
  };
  var new_category= $("#categoryName").val();
  var new_brand= $("#brandName").val();

  xhttp.open("GET", "submit/move-file.php?source="+source+"&category="+category+"&brand="+brand+"&new_category="+new_category+"&new_brand="+new_brand+"&file_name="+file_name, true);
  xhttp.send();

}

function renameFile(source,file_name) {
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
   		var new_file_name= $("#new_file_name").val()
   		var new_source=source.replace(file_name, new_file_name);
       window.location.href = 'display-image.php?file='+new_file_name+'&source='+new_source;
    }, 1000);
    
     }else{

      $("#messages").html('<div class="alert alert-danger">'+
                '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ object.messages +                                                
               '</div>');
     }
    }
  };
  var new_file_name= $("#new_file_name").val();
  xhttp.open("GET", "submit/rename-file.php?source="+source+"&new_file_name="+new_file_name+"&file_name="+file_name, true);
  xhttp.send();
  
}
</script>