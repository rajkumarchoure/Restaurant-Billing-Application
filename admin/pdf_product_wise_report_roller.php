<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

$search_sql = "";
$crit = " where 1 = 1 ";
if($_GET['productid']!="")
{

	$productid = addslashes(trim($_GET['productid']));
	$crit .= " and  bill_details.productid='$productid'";
	
}
$fromdate = $_GET['fromdate'];
$todate = $_GET['todate'];

   if($fromdate!="" && $todate!="")
   {
		$fromdate = addslashes(trim($_GET['fromdate']));
		$todate = addslashes(trim($_GET['todate']));
		$crit .= " and billdate between '$fromdate' and '$todate'";
   } 


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

	function Header()
	{
		global $title1,$title2,$title3,$title4;
		 // courier 25
		$this->SetFont('courier','b',17);
		// Move to the right
		//$this->Cell(10);
		$this->SetY(7);
		$this->SetX(2);
		// Title
		$this->Cell(60,0,$title1,0,0,'C');
		$this->Ln(5);
		$this->SetX(2);
		$this->SetFont('courier','b',10);
		//$this->Cell(60,0,$title2,0,0,'C');
		$this->SetX(2);
		$this->MultiCell(60,0,"Product Wise Sale Report",0,'C');
		$this->Cell(-1);
		$this->SetFont('courier','b',8);
		//$this->Cell(95,5,"".$collect_from,0,0,'L');
		$this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');
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
// for dash nLine 
function SetDash($black=null, $white=null)
    {
        if($black!==null)
            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }
$pdf=new PDF_MC_Table('P', 'mm',array(65 ,$pageheight));
//$title1 = 
$pdf->SetTitle(title1);
$title1 = $cmn->getvalfield("company_setting","comp_name","1 = 1");
$title2 = ucwords($cmn->getvalfield("company_setting","address","1 = 1"));
$title3 = ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));
$mobile =$cmn->getvalfield("company_setting","mobile","1 = 1");
//$title3 =  ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));
$title4 = "Mobile No: $mobile";
$pdf->SetTitle($title1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak('off','0');
$pdf->SetFont('Arial','b',7);
$pdf->SetY(16);
$pdf->SetX(2);
$pdf->Cell(17,6,"From Date :",'0',0,'L',0);  
$pdf->SetFont('Arial','',7);
$pdf->Cell(17,6,$cmn->dateformatindia($fromdate),'0',0,'L',0);  
$pdf->SetFont('Arial','b',7);
$pdf->Cell(12,6,"To Date :",'0',0,'L',0); 
$pdf->SetFont('Arial','',7);
$pdf->Cell(15,6, $cmn->dateformatindia($todate),'0',1,'L',0);  

$pdf->SetFont('Arial','',9);
$pdf->SetX(2);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,24,62,24);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,33,62,33);
$pdf->Ln(6);

//$pdf->SetDash(1,1); //5mm on, 5mm off
//$pdf->Line(3,36,62,36);

//$pdf->SetDash(1,1); //5mm on, 5mm off
//$pdf->Line(3,96,62,96);


$pdf->SetFont('Arial','',8);
$pdf->SetX(2);
$pdf->SetDrawColor('255','255','255');
//$pdf->Cell(9,5,' Sno','0',0,'C',0);
$pdf->SetFont('Arial','b',8);
//$pdf->Cell(33,5,'Product Name',0,0,'L',0);
$pdf->Cell(11,5,'Qty',0,0,'C',0);
//$pdf->Cell(15,5,'Amount',0,1,'R',0);
$pdf->SetWidths(array(11));
$pdf->SetAligns(array('C'));

$pdf->Ln(2);
//$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 
$slno=1;

//echo "Select sum(bill_details.qty) as totqty, sum(bill_details.qty*bill_details.rate) as totamt, bill_details.productid ,bills.billdate from bill_details left join bills on bills.billid = bill_details.billid $crit group by bill_details.productid";die;
								    $sql_qr = "Select sum(bill_details.qty) as totqty, sum(bill_details.qty*bill_details.rate) as totamt, bill_details.productid ,bills.billdate from bill_details left join bills on bills.billid = bill_details.billid $crit group by bill_details.productid"; 
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
		
	$pdf->SetFont('Arial','',7);
	$pdf->SetDash(0,0); 
	$pdf->SetX(2);
	 
	$pdf->Row(array($prodname,$totqty,number_format(round($totamt,2))));
		
		}
$pdf->SetFont('Arial','b',8);
$pdf->SetX(5);
$pdf->Cell(46,5,"Total Amount"."   ",'0',0,'R',0);
$pdf->Cell(12,5,number_format(round($grand_tot),2),'1',0,'R',0);



$pdf->Output();
?>                          	
<?php
mysql_close($db_link);
?>