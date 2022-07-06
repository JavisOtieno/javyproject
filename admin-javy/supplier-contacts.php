<?php

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="supplier-contacts.csv"');

$user_CSV[0] = array('Name', 'Given Name','Additional Name','Family Name','Yomi Name', 'Given Name Yomi','Additional Name Yomi','Family Name Yomi','Name Prefix','Name Suffix','Initials','Nickname',
	'Short Name','Maiden Name','Birthday','Gender','Location','Billing Information','Directory Server',
	'Mileage','Occupation','Hobby','Sensitivity','Priority','Subject	Notes','Language','Photo','Group Membership','Phone 1 - Type','Phone 1 - Value');
					    															


// very simple to increment with i++ if looping through a database result 



require 'connect.inc.php';



$query_last_saved_contact='SELECT * FROM last_saved_contact';
$query_run_last_saved=mysqli_query($db_link,$query_last_saved_contact);
while($row=mysqli_fetch_assoc($query_run_last_saved)){
	$last_saved_contact=$row['supplier_contact'];
}


$query='SELECT * FROM suppliers';

$query_run=mysqli_query($db_link,$query);

$rows=mysqli_num_rows($query_run);

$count=1;

while($row=mysqli_fetch_assoc($query_run)){

	$userId=$row['id'];

	$dealerId=$row['registered_on'];

if($dealerId!=0){

$query2='SELECT * FROM users WHERE user_id='.$dealerId;
$query_run2=mysqli_query($db_link,$query2);
if($row2=mysqli_fetch_assoc($query_run2)){
	$storename = $row2['storename'];
}

}else{
	$storename='JAVY';
}



if ($userId>$last_saved_contact){
	$user_CSV[$count] = array(ucfirst($row['name']).' Supplier '.$storename, ucfirst($row['name']).' Supplier '.$storename,'','','', '','','','','','','',
	'','','','','','','',
	'','','','','','','','','','Mobile',$row['phone']);
	$count++;
	$lastuserid=$userId;
}

}


$query_update_last_saved='UPDATE last_saved_contact SET supplier_contact='.$lastuserid;
mysqli_query($db_link,$query_update_last_saved);



$fp = fopen('php://output', 'wb');
foreach ($user_CSV as $line) {
    // though CSV stands for "comma separated value"
    // in many countries (including France) separator is ";"
    fputcsv($fp, $line, ',');
}
fclose($fp);

?>