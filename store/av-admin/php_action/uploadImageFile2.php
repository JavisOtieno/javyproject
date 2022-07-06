<?php



	include 'core.php';

    if(isset($_GET['source'])){
        $source = $_GET['source'];
    }

	if($_POST) {
		$id = $_POST['productId'];
	}

    if ($source=='add'){
        $fileName=$_FILES["addProductImage"];
    }else{
        $fileName=$_FILES["editProductImage"];
    }

    $errors='';

	$sql="SELECT name,category,brand from products where id='$id'";

    $query_run=$connect->query($sql);

	if($row=mysqli_fetch_assoc($query_run)){

		$category=$row['category'];
		$brand=$row['brand'];
        $name=$row['name'];

        $namelower=strtolower($name);
        $namelowertrm=trim($namelower);
        $namelowertrmhyphen=str_replace(' ', '-', $namelowertrm);

        //to be continued or deleted --- forming new name for the product images

		
	}



    $folder_path_set_in_database="../assests/images/product-images/images-by-users/";
//local code
//$target_dir = "../stock-2/assests/images/product-images/".$category."/".$brand."/";
//web code



    $target_dir = "../../av-admin/assests/images/product-images/images-by-users/";

//check if target directory exists. If it doesn't, create the directory to prevent conflict on upload.
    //to be deleted as one directory is selected for all images submitted by promoteer
    if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}



$image_name=$id."_".time()."_".basename($fileName["name"]);
$target_file = $target_dir.$image_name;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($fileName["tmp_name"]);

    if(@is_array(getimagesize($fileName["tmp_name"]))){
    $errors.="File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
} else {
    $errors.="File is not an image.";
    $uploadOk = 0;
}

}

if (($fileName['type'] == 'image/gif') || ($fileName['type'] == 'image/jpeg') || ($fileName['type'] == 'image/png')){
    $errors.="File is an image ";
    $uploadOk = 1;
}else{
    $errors.="File is not an image.";
    $uploadOk = 0;
}

$allowed_types = array ( 'image/gif' , 'image/jpeg', 'image/png' );
$fileInfo = finfo_open(FILEINFO_MIME_TYPE);
$detected_type = finfo_file( $fileInfo, $fileName["tmp_name"] );
if ( !in_array($detected_type, $allowed_types) ) {
    $errors.= ' File is not an image. ';
    $uploadOk = 0;
    die();
}
finfo_close( $fileInfo );



// Check if file already exists
if (file_exists($target_file)) {
    $errors.="Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
//TO LIMIT FILE SIZES IN THE FUTURE
/*
if ($_FILES["editProductImage"]["size"] > 500000) {
    $errors.="File Size: ".$_FILES["editProductImage"]["size"];
    $uploadOk = 1;
}
*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $errors .="Sorry, your file was not uploaded.";
     $valid['success'] = false;
        $valid['messages'] = $errors; 
   echo json_encode($valid);
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($fileName["tmp_name"], $target_file)) {
        $errors .= "The file ". basename( $fileName["name"]). " has been uploaded.";

        $image_path=$folder_path_set_in_database.$image_name;


    $sql_update_image="UPDATE products SET image='$image_path' WHERE id='$id'";


        if($connect->query($sql_update_image)){
    $valid['success'] = true;
    $valid['messages'] = $errors;        

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