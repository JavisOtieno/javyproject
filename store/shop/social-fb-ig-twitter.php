<?php include 'header.php';?>

<?php
if(isset($_GET['s']))
$social=$_GET['s'];


if($social=='facebook'){
	$text_unavailable="Facebook page";
}elseif ($social=='instagram') {
	$text_unavailable="Instagram profile";
}
elseif($social=="twitter"){
	$text_unavailable="Twitter account";
}
else {
	$text_unavailable="Social media account";
}

?>
<br/ ><br/ >
<h3 class="w3ls-title w3ls-title1">Sorry. <?php echo $text_unavailable;?> unavailable</h3>

<br/ >

 <h3 style='margin-bottom:100px;text-align: center; '>Sorry, we're currently working on our <?php echo $text_unavailable;?>. Check back after some time for the <?php echo $text_unavailable;?> link. Keep using the website to order products.<br/ ><br />
 Connect with us using our <a href="contact.php">contacts</a></h3><br/ ><br/ ><br/ ><br/ >


	<?php include 'footer.php'; ?>