<?php

include 'php_action/core.php';

if (isset($_POST['submit'])){
	#code...
	$file=$_FILES['file'];

	$fileName=$_FILES['file']['name'];
	$fileTmpName=$_FILES['file']['tmp_name'];
	$fileSize=$_FILES['file']['size'];
	$fileError=$_FILES['file']['error'];
	$fileType=$_FILES['file']['type'];

	$fileExt=explode('.',$fileName);
	$fileActualExt=strtolower(end($fileExt));


	$allowed=array('jpg','jpeg','png');

	if(in_array($fileActualExt,$allowed)){

		if($fileError===0){
				//preferring using the user name to prevent exitence of more than one profile pic for a user. Instead of using the unique identifier shown below
				//$fileNameNew=uniqid('',true).".".$fileActualExt;

				function compress($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
	}



				$fileNameNew=$userId.'.'.$fileActualExt;
				$fileDestination='assests/images/profile-pictures/'.$fileNameNew;
				if($fileSize<=200000){
					
					move_uploaded_file($fileTmpName, $fileDestination);
				}else if($fileSize>200000&&$fileSize<=1000000){
					compress($fileTmpName,$fileDestination,45);
				}else if($fileSize>1000000&&$fileSize<=2000000){
					compress($fileTmpName,$fileDestination,30);
				}else if($fileSize>2000000&&$fileDestination<=5000000){
					compress($fileTmpName,$fileDestination,20);
				}else{
					compress($fileTmpName,$fileDestination,15);
				}
				

				$sql_update_profile_pic="UPDATE users SET `profile_picture`='$fileNameNew' WHERE `user_id`='$userId'";
				mysqli_query($connect,$sql_update_profile_pic);


				header("Location: setting.php");


				
							

		}else{
			echo "There was an error uploading your file!";
		}

	}else{
		echo "You cannot upload files of this type";
	}

}