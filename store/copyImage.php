<?php

	

	include '../connect.inc.php';

	if(isset($_GET['id'])){
		$id=$_GET['id'];
	}
    if(isset($_GET['name'])){
        $name=$_GET['name'];
        $name=str_replace('/', '_', $name);
    }
    if(isset($_GET['link'])){
        $link=$_GET['link'];
    }


    $errors='';

	$sql="SELECT category,brand from products where id='$id'";

	$query_run=mysqli_query($db_link,$sql);

	if($row=mysqli_fetch_assoc($query_run)){

		$category=$row['category'];
		$brand=$row['brand'];
		
	}

$folder_path_set_in_database="../assests/images/product-images/images_from_websites/";


$target_dir = "../../store/av-admin/assests/images/product-images/images_from_websites/";

//check if target directory exists. If it doesn't, create the directory to prevent conflict on upload.
    if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if(strpos($name, '?')!==false && strpos($name, '=')!==false ){
    $name_array=explode('?', $name);
    $name=$name_array[0];
}else if(strpos($name, '..')!==false){
    $name = str_replace('..', '.', $name);
}

$target_file = $target_dir . $name;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

// Check if file already exists
if (file_exists($target_file)) {
    $errors.="Sorry, file already exists.  ";
    $uploadOk = 0;

            $image_path=$folder_path_set_in_database.$name;

        $sql_update_image="UPDATE products SET image='$image_path' WHERE id='$id'";

      

        if($connect->query($sql_update_image)){
    $valid['success'] = true;
    $valid['messages'] = "Database Updated Successfully Added".$errors; 

    //header('location: ../edit/edit-product.php?product_id='.$id);


}
else{
        if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        $valid['success'] = false;
        $valid['messages'] = $errors."Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
    }
}
}


}
// Check file size

if ($_FILES["fileToUpload"]["size"] > 500000) {
    $errors.="Your file is too large. Size: ".$_FILES["fileToUpload"]["size"];
    $uploadOk = 1;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $errors .="Sorry, your file was not uploaded.";
    $valid['success'] = false;
    $valid['messages'] = $errors; 
   
// if everything is ok, try to upload file
} else {
    if (copy($link, $target_file)) {
        $errors .= "The file ".$name." has been uploaded from the website.";

        $image_path=$folder_path_set_in_database.$name;

        $sql_update_image="UPDATE products SET image='$image_path' WHERE id='$id'";

      

        if($connect->query($sql_update_image)){
    $valid['success'] = true;
    $valid['messages'] = "Database Updated Successfully Added".$errors; 

    header('location: ../edit/edit-product.php?product_id='.$id);


}
else{
        if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        $valid['success'] = false;
        $valid['messages'] = $errors."Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
    }
}
}

        



    }

     else {
        $errors .= "Sorry, there was an error uploading your file.";

        $valid['success'] = false;
        $valid['messages'] = $errors; 
   
    }
}
echo json_encode($valid);
?>