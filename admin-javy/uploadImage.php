<!DOCTYPE html>
<html>
<body>


<?php

if(isset($_GET['id'])){
		$id=$_GET['id'];
	}

    if(isset($_GET['type'])){
        $type=$_GET['type'];
    }
    else{
        $type='product';
    }


?>


<form action="<?php 

if($type=='phpimagefile'){
    echo 'uploadPHPFile.php?id='.$id;
}else{
    echo 'uploadImageFile.php?id='.$id.'&type='.$type; 
}

?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<select id="type">
    <option value="item0">--Select an Item--</option>
    <option value="item1">item1</option>
    <option value="item2">item2</option>
    <option value="item3">item3</option>
</select>

<select id="size">
    <option value="">-- select one -- </option>
</select>-->


</body>
</html>
<script type="text/javascript">
$(document).ready(function () {
    $("#type").change(function () {
        var val = $(this).val();
        if (val == "item1") {
            $("#size").html("<option value='test'>item1: test 1</option><option value='test2'>item1: test 2</option>");
        } else if (val == "item2") {
            $("#size").html("<option value='test'>item2: test 1</option><option value='test2'>item2: test 2</option>");
        } else if (val == "item3") {
            $("#size").html("<option value='test'>item3: test 1</option><option value='test2'>item3: test 2</option>");
        } else if (val == "item0") {
            $("#size").html("<option value=''>--select one--</option>");
        }
    });
});
	</script>