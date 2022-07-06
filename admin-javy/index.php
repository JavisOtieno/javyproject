<?php include('header.php'); ?>

<?
if($userId==1){
	include 'home-page-admin.php';
}else{
	include 'home-page-editor.php';
}

?>

<?php include 'footer.php'; ?>