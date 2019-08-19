<?php include("../adminsession.php");
include("../fpdf17/fpdf.php");
$tblpkey = "dealerid";
$module = "Masters";
$keyvalue="";
class PDF extends FPDF
{
	function Header()
	{ 
	global $title1;
		$this->SetFont('courier','b',25);
		$this->Cell(85);
		$this->Cell(70,0,$title1,0,1,'C');
		$this->Ln(23);
	}
	function Footer()
	{ 
	    $this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
     }
}
$pdf = new PDF();
$title1 = "Dealer Details";
$pdf->SetTitle($title1);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$pdf->SetFont('Arial','B',15);
$pdf->Cell(30,8,' S.No','1',0,'L',0);   
$pdf->Cell(80,8,'Dealer Name',1,0,'L',0);
$pdf->Cell(60,8,'Mobile',1,0,'L',0);
$pdf->Cell(90,8,'Address',1,1,'L',0);



$slno=1;
$sql= "Select * from m_dealer order by dealerid";
$res=mysql_query($sql);
while($row=mysql_fetch_array($res))
{   
    $pdf->SetFont('Arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(30,8,$slno++,1,'0','L');
	$pdf->Cell(80,8,$row['dealer_name'],1,'0','L');
	$pdf->Cell(60,8,$row['mobile'],1,'0','L');
	$pdf->Cell(90,8,$row['address'],1,'1','L');
	
}
$pdf->Output();
?>

<?php
mysql_close($db_link);
?>


													







	
		


