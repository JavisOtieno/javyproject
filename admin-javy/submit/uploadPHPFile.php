<?php

	include '../connect.inc.php';

	if(isset($_GET['id'])){
		$id=$_GET['id'];
	}
    $errors='';
   
    //local code
    //$target_dir = "../stock-2/assests/images/offers/";
    $target_dir = "../../store/admin/assests/images/offers/"; 

    $folder_path="assests/images/offers/";


    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image

    /*NO NEED TO CHECK FILE TYPE
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    */

    // Check if file already exists
    if (file_exists($target_file)) {
        $errors .= "File already exists, File overwritten.";
        $uploadOk = 1;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $errors .= "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "php" ) {
        $errors .= "Sorry, only PHP files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $errors .= "Sorry, your file was not uploaded.";
        $valid['success'] = false;
        $valid['messages'] = $errors; 
        echo json_encode($valid);
    
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $errors .= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

            $image_name=$_FILES["fileToUpload"]["name"];
            $image_path=$folder_path.$image_name;

            $sql_update_image="UPDATE offers2 SET image='$image_path' WHERE id='$id'";

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
            
            



        } else {
            $errors .= "Sorry, there was an error uploading your file.";

            $valid['success'] = false;
        $valid['messages'] = $errors; 
   echo json_encode($valid);
        }
    }
    ?>