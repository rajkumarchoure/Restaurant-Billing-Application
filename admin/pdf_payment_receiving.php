<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");

$fromdate = $_GET['fromdate'];
$todate = $_GET['todate'];
$paymode = $_GET['paymode'];


$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{
	 $fromdate1 = $fromdate;
	 $todate1    = $todate;
	 $crit .= " and paydate between '$fromdate1' and '$todate1' ";
}


if($paymode!="")
{
	 $crit .= " and paymode = '$paymode' ";
}
	
	

class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

	function Header()
	{
		global $title1,$title2,$title3,$title4;
		 // courier 25
		 
		 $this->Rect('5','5','200','289');
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
	   
		
	   
		$this->SetY(26);
		$this->SetX(5);
		$this->SetFont('courier','b',10);
		$this->Cell(200,0,'',T,0,0,'C');
	    $this->Ln(2);
		
		$this->Cell(-1);
		$this->SetFont('courier','b',8);
		//$this->Cell(95,5,"".$collect_from,0,0,'L');
		$this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');
		$this->Ln(1);
		 
		$this->SetX(5);
		$this->SetFont('Arial','B',9);
		$this->Cell(10,5,' Sno','LTR',0,'L',0);  
		$this->Cell(20,5,'Bill Number',1,0,'L',0);
		$this->Cell(25,5,'Bill Date',1,0,'C',0);
		$this->Cell(20,5,'Time',1,0,'C',0);
		$this->Cell(25,5,'Table',1,0,'C',0);
		$this->Cell(25,5,'Status',1,0,'C',0);
		$this->Cell(25,5,'Paymode',1,0,'C',0);
		$this->Cell(25,5,'PayDate',1,0,'C',0);
		$this->Cell(25,5,'Total Amount',1,1,'R',0);
		
		$this->SetX(5);
		$this->SetAligns(array('L','C','C','C','C','C','C','C','R'));
		$this->SetWidths(array(10,20,25,20,25,25,25,25,25));
		$this->SetFont('Arial','',6);
        $this->SetX(5);
		 
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
if($paymode == "")
$paymode = "All Mode";
$title1 = $cmn->getvalfield("company_setting","comp_name","1 = 1");
$pdf->SetTitle($title1);
$title2 = "Payment Receiving Report (".strtoupper($paymode).")";
$pdf->SetTitle($title2);
$title3= "From Sale Date:".$cmn->dateformatindia($fromdate); 
$pdf->SetTitle($title3);
$title4= "To Sale Date: ".$cmn->dateformatindia($todate); 
$pdf->SetTitle($title4);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');

$slno = 1;
$subtotal = 0;
$total_cancelled_amt = 0;
 	//echo "Select * from bills $crit order by billid desc";die;
$sql_get = mysql_query("Select * from bills $crit order by billid desc");
while($row_get = mysql_fetch_assoc($sql_get))
{
	$total=0;
	$billdate = $cmn->dateformatindia($row_get['billdate']);
	$paydate = $cmn->dateformatindia($row_get['paydate']);
	$net_bill_amt = $row_get['net_bill_amt'];
	$billtime = $row_get['billtime'];
	$parsal_status = $row_get['parsal_status'];
	$paymode = $row_get['paymode'];
	$table_id = $row_get['table_id'];
	$paymode = $row_get['paymode'];
	$table_no = $cmn->getvalfield("m_table","table_no","table_id='$table_id'");
	$rec_amt  = $row_get['rec_amt'];
	$net_bill_amt = $row_get['net_bill_amt'];
	$taxamount=0;
	$grand_total = $grand_total + $rec_amt;
	$is_completed = $row_get['is_completed'];
	
	
	if($is_completed==0) 
	{
	 $is_completed = "Pending";
	}
	else
	{
		$is_completed = "Completed";
	}
	
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Row(array($slno++,$row_get['billnumber'],$billdate,$billtime,strtoupper($table_no),$parsal_status,$paymode,$paydate,number_format(round($rec_amt),2)));
 $subtotal += $row_get['net_bill_amt'];
 $tot_rec_amt += $row_get['rec_amt'];
 if($row_get['is_cancelled'])

$total_cancelled_amt += $row_get['net_bill_amt'];

$net_balance = $subtotal - $total_cancelled_amt - $tot_rec_amt;
                                
                                
}
			 
			
$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(175,5,'Total Sale Amount : ',1,0,'R',0);
$pdf->Cell(25,5,number_format($subtotal,2),1,1,'R',0);
$pdf->Ln(0);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(175,5,'Cancelled Amount: ',1,0,'R',0);
$pdf->Cell(25,5,number_format($total_cancelled_amt,2),1,1,'R',0);
$pdf->Ln(0);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(175,5,'Total Rec Amt: ',1,0,'R',0);
$pdf->Cell(25,5,number_format($tot_rec_amt,2),1,1,'R',0);
$pdf->Ln(0);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(175,5,'Balance Amount: ',1,0,'R',0);
$pdf->Cell(25,5,number_format($net_balance,2),1,1,'R',0);
$pdf->Output();

?> 
                          	
<?php
mysql_close($db_link);
?>