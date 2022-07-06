<?php
include 'core.php';
require 'fpdf.php';
require 'connect.inc.php';



if(isset($_GET['id'])){
$id=$_GET['id'];
}

$query="SELECT * FROM deals where id='$id'";

$query_run=mysqli_query($db_link,$query);
while($row=mysqli_fetch_assoc($query_run)){
$dealer_id=$row['dealer_id'];
$GLOBALS['customer_name']=$row['name'];
$GLOBALS['customer_phone']=$row['phone'];
$GLOBALS['delivery_details']=$row['delivery_details'];
$deal_date=date('d/m/Y \a\t h:iA',$row['dealDate']);
$product_price=$row['product_price'];
$product_name=$row['product_name'];


$product_id=$row['product_id'];
$GLOBALS['product_id']=$product_id;


if($product_id==0){
$query_cart="SELECT * FROM cart_items where order_id='$id'";

$query_run_cart=mysqli_query($db_link,$query_cart);
while($row_cart=mysqli_fetch_assoc($query_run_cart)){
    $product_id=$row_cart['product_id'];
    $GLOBALS['product_id']=$product_id;

}
}







}



$query2="SELECT * FROM users where user_id='$dealer_id'";
$query_run=mysqli_query($db_link,$query2);
while($row=mysqli_fetch_assoc($query_run)){
 $GLOBALS['store_name']=ucfirst($row['storename']);
 $storename=$row['storename'];
 $promoter_phone=$row['phone'];
 

}

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    // Line break
    $this->Ln(20);
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',25);
    // Move to the right
    //$this->Cell(80);
    //set border color to red
    $this->SetDrawColor(255,255,255);
    // Title
    $this->SetTextColor(255,0,0);

    $this->Cell(0,0,$GLOBALS['store_name'],0,0,'L');
        $this->SetX($this->lMargin);
        $this->Cell(0,0,' ',0,0,'C');
        $this->SetX($this->lMargin);
        $this->Cell( 0, 0, 'Sales Receipt', 0, 0, 'R' ); 

    //$this->Cell(30,10,$GLOBALS['store_name'].'       :       '.'Sales Receipt' ,1,0,'C');
    // Line break
    $this->Ln(10);
    $this->SetFont('Arial','B',10);
    $this->SetTextColor(0,0,0);
    $this->Cell(0,0,' Online Store : www.'.strtolower($GLOBALS['store_name']).'.av.ke',1,0);
    $this->Ln(5);
    $this->Cell(0,0,' Electronics and many more products',1,0);
    $this->Ln(10);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
