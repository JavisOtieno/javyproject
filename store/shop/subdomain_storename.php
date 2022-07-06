<?php

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$host=$_SERVER['HTTP_HOST'];
$uri=$_SERVER['REQUEST_URI'];


$split_url_pieces = explode(".av.ke", $host);
$split_url_pieces_stroke = explode("/", $uri);
$count=count($split_url_pieces_stroke);

$page=$split_url_pieces_stroke[$count-1];

 				if(strpos($page,'?')){
					$split_page_category=explode("?", $page);
					$page=$split_page_category[0];
				}


$subdomain = $split_url_pieces[0];

//replace www. with nothing on the website name
$subdomain=str_replace('www.', '', $subdomain);


$username=$subdomain;


//localhost code
//$subdomain="javis";
//$storename="javis";


?>