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
$email_id = $cmn->getvalfield("company_setting","email_id","1 = '1'");
 $billdate = date('Y-m-d');
  $messege  = " <table width='100%' border='0' style='background:#BBE6F6; border:2px solid #F60;border-radius:10px;'>	
             <tr> 
            <th colspan='4' style='font-size:16px'><span style='font-size:24px;'>Day Wise Sale Report</span></th>
			 
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
			//echo "Select * from bills where billdate = '$billdate'";die;
            	$sql_get = mysql_query("Select * from bills where billdate = '$billdate'");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
											  $total = $cmn->getTotalBillAmt($row_get['billid']);
											  $total = number_format($total,2);
											  $billnumber = $row_get['billnumber'];
											 $billdate = $cmn->dateformatindia($row_get['billdate']);
											 $grand_total = $grand_total+$total;
											  $grand_total = number_format($grand_total,2);
											  
                                              $messege .="
            <tr>
                 
                  <td style='border:1px solid #900; font-weight:bold; padding:5px;'> $slno</td>
                   <td style='border:1px solid #900; font-weight:bold; padding:5px;'>$billnumber</td>
                 <td style='border:1px solid #900; font-weight:bold; padding:5px;'>$billdate</td>
						<td style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$total</td>
                      
            </tr>";
			$slno++;
            }
			$messege .="<tr><td style='border:1px solid #900; font-weight:bold; padding:5px;' colspan='3' align='right'>Total</td><td  style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$grand_total</td></tr>";
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
	
	     // echo "<script>location='daywise_sale_report.php</script>";




?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
</head>

<body>

<div class="mainwrapper">
	
    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
    
    <!-- START OF RIGHT PANEL -->
    
   <div class="rightpanel">
    	<?php include("inc/header.php"); ?>
        
        <div class="maincontent">
        	<div class="contentinner">
              <?php include("../include/alerts.php"); ?>
            	<!--widgetcontent-->        
                <div class="widgetcontent  shadowed nopadding">
                    <form class="stdform stdform2" method="get" action="">
                    <?php  $billdate = date('Y-m-d');?>
                    <table align="center" class="table table-bordered table-condensed"  >
                    <tr>
                    	
                        <th> Date</th>
                        
                    </tr>
                    <tr>
                    
                  
                    
                    <td><input type="date" name="billdate" id="billdate" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php echo $cmn->dateformatindia($billdate); ?>"/> </td>
                    
                  
                    </tr>
                    </table>
                    
                    
                        </form>
                    </div>
                   
                <!--widgetcontent-->
              
               
                <!--widgetcontent-->
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
            	<table class="table table-bordered" id="dyntable">
                    <colgroup>
                        <col class="con0" style="align: center; width: 4%" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr>
                        	
                          	<th class="head0 nosort">S.No.</th>
                            <th class="head0" >Bill No</th>
                             <th class="head0">Bill Date</th>
                            <th class="head0" >Bill Amount</th>
                            <th class="head0" >Print Bill</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                                <?php
								
									$slno=1;
									//echo "Select * from bills where billdate = '$billdate'";die;
									$sql_get = mysql_query("Select * from bills where billdate = '$billdate'");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
											  $total = $cmn->getTotalBillAmt($row_get['billid']);
									
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                 <td><?php echo $row_get['billnumber']; ?></td>
                                                <td><?php echo $cmn->dateformatindia($row_get['billdate']); ?></td>
                                                <td><?php echo $total; ?></td>
                                             	 <td><a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" class="btn btn-primary btn-xm" target="_blank" > Print Bill</a></td>
                                                 
                        					</tr>
                        <?php
						}
						?>
                        
                        
                    </tbody>
                </table>
             
                
               
            </div><!--contentinner-->
        </div><!--maincontent-->
        
   
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
</div><!--mainwrapper-->
<script>
	function funDel(id)
	{  //alert(id);   
		tblname = '<?php echo $tblname; ?>';
		tblpkey = '<?php echo $tblpkey; ?>';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';
		 //alert(module); 
		if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close

  </script>

<script> 
//below code for date mask
jQuery(function($){
   $("#fromdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
    
});
</script>

</body>

</html>
