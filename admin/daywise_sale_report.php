<?php include("../adminsession.php");
error_reporting(0);
$pagename ="bill_report.php";
$module = "Sale Report";
$submodule = "Sale Report List";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
if(isset($_GET['billid']))
$keyvalue = $_GET['billid'];
else
$keyvalue = 0;

$email1= $cmn->getvalfield("company_setting","email1","1 = '1'");
$email2= $cmn->getvalfield("company_setting","email2","1 = '1'");
$email_id ="$email1, $email2";
 $billdate = date('Y-m-d');
 
 $cur_date=$cmn->dateformatindia($billdate);
 // $billdate = "2017-06-15";
  $messege  = " <table width='100%' border='0' style='background:#BBE6F6; border:2px solid #F60;border-radius:10px;'>	
             <tr> 
            <th colspan='4' style='font-size:16px'><span style='font-size:24px;'>Day Wise Sale Report For $cur_date </span></th>
			 
            </tr>
            </table>
            <table width='100%' border='0' style='background:#BBE6F6; border:2px solid #F60;border-radius:10px;'>
             <tr>
                 <th width='51'>S.No.</th> 
                 <th width='102'>Bill No</th> 
                 <th width='164'>Bill Date</th> 
                <th width='239'>Bill Amount</th> 
            </tr>";
			
           
			
            $slno=1;
		
			$grand_total=0;
            	$sql_get = mysql_query("Select * from bills where billdate = '$billdate'");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
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
									
											  $total = number_format(round($total),2);
											  $billnumber = $row_get['billnumber'];
											 $billdate = $cmn->dateformatindia($row_get['billdate']);
											 
											 
											 
											 
											 $grand_total = $grand_total+$total;
											  $net_total = number_format($grand_total,2);
											  
                                              $messege .="
            <tr>
                 
                  <td style='border:1px solid #900; font-weight:bold; padding:5px; text-align:center'> $slno</td>
                   <td style='border:1px solid #900; font-weight:bold; padding:5px; text-align:center'>$billnumber</td>
                 <td style='border:1px solid #900; font-weight:bold; padding:5px; text-align:center'>$billdate</td>
						<td style='border:1px solid #900; font-weight:bold; padding:5px;'align='right'>$total</td>
                      
            </tr>";
			$slno++;
            }
			$messege .="<tr><td style='border:1px solid #900; font-weight:bold; padding:5px;' colspan='3' align='right'>Total</td><td  style='border:1px solid #900; font-weight:bold; padding:5px;'align='right'>$net_total</td></tr>";
				$messege .="</table>";
				
			
					
 $to= "email_id";
	$subject ="Visitor Want To Contact:";
   $message = "
	        $messege   	
		"; 
	        $headers  = 'MIME-Version: 1.0'."\r\n";
	        $headers .= 'Content-type: text/html;charset=iso-8859-1'."\r\n";
	        $headers .= "From: $email";
			
			
		echo $message;			
			
	
	          mail($to,$subject,$message,$headers);
	
	    




?>
