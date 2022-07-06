<?php

include '../core.php';
require '../connect.inc.php';

if(isset($_GET['type'])){
    $type=$_GET['type'];
}else{
    $type="promoters";
}

if(isset($_GET['id'])){
    $id=$_GET['id'];






    if($type=="promoters"){
$query='DELETE FROM reset_password WHERE id='.$id.'';
}
else if($type=="suppliers"){
$query='DELETE FROM reset_password_suppliers WHERE id='.$id.'';
}
else if($type=="customers"){
$query='DELETE FROM reset_password_customers WHERE id='.$id.'';
}else{
$query='DELETE FROM reset_password WHERE id='.$id.'';
}



if($query_run=mysqli_query($db_link,$query)){

    $valid['success'] = true;
    $valid['messages'] = "The reset password link has been successfully deleted.";


}
else{
    $valid['success'] = false;
    $valid['messages'] = "Failed. Please Try Again.";

}

    $connect->close();
    echo json_encode($valid);

}


?>