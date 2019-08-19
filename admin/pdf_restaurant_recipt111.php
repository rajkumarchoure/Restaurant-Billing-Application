<?php
include("../adminsession.php");
require("../fpdf181/fpdf.php");
require("../pdf_js.php");
if(isset($_GET['billid']))
{	
$billid = addslashes($_GET['billid']);
$height=$cmn->getvalfield("bill_details","count(*)","billid='$billid'");
$pageheight = $height * 140;

//$taxamt=$cmn->getTotalcGst($billid);
//$igstamt=$cmn->getTotalIgst_Sale($billid);
}

class PDF_AutoPrint extends PDF_JavaScript
{
	  var $widths;
  var $aligns;
  
  function Header()
	{
		global $title1,$title2,$title3,$title4,$title5;
		
		$this->SetFont('courier','b',17);
		// Move to the right
		//$this->Cell(10);
		$this->SetY(7);
		$this->SetX(2);
		// Title
		$this->Cell(60,0,$title1,0,0,'C');
		
		$this->Ln(5);
		$this->SetX(2);
		$this->SetFont('courier','b',8);
		//$this->Cell(60,0,$title2,0,0,'C');
		$this->MultiCell(60,0,$title2,0,'C');
	    $this->Ln(3);
	    $this->SetX(2);
		$this->SetFont('courier','b',8);
		$this->Cell(60,0,$title3,0,0,'C');
		$this->Ln(3);
		
		
	    $this->SetX(2);
		$this->SetFont('courier','b',8);
		$this->Cell(60,0,$title4,0,1,'C');
		$this->Ln(3);
		
		$this->SetX(2);
		$this->SetFont('courier','b',8);
		$this->Cell(60,0,$title5,0,0,'C');
		$this->Ln(1);
	
	
	    //$this->Cell(-1);
		//$this->SetFont('courier','b',8);
		//$this->Cell(192,5,"Print Date : ".date('d-m-Y'),1,1,'R');
		 //$this->Ln(1);
		 
	}
	  // Page footer
	function Footer()
	{
	// Position at 1.5 cm from bottom
		$this->SetY(-1);
		// Arial italic 8
		$this->SetFont('Arial','I',8); 
		// Page number
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}
	
	function SetBorder($b)
	{
		//Set the array of column widths
		$this->border=$b;
	}
	
	
	
	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
  
    function AutoPrint($printer='')
    {
        // Open the print dialog
        if($printer)
        {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        }
        else
            $script = 'print(true);';
        $this->IncludeJS($script);
	 }
	 
}
$pdf = new PDF_AutoPrint('P', 'mm',array(65 ,$pageheight));
$title1 = $cmn->getvalfield("company_setting","comp_name","1 = 1");
$title2 = ucwords($cmn->getvalfield("company_setting","address","1 = 1"));
$title3 = ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));
$mobile =$cmn->getvalfield("company_setting","mobile","1 = 1");
$title4 = "Mobile No: $mobile";
//$gsttinno  =$cmn->getvalfield("company_setting","gsttinno","1 = 1");
$title5 = "GST No: $gsttinno";
//$term_cond = $cmn->getvalfield("company_setting","term_cond","1 = 1");

$pdf->SetTitle($title1);
$billnumber = $cmn->getvalfield("bills","billnumber","billid='$billid'");
$billdate   = $cmn->getvalfield("bills","billdate","billid='$billid'");
$suppartyid = $cmn->getvalfield("bills","suppartyid","billid='$billid'");
$supparty_name = $cmn->getvalfield("m_supplier_party","supparty_name","suppartyid='$suppartyid'");
$discr = $cmn->getvalfield("bills","disc","billid='$billid'");
$pdf->AddPage();
$pdf->SetFont('Arial','b',9);
$pdf->Ln(4);
$pdf->SetFont('Arial','b',9);
$pdf->SetX(2);
if($is_parsal == 0)
{
$pdf->Cell(35,6,"",'0',0,'L',0); 
}
else
{
$pdf->Cell(35,6,"Parcel",'0',1,'L',0); 	
}

