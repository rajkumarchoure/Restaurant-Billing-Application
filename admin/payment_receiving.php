<?php include("../adminsession.php");
$pagename ="payment_receiving.php";   
$module = "Payment Receiving Report";
$submodule = "Payment Report List";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
if(isset($_GET['billid']))
$keyvalue = $_GET['billid'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = $_GET['action'];
$search_sql = "";
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


if($_GET['paymode']!="")
$paymode = addslashes(trim($_GET['paymode']));
else
$paymode = "";


$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{
	$fromdate = $cmn->dateformatusa($fromdate);
	$todate = $cmn->dateformatusa($todate);
	$crit .= " and  bills.billdate between '$fromdate' and '$todate'";
}	


if($paymode!="")
{
	$crit .= " and  bills.paymode = '$paymode'";
}	
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
                    
                    <table id="mytable01" align="center" class="table table-bordered table-condensed"  >
                    <tr>
                       <th>From Date<span class="text-error">*</span></th>
                        <th>To Date<span class="text-error">*</span></th>
                        <th>Pay Mode</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                     <td><input type="text" name="fromdate" id="fromdate" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $cmn->dateformatindia($fromdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                    
                    <td><input type="text" name="todate" id="todate" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php echo $cmn->dateformatindia($todate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                    
                    <td>
                    <select id="paymode" name="paymode" class="form-control" >
                        <option value="">--All--</option>
                        <option value="cash">Cash</option>
                        <option value="checque">Cheque</option>
                        <option value="card">Card</option>
                        <option value="paytm">Paytm</option>
                        <option value="credit">Credit</option>
                    </select>
                    <script>
                    document.getElementById('paymode').value = '<?php echo $paymode; ?>';
                    </script>                  
                    </td>
                    
                    <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('fromdate');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="payment_receiving.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    
                    
                        </form>
                    </div>
                   
                <!--widgetcontent-->
                     
                      <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_payment_receiving.php?fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>&paymode=<?php echo $paymode; ?>" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>        
              
                
                <!--widgetcontent-->
                <h4 class="widgettitle"><?php echo $submodule; ?></h4>
                
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
                        	
                          	<th  width="7%" class="head0 nosort">S.No.</th>
                            <th  class="head0" >Bill No</th>
                            <th  class="head0" >Bill Date</th>
                            <th  class="head0" >Bill Time</th>
                            <th  class="head0" >Bill Amount</th>
                            <th  class="head0" >Customer</th>
                            <th  class="head0" >Mobile</th>
                            <th  class="head0" >Pay Date</th>
                            <th  class="head0" >Paymode</th>
                            <th  class="head0" >Rec Amt</th>
                           
                        </tr>
                    </thead>
                    <tbody id="record">
                                <?php
									$slno=1;
									$subtotal=0;
									$tot_rec_amt = 0;
									$total_cancelled_amt = 0;
									//echo "Select * from bills $crit order by billid desc";die;
									$sql_get = mysql_query("Select * from bills $crit order by billid desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$table_no = $cmn->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");
										
									   ?> <tr>
                                                <td style="text-align:center;"><?php echo $slno++; ?></td> 
                                                <td><?php echo $row_get['billnumber']; ?></td>
                                                <td style="text-align:center;"><?php echo $cmn->dateformatindia($row_get['billdate']); ?></td>
                                                <td style="text-align:center;"><?php echo $row_get['billtime']; ?></td>
                                                <td style="text-align:right;"><?php echo number_format(round($row_get['net_bill_amt']),2); ?></td>
                                                <td style="text-align:center;"><?php echo strtoupper($row_get['cust_name']); ?></td>
                                                <td style="text-align:center;"><?php echo strtoupper($row_get['cust_mobile']); ?></td>
                                                <td style="text-align:center;"><?php echo $cmn->dateformatindia($row_get['paydate']); ?></td>
                                                <td style="text-align:center;"><?php echo strtoupper($row_get['paymode']); ?></td>
                                                <td style="text-align:right;"><?php echo number_format(round($row_get['rec_amt']),2); ?></td>
                        					</tr>
								<?php
                                $subtotal += $row_get['net_bill_amt'];
                                $tot_rec_amt += $row_get['rec_amt'];
								
								if($row_get['is_cancelled'])
								$total_cancelled_amt += $row_get['net_bill_amt'];
								
								$net_balance = $subtotal - $total_cancelled_amt - $tot_rec_amt;
                                
                                }
						?>
                    </tbody>
                </table>
                
                 <br>
                <table class="table tab-content" style="font-size:16px;" >
                	<tr>
                        <td style="text-align:right;width:85%">Total Sale Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($subtotal,2); ?></td>
                        </td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Cancelled Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($total_cancelled_amt,2); ?></td>
                        </td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Total Rec Amt :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_rec_amt,2); ?></td>
                        </td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Balance Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($net_balance,2); ?></td>
                        </td>
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
<!--Payment modal-->
<div class="modal fade" id="payment_modal"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>Payment Entry</h4>
                    </div>
                        <div class="modal-body">
                        	<table class="table table-bordered">
                            	<tr>
                                	<td style="width:40%">Bill Number</td>
                                    <td id="payment_bill_number" style="font-weight:bold"></td>
                                </tr>
                                <tr>
                                	<td>Table Number</td>
                                    <td id="payment_table_no" style="font-weight:bold"></td>
                                </tr>
                                <tr>
                                	<td>Net Bill Amount</td>
                                    <td id="payment_amt" style="font-weight:bold"></td>
                                </tr>
                                 <tr >
                                	<td>Payment Mode <span style="color:#F00;">*</span></td>
                                    <td>
                                    	<select id="paymode" class="form-control" onChange="hide_text_pay_options(this.value)">
                                        	<option value="">--Select--</option>
                                        	<option value="cash">Cash</option>
                                            <option value="checque">Cheque</option>
                                            <option value="card">Card</option>
                                            <option value="paytm">Paytm</option>
                                        </select>
                                    </td>
                                </tr>
                                 <tr id="td_tran_no">
                                	<td>Checque No./ Trans.No.</td>
                                    <td>
                                    	<input type="text" class="form-control" id="tran_no">
                                    </td>
                                </tr>
                                 <tr id="td_bank_name">
                                	<td>Bank Name</td>
                                    <td>
                                    	<input type="text" class="form-control" id="bank_name">
                                    </td>
                                </tr>
                                 <tr>
                                	<td>Remark</td>
                                    <td>
                                    	<input type="text" class="form-control" id="remarks">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="payment_total"></span></h2>
                           <input type="submit" class="btn btn-primary" name="submit" value="Recive Payment" onClick="return rec_payment1();"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"   ><i class="fa fa-times"></i> Discard</button>
                           <input type="hidden" id="m_table_id" value="" >
                           <input type="hidden" id="m_billid" value="" >
                           
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div>

<script>
	function funDel(id)
	{  //alert(id);   
	

		tblname = '<?php echo $tblname; ?>';
		tblpkey = '<?php echo $tblpkey; ?>';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';
		fromdate = '<?php echo $cmn->dateformatindia($fromdate); ?>';
		todate = '<?php echo $cmn->dateformatindia($todate); ?>';
		// alert(fromdate); 
		if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_sale.php',
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				  //alert(pagename+'?action=3&fromdate='+fromdate+'&todate='+todate);
				   location=pagename+'?action=3&fromdate='+fromdate+'&todate='+todate;
				}
				
			  });//ajax close
		}//confirm close
	} //fun close

  </script>
    <script>
		
		 jQuery(function() {
                //Datemask dd/mm/yyyy
                jQuery("#fromdate").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
                //Datemask2 mm/dd/yyyy
                jQuery("#todate").inputmask("dd-mm-yyyy", {"placeholder": "mm-dd-yyyy"});
                //Money Euro
                jQuery("[data-mask]").inputmask();
		 });
		</script>

