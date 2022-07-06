<?php 

session_start();

// echo $_SESSION['userId'];


if(!$_SESSION['userId']) {
	//header('location: http://localhost/websites/stock-2/login.php');
	// for the web	
	$uri=$_SERVER['REQUEST_URI'];
$split_url_pieces_stroke = explode("/", $uri);
$directory=$split_url_pieces_stroke[1];

if($directory=="websites"){
  $directory=$split_url_pieces_stroke[3];
}

if( $directory=="scrape"){
    $folder_up='../../';
}else if($directory=="add" OR $directory=="delete" OR $directory=="edit"){
  $folder_up='../';
}
else{
  $folder_up='';
}

	//header('location: '.$folder_up.'login.php');

	if(isset($uri)){
		header('location: '.$folder_up.'login.php?uri='.$uri);
	}else{
		header('location: '.$folder_up.'login.php');
	}	
} 

$userId=$_SESSION['userId'];



?>