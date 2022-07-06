<?php

	

	include '../connect.inc.php';

	if(isset($_GET['id'])){
		$id=$_GET['id'];
	}
    if(isset($_GET['type'])){
        $type=$_GET['type'];
    }

    $errors='';

	$sql="SELECT category,brand from products where id='$id'";

	$query_run=mysqli_query($db_link,$sql);

	if($row=mysqli_fetch_assoc($query_run)){

		$category=$row['category'];
		$brand=$row['brand'];
		
	}



if($type=='offer'){
    //local code
    //$target_dir = "../stock-2/assests/images/offers/";
$folder_path_set_in_database="assests/images/offers/";
}else{
    $folder_path_set_in_database="../assests/images/product-images/".$category."/".$brand."/";
}
//local code
//$target_dir = "../stock-2/assests/images/product-images/".$category."/".$brand."/";
//web code


if($type=='offer'){
    //local code
    //$target_dir = "../stock-2/assests/images/offers/";
   $target_dir = "../../store/admin/assests/images/offers/"; 
}else{
    $target_dir = "../../store/admin/assests/images/product-images/".$category."/".$brand."/";
}

//check if target directory exists. If it doesn't, create the directory to prevent conflict on upload.
    if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}


$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $errors.="File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $errors.="File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $errors.="Sorry, file already exists.  ";
    $uploadOk = 1;

    if($type=='offer'){
    $uploadOk = 1;
}else{
    $uploadOk = 0;
}

}
// Check file size

if ($_FILES["fileToUpload"]["size"] > 500000) {
    $errors.="Your file is too large. Size: ".$_FILES["fileToUpload"]["size"];
    $uploadOk = 1;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $errors.="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $errors .="Sorry, your file was not uploaded.";
     $valid['success'] = false;
        $valid['messages'] = $errors; 
   echo json_encode($valid);
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $errors .= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        $image_name=$_FILES["fileToUpload"]["name"];
        $image_path=$folder_path_set_in_database.$image_name;

        if($type=='product'){

            $sql_update_image="UPDATE products SET image='$image_path' WHERE id='$id'";

        }elseif($type='offer'){

        $sql_update_image="UPDATE offers2 SET original_image='$image_path' WHERE id='$id'";

        }

        if($connect->query($sql_update_image)){
    $valid['success'] = true;
    $valid['messages'] = "Database Updated Successfully Added".$errors;        

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
   echo json_encode($valid);
        



    }

     else {
        $errors .= "Sorry, there was an error uploading your file.";

        $valid['success'] = false;
        $valid['messages'] = $errors; 
   echo json_encode($valid);
    }
}
?>