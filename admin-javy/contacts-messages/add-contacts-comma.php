<?php include '../header-folder-up.php'; ?>

<form action="add-contacts-comma.php" method="POST" style="margin-left: 20px;width: 40%;">
<div class="form-group"><label>Store id</label>
<textarea class="form-control" name="store_id" id="store_id"></textarea>
<div class="form-group"><label>Contacts</label>
<textarea class="form-control" name="contacts" id="contacts"></textarea>
</div>
<br/>
<input style="background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;" type="submit" value="ADD">
</form>
<?php

if (!(isset($_POST['contacts']))){


  echo "<span style='margin-left:20px;color:#C80909'>Enter contacts!!</span>";

}else{
$contacts=$_POST['contacts'];
$store_id=$_POST['store_id'];

$contacts_array=explode(',', $contacts);

echo 'size: '.sizeof($contacts_array);

foreach ($contacts_array as $key => $value) {
	# code...
	$value_trimmed=trim($value);
	$value_spaces_removed=str_replace(' ', '', $value_trimmed);

	

	$phonenumber=$value_spaces_removed;

	$firstdigit=substr($phonenumber, 0, 1);

	if($firstdigit=='0'){
		$textableNumber = "+254".substr($phonenumber,1);
	}elseif($firstdigit=='7'){
		$textableNumber = "+254".$phonenumber;
	}elseif($firstdigit=='2'){
		$textableNumber = "+".$phonenumber;
	}elseif($firstdigit=="+"){
		$textableNumber = $phonenumber;
	}

	echo 'Key: '.$key.'  ---  Value: '.$textableNumber.'<br/>';



$sql="INSERT INTO `customer_numbers_for_messages` VALUES(NULL,'$textableNumber','$store_id')";

if($connect->query($sql)){
      
}
else{
        if ($connect->error) {
    try {    
        throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
    } catch(Exception $e ) {
        $valid['success'] = false;
        $valid['messages'] = "Error No - ".$e->getCode(). " - ". $e->getMessage()."<br/>".nl2br($e->getTraceAsString()); 
    }
}
}

	}


  
}

include '../footer.php'; 
