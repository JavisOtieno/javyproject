<?php require_once 'includes/header.php'; ?>
<?php
if(isset($_GET['content'])){
	$content=$_GET['content'];

	$content=$_GET['content'];
	if($content=='videos'){
	include 'promote-videos.php';
}else if($content=='more'){
	include 'promote-more.php';
}else{
	include 'promote-images.php';
}

}else{
	include 'promote-images.php';	
}

?>
<script src="custom/js/report.js"></script>
<script type="text/javascript">

<?php require_once 'includes/footer.php'; ?>