$pdf->SetFont('Arial','b',8);
$pdf->SetX(2);
$pdf->Cell(35,6,"Bill No : $billnumber",'0',0,'L',0); 
$pdf->Cell(26,6,"Bill Date :  ". $cmn->dateformatindia($billdate).' '.$billtime,'0',1,'R',0);  

//$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,25,62,25);

//$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,33,62,33);

$pdf->Ln(2);
//$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,40,62,40);

$pdf->SetFont('Arial','b',8);
$pdf->SetX(2);
$pdf->SetDrawColor('255','255','255');
//$pdf->Cell(9,5,' Sno','0',0,'C',0);  
$pdf->SetFont('Arial','',8);
$pdf->SetX(2);
$pdf->SetDrawColor('255','255','255');
//$pdf->Cell(9,5,' Sno','0',0,'C',0);  
$pdf->Cell(25,5,'Particular',0,0,'L',0);
$pdf->Cell(7,5,'Qty.',0,0,'C',0);
$pdf->Cell(12,5,'Rate',0,0,'R',0);
$pdf->Cell(15,5,'Total',0,1,'R',0);
$pdf->SetWidths(array(25,7,12,15));
$pdf->SetAligns(array('L','C','R','R'));

$pdf->Ln(2);
$total=0;
$slno=1;
$sql_get = mysql_query("select * from bill_details where billid=$billid");
	while($row_get = mysql_fetch_assoc($sql_get))
	{ 
	$amount=0;
	$productid=$row_get['productid'];
	$qty=$row_get['qty'];
	$unitid=$row_get['unitid'];
	$rate=$row_get['rate'];
	$prodname=$cmn->getvalfield("m_product","prodname","productid='$productid'");
	$unit_name=$cmn->getvalfield("m_unit","unit_name","unitid='$unitid'"); 
	$amount= number_format($qty * $rate,2);
$pdf->SetFont('Arial','',7);
$pdf->SetDash(0,0); //5mm on, 5mm off
$pdf->SetX(2);
//$pdf->Cell(50,5,"$qty $unit_name $prodname $rate $amount",'0',1,'L',0);  
$pdf->Row(array( strtoupper($prodname),$row_get['qty'],number_format($row_get['rate'],2),$amount),1,1,'L',0); 

	$total +=$amount;
	}


$pdf->SetFont('Arial','b',8);
$pdf->SetX(5);
$pdf->Cell(48,5,"Sub Total"."   ",'1',0,'R',0);
$pdf->Cell(12,5,number_format($total,2),'1',0,'R',0);

$pdf->Ln(5);


if($discr !=0)
{
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(48,5,"Disc (Rs)"."   ",'0',0,'R',0);
$pdf->Cell(12,5,number_format($discr,2),'1',1,'R',0);
$total -=$discr;
}

if($taxamt != 0)
{
	
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(48,5,"CGST ",'0',0,'R',0);
$pdf->Cell(12,5,number_format($taxamt/2,2),'1',1,'R',0);
$total +=$taxamt;
}

if($taxamt != 0)
{

$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(48,5,"SGST ",'0',0,'R',0);
$pdf->Cell(12,5,number_format($taxamt/2,2),'0',1,'R',0);

}
if($igstamt != 0)
{
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(48,5,"IGST ",'0',0,'R',0);
$pdf->Cell(12,5,number_format($igstamt,2),'0',1,'R',0);

$total +=$igstamt;
}
$roundval =round($total)-$total;
if($roundval !=0)
{
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(48,5,"Round"."   ",'1',0,'R',0);
$pdf->Cell(12,5,number_format($roundval,2),'0',1,'R',0);
}
$pdf->SetFont('Arial','b',8);
$pdf->SetX(5);
$pdf->Cell(48,5,"Net Total"."   ",'1',0,'R',0);
$pdf->Cell(12,5,number_format(round($total),2),'1',1,'R',0);
$pdf->Ln(1);
$pdf->SetFont('Arial','UB',7);
$pdf->SetX(5);
$pdf->Cell(50,5,'Term And Condition','0',1,'L',0);
//$pdf->Cell(50,5,$term_cond,'0',1,'L',0);
$pdf->SetFont('courier','b',6);
$pdf->SetX(1);
$pdf->MultiCell(70,5,$term_cond,1,'L',0);
$pdf->AutoPrint();
$pdf->Output();


?>
