<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");


  $fromdate = $_GET['fromdate'];
  $todate = $_GET['todate'];

	$crit = " where 1 = 1 ";
	if($fromdate!="" && $todate!="")
	{
		 $fromdate1 = $fromdate;
		 $todate1    = $todate;
		$crit .= " and billdate between '$fromdate1' and '$todate1'";
	}

if(isset($_GET['billid']))
{
  $billid = addslashes($_GET['billid']);
  $height=$cmn->getvalfield("bill_details","count(*)","billid='$billid'");
  $pageheight = $height * 100;
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
		$this->SetFont('courier','b',12);
		//$this->Cell(60,0,$title2,0,0,'C');
		$this->MultiCell(60,0,"Bill Report",0,'C');
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
$title3 =  ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));
$title4 = "Mobile No: $mobile";
$pdf->SetTitle($title1);


if($billdate =='')
{
	//$billdate=date('d-m-Y h:i A');
	//$billdate=date('d-m-Y h:i A');
}

//$table_id   = $cmn->getvalfield("bills","table_id","billid='$billid'");

//$table_no = ucwords($cmn->getvalfield("m_table","table_no","table_id='$table_id'"));

//$tax1 = $cmn->getvalfield("bills","tax1","billid='$billid'");
//$tax2 = $cmn->getvalfield("bills","tax2","billid='$billid'");
//$tax3 = $cmn->getvalfield("bills","tax3","billid='$billid'");
//$is_parsal = $cmn->getvalfield("bills","is_parsal","billid='$billid'");


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak('off','0');
$pdf->SetFont('Arial','b',7);
$pdf->SetY(16);
$pdf->SetX(2);
$pdf->Cell(17,6,"From Date :",'0',0,'L',0);  
$pdf->SetFont('Arial','',7);
$pdf->Cell(17,6,$cmn->dateformatindia($fromdate1),'0',0,'L',0);  
$pdf->SetFont('Arial','b',7);
$pdf->Cell(12,6,"To Date :",'0',0,'L',0); 
$pdf->SetFont('Arial','',7);
$pdf->Cell(15,6, $cmn->dateformatindia($todate1),'0',1,'L',0);  



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
$pdf->Cell(43,5,'Bill No',0,0,'L',0);
$pdf->Cell(16,5,'Amount',0,1,'R',0);
//$pdf->Cell(10,5,'Qty',0,1,'R',0);
$pdf->SetWidths(array(43,16));
$pdf->SetAligns(array('L','C','R'));

$pdf->Ln(2);
//$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 
$total=0;
$grand_total = 0;
$slno = 1;
 	
$sql_get = mysql_query("Select * from bills $crit order by billid desc");
			while($row_get = mysql_fetch_assoc($sql_get))
			{
				$total=0;
			$billdate = $cmn->dateformatindia($row_get['billdate']);
			$total = $cmn->getTotalBillAmt($row_get['billid']);
			
			$taxamount=0;
			$tax1=0;
			$tax2=0;
			$tax3=0;
			
			$total = $cmn->getTotalBillAmt($row_get['billid']);
			$tax1=$row_get['tax1'];
			$tax2=$row_get['tax2'];
			$tax3=$row_get['tax3'];
			if($tax1 !=0)
			{
			$taxamount= ($total * $tax1)/100;
			$total +=$taxamount;
			}
			
			if($tax2 !=0)
			{
			$taxamount= ($total * $tax2)/100;
			$total +=$taxamount;
			}
			
			if($tax1 !=0)
			{
			$taxamount= ($total * $tax3)/100;
			$total +=$taxamount;
			}
			$grand_total = $grand_total+$total;
			
			$is_completed = $row_get['is_completed'];
			
			if($is_completed==0) 
			{
			 $is_completed = "Pending";
			}
			else
			{
				$is_completed = "Completed";
			}	
$pdf->SetFont('Arial','',7);
$pdf->SetDash(0,0); //5mm on, 5mm off
$pdf->SetX(2);
//$pdf->Cell(50,5,"$qty $unit_name $prodname $rate $amount",'0',1,'L',0);  
$pdf->Row(array($row_get['billnumber'],number_format(round($total),2)),1,1,'L',0); 
	
}
$pdf->SetFont('Arial','b',8);
$pdf->SetX(5);
$pdf->Cell(46,5,"Total Amount"."   ",'0',0,'R',0);
$pdf->Cell(12,5,number_format(round($grand_total),2),'1',0,'R',0);
$pdf->SetFont('Arial','',7);

$pdf->Ln(5);
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(50,5,'THANK YOU  FOR DINIG WITH US !!','0',0,'L',0);
$pdf->Ln(5);
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(50,5,'PLEASE COME AGIN..','0',0,'L',0);
$pdf->Ln(6);
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(50,5,'Soft. Developed By - Trinity Solution Raipur','0',0,'L',0);
$pdf->Ln(6);
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(50,5,'Contact No : 9770131555, 9039630604','0',0,'L',0);
$pdf->Ln(6);
$pdf->SetFont('Arial','',7);
$pdf->SetX(5);
$pdf->Cell(50,5,'Website : www.trinitysolutions.in','0',0,'L',0);


$pdf->Output();
?>                          	
<?php
mysql_close($db_link);
?>