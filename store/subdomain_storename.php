<?php

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$host=$_SERVER['HTTP_HOST'];
$uri=$_SERVER['REQUEST_URI'];





$split_url_pieces = explode(".av.ke", $host);
$split_url_pieces_stroke = explode("/", $uri);
$count=count($split_url_pieces_stroke);

$page=$split_url_pieces_stroke[$count-1];
$subdomain = $split_url_pieces[0];

$subdomain = $split_url_pieces[0];

$subdomain=str_replace('www.', '', $subdomain);

$storename=$subdomain;




if (strpos($actual_link, '.co.ke') !== false) {

$split_url_pieces = explode(".co.ke", $host);
$split_url_pieces_stroke = explode("/", $uri);
$count=count($split_url_pieces_stroke);

$page=$split_url_pieces_stroke[$count-1];
$subdomain = $split_url_pieces[0];

$subdomain = $split_url_pieces[0];

$subdomain=str_replace('www.', '', $subdomain);

$storename=$subdomain;


}

if (strpos($actual_link, 'shop.javy.co.ke') !== false) {
	$storename='javy';
}
else if(strpos($actual_link,'phoneplacekisumu.av.ke') !== false){
	header("Location: https://phoneshopkisumu.av.ke/", true, 301);
}



//localhost code
//$subdomain="javis";
//$storename="javis";

?>