<?php
require('document.php');



// email stuff (change data below)
$to = "javisotieno@gmail.com"; 
$from = "info@javy.co.ke"; 
$subject = $GLOBALS['customer_name'].' Document on '.$product_name; 
$message = "<p>Please find document attached. Customer name: ".$GLOBALS['customer_name']." Customer Phone: ".$GLOBALS['customer_phone']." Customer Delivery Details".$GLOBALS['address']."</p>";

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "document.pdf";

// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");



$attachment = chunk_split(base64_encode($pdfdoc));

// main header
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //

$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
$body .= "This is a MIME encoded message.".$eol;

// message
$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol;

// attachment
$body .= "--".$separator.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
$body .= "--".$separator."--";

// send message

if(mail($to, $subject, $body, $headers)){

    $valid['success'] = true;
    $valid['messages'] = "Document has been sent successfully.";


}
else{
    $valid['success'] = false;
    $valid['messages'] = "Failed. Please Try Again.";

}

    echo json_encode($valid);

?>