<script> 

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

function show_payment_modal(net_bill_amt,billnumber,table_no,table_id,bill_id)
{
	//alert('hi');
	net_bill_amt = parseFloat(net_bill_amt);
	net_bill_amt = net_bill_amt.toFixed(2);
	jQuery('#payment_bill_number').html(billnumber);
	jQuery('#payment_table_no').html(table_no);
	jQuery('#payment_amt').html(net_bill_amt);
	jQuery('#payment_total').html(net_bill_amt);
	jQuery('#m_table_id').val(table_id);
	jQuery('#m_billid').val(bill_id);
	
	jQuery('#payment_modal').modal('show');
	
}
function hide_text_pay_options(paymode)
{
	
	if(paymode == '')
	{
		jQuery('#td_tran_no').hide();
		jQuery('#td_bank_name').hide();
	}
	if(paymode == 'cash')
	{
		jQuery('#td_tran_no').hide();
		jQuery('#td_bank_name').hide();
	}
	
	if(paymode == 'checque' || paymode == 'card')
	{
		jQuery('#td_tran_no').show();
		jQuery('#td_bank_name').show();
	}
	
	if(paymode == 'paytm')
	{
		jQuery('#td_tran_no').show();
		jQuery('#td_bank_name').hide();
	}
}


function rec_payment1()
{
	paymode = jQuery('#paymode').val();
	tran_no = jQuery('#tran_no').val();
	bank_name = jQuery('#bank_name').val();
	remarks = jQuery('#remarks').val();
	table_id = jQuery('#m_table_id').val();
	billid = jQuery('#m_billid').val();
	paydate = jQuery('#paydate').val();
	
	if(paymode == "")
	{
		 alert('Please Select Payment Mode');
		 jQuery('#paymode').focus();
		 return false;
	}
	else
	{
		
			if(paymode == "")
	{
		 alert('Please Select Payment Mode');
		 jQuery('#paymode').focus();
		 return false;
	}
	else
	{
		if(paymode=="checque")
		{
			if(tran_no =="" || bank_name == "")
			{
				alert("Bank name or Checque no is mandatory, if paymode is checque.");
				return false;
			}
		}
		if(paymode=="card")
		{
			if(tran_no =="" || bank_name == "")
			{
				alert("Card Name and Transaction No is mandatory, if paymode is Card.");
				return false;
			}
		}
		if(paymode=="paytm")
		{
			if(tran_no =="")
			{
				alert("Transaction No is mandatory, if paymode is Paytm.");
				return false;
			}
		}
		
		
		
			jQuery.ajax({
			  type: 'POST',
			  url: 'save_order_payment.php',
			  data: "paymode=" + paymode + '&tran_no=' + tran_no + '&bank_name=' + bank_name + '&remarks=' + remarks + '&table_id=' + table_id + '&billid=' + billid,
			  dataType: 'html',
			  success: function(data){
				  //alert(data);
				  if(data > 0)
				  {
						location='in-entry.php?table_id='+table_id;
				  }
				  else{
					  alert("Error");
				}
				  
			 }
				
		});//ajax close
			
	}
	
	
}

hide_text_pay_options('');
</script>

</body>

</html>
