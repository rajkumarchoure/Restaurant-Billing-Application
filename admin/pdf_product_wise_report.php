<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

  $fromdate = $_GET['fromdate'];
	 $todate = $_GET['todate'];
	  $productid = $_GET['productid'];
	$crit = " where 1 = 1 ";
	if($fromdate!="" && $todate!="")
	{
		$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
		$crit .= " and billdate between '$fromdate' and '$todate'";
	}

if($_GET['productid']!="")
{

$productid = addslashes(trim($_GET['productid']));
$crit .= " and  bill_details.productid='$productid'";

}


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

	function Header()
	{
		global $title1,$title2,$title3,$title4;
		 // courier 25
		$this->SetFont('courier','b',20);
		// Move to the right
		$this->Cell(95);
		// Title
		$this->Cell(10,0,$title1,0,0,'C');
		// Line break
		$this->Ln(6);
		// Move to the right
		$this->Cell(90);
		 // courier bold 15
		$this->SetFont('courier','b',11);
		$this->Cell(20,0,$title2,0,0,'C');
		  // Move to the right
		  $this->Ln(6);
		// Move to the right
		$this->Cell(15);
		  $this->SetX(7);
		 // courier bold 15
		$this->SetFont('courier','b',11);
		$this->Cell(20,0,$title3,0,0,'L');
		
		//$this->Ln(6);
		// Move to the right
		$this->Cell(150);
		 // courier bold 15
		$this->SetFont('courier','b',11);
		$this->Cell(20,0,$title4,0,0,'R');
		
		
		// Line break
		$this->Ln(15);
		
		$this->Cell(82);
		 // courier bold 15
	   
		
	    $this->SetX(16);
		$this->SetY(26);
		$this->SetFont('courier','b',10);
		$this->Cell(190,0,'',T,0,0,'C');
	     $this->Ln(2);
		
		$this->Cell(-1);
		$this->SetFont('courier','b',8);
		//$this->Cell(95,5,"".$collect_from,0,0,'L');
		$this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');
		 $this->Ln(1);
		 
	}
	  // Page footer
	function Footer()
	{
	// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8); 
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
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
}
?>
<?php
function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}
$pdf=new PDF_MC_Table();
$title1 = $cmn->getvalfield("company_setting","comp_name","1 = 1");
$pdf->SetTitle($title1);
$title2 = "Product Wise Sale Report";
$pdf->SetTitle($title2);
$fromdate = $cmn->dateformatindia($fromdate);
$todate = $cmn->dateformatindia($todate);
$title3= "From Sale Date: $fromdate"; 
$pdf->SetTitle($title3);
$title4= "To Sale Date: $todate"; 
$pdf->SetTitle($title4);

$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetX(8);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,6,' Sno','LTR',0,'L',0);  
$pdf->Cell(60,6,'Product Name',1,0,'L',0);
$pdf->Cell(50,6,'Total Qty',1,0,'L',0);
$pdf->Cell(70,6,'Total Amount',1,1,'R',0);



$pdf->SetX(5);
$pdf->SetAligns(array('L','L','L','R'));
$pdf->SetWidths(array(10,60,50,70));
$pdf->SetFont('Arial','',6);

$slno = 1;
$grand_tot=0;
  $sql_qr = "Select sum(bill_details.qty) as totqty, sum(bill_details.qty*bill_details.rate) as totamt, bill_details.productid from bill_details left join bills on bills.billid = bill_details.billid $crit group by bill_details.productid"; 
									$sql_get = mysql_query($sql_qr);
									$grand_tot = 0;
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$totqty = $row_get['totqty'];
										$totamt = $row_get['totamt'];
										$grand_tot += $totamt;
										$prod_qty = $cmn->getvalfield("bill_details","sum(qty)","productid='$row_get[productid]' and billid = '$row_get[billid]'");
										$prodname = $cmn->getvalfield("m_product","prodname","productid='$row_get[productid]'");
										$product_sale_amt = $cmn->get_product_wise_total_sale($row_get['productid']);
										
	$pdf->SetX(8);	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Row(array($slno++,$prodname,$totqty,number_format(round($totamt),2)));
	
	        }
			 
			
$pdf->SetX(8);
$pdf->SetFont('Arial','B',10);
//$pdf->Cell(10,5,'gg',1,0,'L',0);
//$pdf->Cell(40,5,'gg',1,0,'L',0);
$pdf->Cell(120,5,'Grand Total (Rs.): ',1,0,'R',0);
$pdf->Cell(70,5,number_format(round($grand_tot),2),1,1,'R',0);

$pdf->Output();
?> 
                          	
<?php
mysql_close($db_link);
?>