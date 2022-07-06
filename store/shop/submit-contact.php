<?php

require('connect.inc.php');
require('subdomain_storename.php');

if(isset($_POST['name'])&&isset($_POST['phone'])&&isset($_POST['email'])&&isset($_POST['message'])){

$name=mysqli_real_escape_string($db_link,$_POST['name']);
$email=mysqli_real_escape_string($db_link,$_POST['email']);
$email2=mysqli_real_escape_string($db_link,$_POST['email2']);
$message=mysqli_real_escape_string($db_link,$_POST['message']);
$phone=mysqli_real_escape_string($db_link,$_POST['phone']);



}

$valid2['success'] = array('success' => false, 'messages' => array());

//getting the phone number
$querydb="SELECT * FROM `suppliers` WHERE `username` ='$username'";

$query_run=mysqli_query($db_link,$querydb);
if($row=mysqli_fetch_assoc($query_run)){
	
	$supplier_id=$row['id'];
    $supplier_email=$row['email'];
    $supplier_name = $row['name'];

}


$time=time();
//date_default_timezone_set("Africa/Nairobi");

$sql="INSERT INTO `suppliers_contact_forms` VALUES(NULL,'$name','$phone','$email','$message','','$supplier_id',0,'$time')";

// if($connect->query($sql)){
// 	echo 'success';
// }s
// else{
// 		if ($connect->error) {
//     try {    
//         throw new Exception("MySQL error $connect->error <br> Query:<br> $sql", $connect->errno);    
//     } catch(Exception $e ) {
//         echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
//         echo nl2br($e->getTraceAsString());
//     }
// }
// }

//false email on contact form for the bots
if(empty($email2))
{

    if($connect->query($sql) === TRUE ) {

 //PHP MAIL DOES NOT WORK ON LOCALHOST. UNCOMMENT ON UPLOAD      
$to      = 'javisotieno@gmail.com';
$subject = 'CONTACT FORM by:'.$name;
$headers = 'From: info@javytech.co.ke' 
.'
'.
    'Reply-To: info@javytech.co.ke' 
    .'
    '.
    'X-Mailer: PHP/' . phpversion();
$message_email_javis =  (
            'Name: '.$name
            .'
            '.
            'Phone: '.$phone
            .'
            '.
            'Email: '.$email
            .'
            '.
            'Store name: '.$username
            .'
            '.
            'Promoter Id: '.$dealer_id
            .'
            '.
            'Message: '.$message.'');


//prevent spam email from www.av.ke   
if($username=='www'){

}else{
    //uncomment on upload
//mail($to, $subject, $message_email_javis, $headers);
}



require("email-sendgrid/sendgrid-php.php"); 


                $email_sendgrid = new \SendGrid\Mail\Mail(); 
                $email_sendgrid->setFrom("info@javy.co.ke", "Javy Technologies");
                $email_sendgrid->setSubject("Contact Message received on www.".$username.".av.ke");
                $email_sendgrid->addTo($supplier_email, $supplier_name);
                $email_sendgrid->addContent("text/plain", "Hello, ".$supplier_name.". Message received on www.".$username.".av.ke from ".$name." ".$phone.". We will contact the client and update you. However if you know the client, you can let us know on 0716 545459 and contact the client directly." );
                //$email_sendgrid->addContent("text", "<strong>and easy to do anywhere, even with PHP</strong>");
                $sendgrid = new \SendGrid('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');
                try {
                    $response = $sendgrid->send($email_sendgrid);
                     //print $response->statusCode() . "\n";
                     //print_r($response->headers());
                     //print $response->body() . "\n";
                } catch (Exception $e) {
                    //echo 'Caught exception: ',  $e->getMessage(), "\n";
                }

                $email_sendgrid_customer = new \SendGrid\Mail\Mail(); 
                $email_sendgrid_customer->setFrom("info@javy.co.ke", ucfirst($username));
                $email_sendgrid_customer->setSubject("Your message on www.".$username.".av.ke has been received.");
                $email_sendgrid_customer->addTo($email, $name);
                $email_sendgrid_customer->addContent("text/plain", "Hello, ".$name.". Your message on www.".$username.".av.ke from our Contact Us page has been received. One of our representatives will be contacting you soon." );
                //$email_sendgrid->addContent("text", "<strong>and easy to do anywhere, even with PHP</strong>");
                $sendgrid = new \SendGrid('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');
                try {
                    $response = $sendgrid->send($email_sendgrid_customer);
                     //print $response->statusCode() . "\n";
                     //print_r($response->headers());
                     //print $response->body() . "\n";
                } catch (Exception $e) {
                    //echo 'Caught exception: ',  $e->getMessage(), "\n";
                }


        $valid2['success'] = true;
        $valid2['messages'] = "Your message has been received. We'll get back to you!";  


    } else if ($connect->error) {
    echo 'Connect Error: '.$connect->error;
}

    }
    else{

        $valid2['success'] = true;
        $valid2['messages'] = "Your message has been received. We'll get back to you. Thanks";  

    }

    $connect->close();

     echo json_encode($valid2);