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
  $messege  = " <table width='100%' border='0' style='background:#BBE6F6; border:2px solid #F60;border-radius:10px;'>	
             <tr> 
            <th colspan='4' style='font-size:16px'><span style='font-size:24px;'>Day Wise Expanse Report</span></th>
			 
            </tr>
            </table>
            <table width='100%' border='0' style='background:#BBE6F6; border:2px solid #F60;border-radius:10px;'>
             <tr>
                 <th width='51'>S.No.</th> 
                 <th width='102'>Expanse Name</th> 
                 <th width='164'>Expanse Date</th> 
                <th width='239'>Total Expanse Amount</th> 
            </tr>";
			
           
			
            $slno=1;
			//echo "Select * from expanse where exp_date = '$exp_date'";die;
            	$sql_get = mysql_query("Select * from expanse where exp_date = '$exp_date'");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
											  $exp_amount = $row_get['exp_amount'];
											  // $exp_amount = number_format($exp_amount,2);
											  $exp_name = $row_get['exp_name'];
											 $exp_date = $cmn->dateformatindia($row_get['exp_date']);
											  $grand_total = $grand_total+$exp_amount;
											 // $grand_total = number_format($grand_total,2);
											   
											  
                                              $messege .="
            <tr>
                 
                  <td style='border:1px solid #900; font-weight:bold; padding:5px;' align='center'> $slno</td>
                   <td style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$exp_name</td>
                 <td style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$exp_date</td>
						<td style='border:1px solid #900; font-weight:bold; padding:5px;'align='center'>$exp_amount</td>
                      
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
	
	     // echo "<script>location='daywise_expanse_report.php</script>";




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
                    <?php  $exp_date = date('Y-m-d');?>
                    <table align="center" class="table table-bordered table-condensed"  >
                    <tr>
                    	
                        <th> Date</th>
                        
                    </tr>
                    <tr>
                    
                  
                    
                    <td><input type="date" name="exp_date" id="exp_date" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php echo $cmn->dateformatindia($exp_date); ?>"/> </td>
                    
                  
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
                            <th class="head0" >Expanse Name</th>
                             <th class="head0">Expanse Date</th>
                            <th class="head0" >Expanse Amount</th>
                            
                           
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                                <?php
								
									$slno=1;
								//	echo "Select * from expanse where exp_date = '$exp_date'";die;
									$sql_get = mysql_query("Select * from expanse where exp_date = '$exp_date'");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
											  $exp_amount = $row_get['exp_amount'];	
											  $exp_name = $row_get['exp_name']
									
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                 <td><?php echo $row_get['exp_name']; ?></td>
                                                <td><?php echo $cmn->dateformatindia($row_get['exp_date']); ?></td>
                                                <td><?php echo $exp_amount; ?></td>
                                             	
                                                 
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
