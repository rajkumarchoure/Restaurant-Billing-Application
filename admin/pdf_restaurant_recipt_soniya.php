<?php
include("../adminsession.php");
require("../fpdf17/fpdf.php");
//require("../fpdf17/dash.php");
if(isset($_GET['billid']))
{
$billid = addslashes($_GET['billid']);
}

class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

	function Header()
	{
		global $title1,$title2,$title3;
		 // courier 25
		$this->SetFont('courier','',17);
		// Move to the right
		//$this->Cell(10);
		$this->SetY(7);
		$this->SetX(5);
		// Title
		$this->Cell(55,0,$title1,0,0,'C');
		$this->Ln(5);
		$this->SetX(5);
		$this->SetFont('courier','',11);
		$this->Cell(60,0,$title2,0,0,'C');
		 $this->Ln(5);
		 $this->SetX(5);
		$this->SetFont('courier','',11);
		$this->Cell(60,0,$title3,0,0,'C');
		 $this->Ln(3);
		
		
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

$pdf=new PDF_MC_Table('P', 'mm',array(65 ,115 ));
//$title1 = 
$pdf->SetTitle(title1);
$title1 = $cmn->getvalfield("company_setting","comp_name","1 = 1");
$title2 = ucwords($cmn->getvalfield("company_setting","address","1 = 1"));
$title3 =  ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));
$pdf->SetTitle($title1);

$billnumber = $cmn->getvalfield("bills","billnumber","billid='$billid'");
$billdate   = $cmn->getvalfield("bills","billdate","billid='$billid'");
$billtime   = $cmn->getvalfield("bills","billtime","billid='$billid'");
$table_id   = $cmn->getvalfield("bills","table_id","billid='$billid'");
$table_no = ucwords($cmn->getvalfield("m_table","table_no","table_id='$table_id'"));


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->SetX(30);
$pdf->Cell(30,6,"Date :". $cmn->dateformatindia($billdate).' '.$billtime,'0',0,'R',0);  
$pdf->Ln(7);
$pdf->SetFont('Arial','',9);
$pdf->SetX(2);
$pdf->Cell(30,6,"Table : $table_no",'0',0,'L',0);  

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,31,62,31);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,39,62,39);
$pdf->Ln(8);

//$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 
$total=0;
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

$pdf->SetFont('Arial','',9);
$pdf->SetX(5);
$pdf->Cell(50,6,"$qty $unit_name $prodname 	$amount",'0',1,'L',0);  

	$total +=$amount;

	}


//$pdf->Ln(4);
//$pdf->SetFont('Arial','',9);
//$pdf->SetX(5);

//$pdf->Cell(50,6,'5 bloody mary $40:75','0',0,'L',0);  
$pdf->Ln(4);

$pdf->Ln(10);
$pdf->SetFont('Arial','',9);
$pdf->SetX(5);
$pdf->Cell(50,6,"SUBTOTAL  $total",'0',0,'R',0);

$pdf->Ln(5);

$sql=mysql_query("select * from tax_setting where is_applicable=1");

while($row=mysql_fetch_assoc($sql))
{
$tax=0;
$tax_name= $row['tax_name'];
$tax= $row['tax'];
$taxamount=($total * $tax)/100;
$pdf->SetFont('Arial','',9);
$pdf->SetX(5);
$pdf->Cell(50,6,"$tax_name($tax)%  $taxamount",'0',1,'R',0);

}

$pdf->Ln(5);
$pdf->SetFont('Arial','',9);
$pdf->SetX(5);
$pdf->Cell(50,6,'Net Total $6.00','0',0,'R',0);

/*$pdf->Ln(5);
$pdf->SetFont('Arial','',9);
$pdf->SetX(5);
$pdf->Cell(50,6,'TOTAL DUE $6.00','0',0,'R',0);
$pdf->Ln(10);*/

$pdf->SetFont('Arial','',9);
$pdf->SetX(5);
$pdf->Cell(50,6,'THANK YOU  FOR DINIG WITH US !!','0',0,'L',0);
$pdf->Ln(5);
$pdf->SetFont('Arial','',9);
$pdf->SetX(5);
$pdf->Cell(50,6,'PLEASE COME AGIN..','0',0,'L',0);
$pdf->Output();
?>                          	
<?php
mysql_close($db_link);
?>