<?php

include '../core.php';
require '../connect.inc.php';

if(isset($_GET['id'])){
	$id=$_GET['id'];


$query='DELETE FROM banners WHERE id='.$id.'';


if($query_run=mysqli_query($db_link,$query)){

    $valid['success'] = true;
    $valid['messages'] = "The banner has been successfully deleted.";


}
else{
    $valid['success'] = false;
    $valid['messages'] = "Failed. Please Try Again.";

}

    $connect->close();
    echo json_encode($valid);

}


?>