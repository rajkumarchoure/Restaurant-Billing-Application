<?php include("../adminsession.php");
error_reporting(0);
$pagename ="bill_report.php";
$module = " Daywise Expanse Report";
$submodule = "Expanse Report List";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
if(isset($_GET['billid']))
$keyvalue = $_GET['billid'];
else
$keyvalue = 0;
$email_id = $cmn->getvalfield("company_setting","email_id","1 = '1'");
 $exp_date = date('Y-m-d');
 //$exp_date = "2017-06-15";
  $messege  = " <table width='100%' border='0' style='background:#BBE6F6; border:2px solid #F60;border-radius:10px;'>	
             <tr> 
            <th colspan='4' style='font-size:16px'><span style='font-size:24px;'>Day Wise Expanse Report</span></th>
			 
            </tr>
            </table>
            <table width='100%' border='0' style='background:#BBE6F6; border:2px solid #F60;border-radius:10px;'>
             <tr>
                 <th width='51'>S.No.</th> 
				  <th width='102'>Expanse Group</th> 
                 <th width='102'>Expanse Name</th> 
                 <th width='164'>Expanse Date</th> 
                <th width='239'>Total Expanse Amount</th> 
            </tr>";
			
           
			
            $slno=1;
			//echo "Select * from expanse where exp_date = '$exp_date'";die;
            	$sql_get = mysql_query("Select * from expanse where exp_date = '$exp_date'");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$group_name = $cmn->getvalfield("m_expanse_group","group_name","ex_group_id = '$row_get[ex_group_id]'");
										      $exp_amount = $row_get['exp_amount'];
											  //$exp_amount = number_format($exp_amount,2);
											  $exp_name = $row_get['exp_name'];
											 $exp_date = $cmn->dateformatindia($row_get['exp_date']);
											  $grand_total = $grand_total+$exp_amount;
											 $net_total = number_format($grand_total,2);
											   
											  
                                              $messege .="
            <tr>
                 
                  <td style='border:1px solid #900; font-weight:bold; padding:5px;' align='center'> $slno</td>
				    <td style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$group_name</td>
                   <td style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$exp_name</td>
                 <td style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$exp_date</td>
						<td style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$exp_amount</td>
                      
            </tr>";
			$slno++;
            }
			$messege .="<tr><td style='border:1px solid #900; font-weight:bold; padding:5px;' colspan='4' align='right'>Total</td><td  style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$net_total</td></tr>";
				$messege .="</table>";
				
		//echo $messege; die;		
					
$to= "$email_id";
	$subject ="Visitor Want To Contact:";
  $message = "
	        $messege;   	
		";
	        $headers  = 'MIME-Version: 1.0'."\r\n";
	        $headers .= 'Content-type: text/html;charset=iso-8859-1'."\r\n";
	        $headers .= "From: $email";
	
	          mail($to,$subject,$message,$headers);
	
	  
?>
