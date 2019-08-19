<?php include("../adminsession.php");
$pagename ="bill_report.php";
$module = "Product Wise Sale Report";
$submodule = "Product Wise Sale List";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
if(isset($_GET['billid']))
$keyvalue = $_GET['billid'];
else
$keyvalue = 0;

$search_sql = "";
$crit = " where 1 = 1 ";
if($_GET['productid']!="")
{

$productid = addslashes(trim($_GET['productid']));
$crit .= " and  bill_details.productid='$productid'";

}

if($_GET['fromdate']!="" && $_GET['todate']!="")
{
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
}
else
{
	$fromdate = date('d-m-Y');
	$todate = date('d-m-Y');
}


if($fromdate!="" && $todate!="")
{
	$fromdate = $cmn->dateformatusa($fromdate);
	$todate = $cmn->dateformatusa($todate);
	$crit .= " and  bills.billdate between '$fromdate' and '$todate'";
}
	
	

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
 <script>
 jQuery(function() {
		//Datemask dd/mm/yyyy
		jQuery("#fromdate").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
		//Datemask2 mm/dd/yyyy
		jQuery("#todate").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
		//Money Euro
		jQuery("[data-mask]").inputmask();
 });
</script>
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
                    
                    <table id="mytable01" align="center" class="table table-bordered table-condensed"  >
                    <tr>
                    	
                        <th>From Date :</th>
                        <th>To Date : </th>
                        <th>Product Name</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                    
                 
                    
                     <td><input type="text" name="fromdate" id="fromdate" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $cmn->dateformatindia($fromdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                   
                    
                    <td><input type="text" name="todate" id="todate" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php  echo $cmn->dateformatindia($todate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                    <td><select name="productid" id="productid" style="width:80%;"  class="chzn-select">
                                	<option value="">--Choose Product--</option>
                                    <?php
									$sql=mysql_query("select * from m_product order by prodname");
									while($row=mysql_fetch_assoc($sql))
									{								
									?>
                                    <option value="<?php echo $row['productid'];  ?>"> <?php echo $row['prodname']; ?></option>
                                    <?php } ?>
                                </select>
                                <script> document.getElementById('productid').value='<?php echo $productid; ?>'; </script>
                     </td>
                    <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('paytype');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="product_wise_report.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    
                    
                        </form>
                    </div>
                   
                <!--widgetcontent-->
              
                <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_product_wise_report.php?fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>&productid=<?php echo $productid;?>" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a>  &nbsp; <a href="pdf_product_wise_report_roller.php?fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>&productid=<?php echo $productid;?>" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print Roller PDF</span></a></p>
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
                        	
                          	<th width="7%" class="head0 nosort">S.No.</th>
                            <th width="16%" class="head0" >Product Name</th>
                             <th width="16%" class="head0" >Date</th>
                             <th width="11%" class="head0" style="text-align:right">Total Qty</th>
                            <th width="11%" class="head0" style="text-align:right">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody id="record">
                                <?php
									$slno=1;
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
										
									   ?>  <tr>
                                                    <td><?php echo $slno++; ?></td> 
                                                    <td><?php echo $prodname; ?></td>
                                                   <td><?php echo $cmn->dateformatindia($row_get['billdate']); ?></td>
                                                    <td style="text-align:right"><?php echo $totqty; ?></td>
                                                    <td style="text-align:right"><?php echo number_format(round($totamt),2); ?></td>
                        					</tr>
									<?php
                                    }
                                    ?>
                    </tbody>
                </table>
                <table style="width:100%;font-size:16px;" class="alert-danger">
                <tr>
                                    	<td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    	<td style="text-align:right;">Total: <?php echo number_format(round($grand_tot),2); ?></td>
                                    </tr>
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




function changestatus(billid,is_completed)
{

var crit="<?php echo $crit; ?>";
	
	//alert(crit);
	if(confirm("Do You want to Update this record ?"))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax_update_order.php',
			  data: "billid="+billid+'&crit='+crit+'&is_completed='+is_completed,
			  dataType: 'html',
			  success: function(data){
				//alert(data);
				 // jQuery('#record').html(data);
					arr = data.split("|");						
					status =arr[0].trim(); 
					count_product = arr[1].trim();
					
					//alert(status);
					
					if(status==1)
					{
						curr_status="Completed";
					}
					else
					{
						curr_status="Pending";
					}
					
					jQuery('#status'+billid).html(curr_status);
				 
				}
				
			  });//ajax close
		}//confirm close
}

</script>

</body>

</html>
