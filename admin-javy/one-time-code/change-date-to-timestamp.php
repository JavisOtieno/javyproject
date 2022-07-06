<?php

date_default_timezone_set("Africa/Nairobi");

include 'core.php';

require 'connect.inc.php';

$query='SELECT * FROM reset_password';
$query_run=mysqli_query($db_link,$query);


while($row=mysqli_fetch_assoc($query_run)){

	$order_id=$row['id'];

	$date=$row['date'];

$day = substr($date,0,2);

$month = substr($date,3,2);

$year = substr($date,6,4);

$hour = substr($date,14,2);

$minute = substr($date,17,2);

$am_or_pm = substr($date,19,2);


if($year==2018){
$time_on_year = 1514754000;
}
elseif ($year==2019) {
$time_on_year = 1546290000;
}
else{
	$time_on_year=0;
}

if($month==1){
	$days=0;
}elseif ($month==2) {
	$days=31;
}elseif ($month==3) {
	$days=51;
}elseif ($month==4) {
	$days=90;
}elseif ($month==5) {
	$days=120;
}elseif ($month==6) {
	$days=151;
}elseif ($month==7) {
	$days=181;
}elseif ($month==8) {
	$days=212;
}elseif ($month==9) {
	$days=243;
}elseif ($month==10) {
	$days=273;
}elseif ($month==11) {
	$days=304;
}elseif ($month==12) {
	$days=334;
}else{
	$days=0;
}



$seconds_on_months=$days*24*60*60;

$seconds_on_days=($day-1)*24*60*60;

if($am_or_pm=="PM"&&$hour!=12){
	$hour=$hour+12;
}

$seconds_on_hours=$hour*60*60;

$seconds_on_minutes=$minute*60;

$final_timestamp=$time_on_year+$seconds_on_months+$seconds_on_days+$seconds_on_hours+$seconds_on_minutes;

echo "<br/>".$date."---".$final_timestamp."---";

if (\strpos($date, 'at') !== false) {
    $date_on_timestamp="--";
    $query_update='UPDATE reset_password SET date='.$final_timestamp.' WHERE id='.$order_id;
    $query_run_update=mysqli_query($db_link,$query_update);
}else{
	$date_on_timestamp=date('d/m/Y \a\t h:iA' , $date);
}

echo date('d/m/Y \a\t h:iA' , $final_timestamp)."---".$date_on_timestamp;




}











?>