function FancyTable($header, $data)
{


    
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(20, 15, 100, 25, 30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $this->SetFillColor(255,204,203);
    $fill = false;

//checks if data length is more than 52
    if(strlen($data[2])>44){

        $first = substr($data[2], 0, 44);
        $position_of_last_space = strrpos($first, ' ') + 1;
        $first= substr($data[2], 0, $position_of_last_space);
        $theRest = substr($data[2], $position_of_last_space);

        //displays the first line

        $this->Cell($w[0],6,$data[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$data[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$first,'LR',0,'L',$fill);
        $this->Cell($w[3],6,$data[3],'LR',0,'R',$fill);
        $this->Cell($w[4],6,$data[4],'LR',0,'R',$fill);
        $this->Ln();




        while(strlen($theRest)>44){

        $first = substr($theRest, 0, 44);
        $position_of_last_space = strrpos($first, ' ') + 1;

        $first= substr($theRest, 0, $position_of_last_space);
        $theRest = substr($theRest, $position_of_last_space);
        //$theRest = substr($theRest, 52);

        $this->Cell($w[0],6,'','LR',0,'L',$fill);
        $this->Cell($w[1],6,'','LR',0,'L',$fill);
        $this->Cell($w[2],6,$first,'LR',0,'L',$fill);
        $this->Cell($w[3],6,'','LR',0,'R',$fill);
        $this->Cell($w[4],6,'','LR',0,'R',$fill);
        $this->Ln();

        $fill=!$fill;

        }

        $this->Cell($w[0],6,'','LR',0,'L',$fill);
        $this->Cell($w[1],6,'','LR',0,'L',$fill);
        $this->Cell($w[2],6,$theRest,'LR',0,'L',$fill);
        $this->Cell($w[3],6,'','LR',0,'R',$fill);
        $this->Cell($w[4],6,'','LR',0,'R',$fill);
        $this->Ln();

        $fill=!$fill;

    }
    else{
     $this->Cell($w[0],6,$data[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$data[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$data[2],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$data[3],'LR',0,'R',$fill);
        $this->Cell($w[4],6,$data[4],'LR',0,'R',$fill);
        $this->Ln();

        $fill=!$fill;
    }

        $x=1;
        while($x<=13){
        $this->Cell($w[0],6,'','LR',0,'L',$fill);
        $this->Cell($w[1],6,'','LR',0,'L',$fill);
        $this->Cell($w[2],6,'','LR',0,'L',$fill);
        $this->Cell($w[3],6,'','LR',0,'R',$fill);
        $this->Cell($w[4],6,'','LR',0,'R',$fill);
        $this->Ln();
        $x++;

        $fill=!$fill;
    }

        //if(strlen(data[2])>

     $this->Cell($w[0],6,'','LR',0,'L',$fill);
        $this->Cell($w[1],6,'','LR',0,'L',$fill);
        $this->Cell($w[2],6,'','LR',0,'L',$fill);
        $this->Cell($w[3],6,'Total','LR',0,'R',$fill);
        $this->Cell($w[4],6,$data[4],'LR',0,'R',$fill);
        $this->Ln();
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

}





// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);



$pdf->Cell(0,7,'Date : '.$deal_date,0,1,'R');
$pdf->Cell(0,7,'Invoice/Order Number : '.$id,0,1,'R');

$pdf->Ln(5);

$pdf->Cell(0,7,'SOLD TO : '.$GLOBALS['customer_name'],0,1);
$pdf->Cell(0,7,'                   '.$GLOBALS['customer_phone'],0,1);
if(strlen($GLOBALS['delivery_details'])>44){

    $first = substr($GLOBALS['delivery_details'], 0, 44);
    $position_of_last_space = strrpos($first, ' ') + 1;
    $first= substr($GLOBALS['delivery_details'], 0, $position_of_last_space);
    $theRest = substr($GLOBALS['delivery_details'], $position_of_last_space);

     $pdf->Cell(0,7,'                   '.$first,0,1);

     while(strlen($theRest)>44){

         $first = substr($theRest, 0, 44);
        $position_of_last_space = strrpos($first, ' ') + 1;
        $first= substr($theRest, 0, $position_of_last_space);
        $theRest = substr($theRest, $position_of_last_space);

        $pdf->Cell(0,7,'                   '.$first,0,1);
    }
    $pdf->Cell(0,7,'                   '.$theRest,0,1);

}else{
    $pdf->Cell(0,7,'                   '.$GLOBALS['delivery_details'],0,1);
}


//space
$pdf->Cell(0,10,'                   ',0,1);

$headerTable = array('Quantity', 'Id', 'Product Description', 'Price','Amount');
$data= array('1', $product_id ,$product_name, number_format($product_price),number_format($product_price));
$pdf->FancyTable($headerTable,$data);

$pdf->Cell(0,10,'                   ',0,1);
$pdf->Cell(0,10,'                   ',0,1);

$pdf->Cell(0,5,'Thank you for your business! ',0,1,'C');
$pdf->Cell(0,5,'Visit our Website:  www.'.$storename.'.av.ke',0,1,'C');
$pdf->Cell(0,5,'Contact us on '.$promoter_phone,0,1,'C');

?>