<?php
include("../adminsession.php");
require("../fpdf181/fpdf.php");
require("../pdf_js.php");

if(isset($_GET['table_id']))
{	
	$table_id  = addslashes($_GET['table_id']);
	$billid  = addslashes($_GET['billid']);
	//update kot 
	$kotdate = date('Y-m-d'); 
	$kottime  = date('h:i A');
	
	/*$kotid = $cmn->getvalfield("kot_entry","kotid","table_id='$table_id' and billid=0 limit 0,1");
	if($kotid!='')
	{
		$lastkotid = $kotid;
	}
	else*/
	//{
		$sql_ins = "insert into kot_entry set kotdate = '$kotdate', kottime = '$kottime', table_id='$table_id', billid='$billid'";
		$res_ins = mysql_query($sql_ins);
		$lastkotid = mysql_insert_id();
	//}
	
	
	//die;
	//echo "update bill_details set kotid='$lastkotid' where table_id='$table_id' and billid='$billid' and kotid=0";
	mysql_query("update bill_details set kotid='$lastkotid' where table_id='$table_id' and billid='$billid' and kotid=0");
	
	$height = $cmn->getvalfield("bill_details","count(*)","kotid='$lastkotid'");
	$pageheight = 10 * 120;
}

class PDF_AutoPrint extends PDF_JavaScript
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
		$this->SetFont('courier','b',15);
		//$this->Cell(60,0,$title2,0,0,'C');
		$this->MultiCell(60,0,"KOT",0,'C');
		
		$this->Cell(-1);
		$this->SetFont('courier','b',8);
		//$this->Cell(95,5,"".$collect_from,0,0,'L');
		$this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');
		 //$this->Ln(1);
		 
	}
	
	//Printer
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

//$pdf=new PDF_MC_Table('P', 'mm',array(65 ,$pageheight));
$pdf = new PDF_AutoPrint('P', 'mm',array(65 ,$pageheight));
//$title1 = 
$pdf->SetTitle(title1);
$title1 = $cmn->getvalfield("company_setting","comp_name","1 = 1");
$title2 = ucwords($cmn->getvalfield("company_setting","address","1 = 1"));
$title3 = ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));
$mobile =$cmn->getvalfield("company_setting","mobile","1 = 1");
//$title3 =  ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));
$title4 = "Mobile No: $mobile";
$pdf->SetTitle($title1);


if($billdate =='')
{
	$billdate=date('d-m-Y h:i A');
}

//$table_id   = $cmn->getvalfield("bills","table_id","billid='$billid'");

$table_no = ucwords($cmn->getvalfield("m_table","table_no","table_id='$table_id'"));

//$tax1 = $cmn->getvalfield("bills","tax1","billid='$billid'");
//$tax2 = $cmn->getvalfield("bills","tax2","billid='$billid'");
//$tax3 = $cmn->getvalfield("bills","tax3","billid='$billid'");
//$is_parsal = $cmn->getvalfield("bills","is_parsal","billid='$billid'");


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak('off','0');
$pdf->SetFont('Arial','b',8);
$pdf->SetY(16);
$pdf->SetX(30);
$pdf->Cell(30,6,"Date :".$billdate,'0',0,'R',0);  
$pdf->Ln(7);
$pdf->SetFont('Arial','',9);
$pdf->SetX(2);
if($is_parsal == 0)
{
$pdf->Cell(10,6,"Table",'0',0,'L',0); 
$pdf->SetFont('Arial','b',9);
$pdf->Cell(25,6,"$table_no",'0',0,'L',0); 
}
else
{
$pdf->Cell(35,6,"Parcel",'0',0,'L',0); 	
}
$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,22,62,22);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,29,62,29);
$pdf->Ln(8);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,36,62,36);

//$pdf->SetDash(1,1); //5mm on, 5mm off
//$pdf->Line(3,96,62,96);


$pdf->SetFont('Arial','',8);
$pdf->SetX(2);
$pdf->SetDrawColor('255','255','255');
//$pdf->Cell(9,5,' Sno','0',0,'C',0);  
$pdf->Cell(38,5,'Particular',0,0,'L',0);
$pdf->Cell(11,5,'Unit',0,0,'C',0);
$pdf->Cell(10,5,'Qty',0,1,'R',0);
$pdf->SetWidths(array(38,11,10));
$pdf->SetAligns(array('L','C','R'));

$pdf->Ln(2);
//$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 
$total=0;
$totqty = 0;
$slno=1;
//echo "select * from bill_details where table_id=$table_id"; die;
	$sql_get = mysql_query("select * from bill_details where kotid='$lastkotid'");
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
$pdf->Row(array($prodname,$unit_name,$qty),1,1,'L',0); 

	$totqty +=$qty;
	}


$pdf->SetFont('Arial','b',8);
$pdf->SetX(5);
$pdf->Cell(46,5,"Total Qty"."   ",'0',0,'R',0);
$pdf->Cell(12,5,number_format($totqty,2),'1',0,'R',0);

$pdf->AutoPrint();
$pdf->Output();
?>                          	
<?php
mysql_close($db_link);
?>