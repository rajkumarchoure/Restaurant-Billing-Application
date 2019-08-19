<?php include("../adminsession.php");
$pagename ="bill_report_list.php";   
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
$crit = " where 1 = 1 ";
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
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                    
              
                    
                     <td><input type="text" name="fromdate" id="fromdate" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $cmn->dateformatindia($fromdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                   
                    
                    <td><input type="text" name="todate" id="todate" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php echo $cmn->dateformatindia($todate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                    
                    <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('fromdate');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="bill_report_list.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    </form>
                    </div>
                   
                <!--widgetcontent-->
                     
                      <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_bill_report.php?fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" class="btn btn-info" target="_blank">
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
                            <th  class="head0">Bill Date</th>
                            <th  class="head0">Bill Time</th>
                            <th  class="head0">Table</th>
                            <th  class="head0">Bill Amount</th>
                            <th  class="head0">Order Type</th>
                            <th  class="head0">IS Credit</th>
                             <th  class="head0">Paid Amt details</th>
                            <th  class="head0">RecAmt</th>
                            <th  class="head0">Settlement</th> 
                            <th  class="head0">Print Bill</th>
                            <th  class="head0">Cancel Bill</th>
                           <?php if($usertype=="admin") { ?> <th class="head0" >Delete</th>  <?php } ?>                         
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
                                <?php
									$slno=1;
									$subtotal=0;
									$tot_rec_amt = 0;
									//echo "Select * from bills $crit order by billid desc";die;
									$total_cancelled_amt = 0;
									$sql_get = mysql_query("Select * from bills $crit order by billid desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$table_no = $cmn->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");

										
									   ?> <tr> 
                                                <td style="text-align:center;"><?php echo $slno++; ?></td> 
                                                <td><?php echo $row_get['billnumber']; ?></td>
                                                <td style="text-align:center;"><?php echo $cmn->dateformatindia($row_get['billdate']); ?></td>
                                                <td style="text-align:center;"><?php echo $row_get['billtime']; ?></td>
                                                <td style="text-align:center;"><?php echo strtoupper($table_no); ?></td>
                                                <td style="text-align:right;"><?php echo number_format(round($row_get['net_bill_amt']),2); ?></td>
                                                <td style="text-align:center;"><?php echo strtoupper($row_get['parsal_status']); ?></td>
                                             	<td style="text-align:center;"><?php echo strtoupper($row_get['paymode']); ?></td>
                                                <td>
                                                    <?php echo "Cash: ".number_format($row_get['cash_amt'],2); ?><br>
                                                    <?php echo "Card: ".number_format($row_get['card_amt'],2); ?><br>
                                                    <?php echo "Paytm: ".number_format($row_get['paytm_amt'],2); ?><br>
                                                    <?php echo "Zomato: ".number_format($row_get['zomato'],2); ?><br>
                                                    <?php echo "Swiggy: ".number_format($row_get['swiggy'],2); ?>
                                                        
                                                </td>
                                                <td style="text-align:center;"><?php echo number_format($row_get['rec_amt'],2); ?></td>
                                                 <td><?php if($row_get['paymode']=='credit'){ ?><input type="button" name="is_completed" id="is_completed" value="Pay Amt" onClick="show_payment_modal('<?php echo $row_get['net_bill_amt']; ?>','<?php echo $row_get['billnumber']; ?>','<?php echo $table_no; ?>','<?php echo $row_get['table_id']; ?>','<?php echo $row_get['billid']; ?>');" class="btn btn-success" ><?php }?></td>
                                                 <td style="text-align:center;"><a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" class="btn btn-primary btn-xm" target="_blank" > Print Bill</a></td>
                                 <?php if($usertype=="admin") { ?>   
                                 <td style="text-align:center;">
                                 <?php
								 if($row_get['is_cancelled']==0)
								 {
								 ?>
                                 <a class='btn btn-danger' onclick='cancel_bill(<?php echo  $row_get['billid']; ?>,<?php echo  $row_get['is_paid']; ?>);' style='cursor:pointer'>Cancel</a>
                                 <?php
								 }
								 else echo "<code>Cancelled</code>";
								 ?>
                                 </td>
                                 <td style="text-align:center;"><a class='icon-remove' title="delete" onclick='funDel(<?php echo  $row_get['billid']; ?>);' style='cursor:pointer'></a></td>
												<?php } ?>
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
                                	<td>Cash Amt:<span style="color:#F00;">*</span></td>
                                    <td>
                                        <input type="text" name="cash_amt" id="cash_amt" onkeyup="cal_rec_amt();">
                                    </td>
                                </tr>
                                <tr >
                                    <td>Paytm Amt:<span style="color:#F00;">*</span></td>
                                    <td>
                                        <input type="text" name="paytm_amt" id="paytm_amt" style="width: 40%" placeholder="enter amt" onkeyup="cal_rec_amt();">
                                        <input type="text" name="paytm_trans_no" id="paytm_trans_no" style="width: 40%" placeholder="paytm trans. number">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Card Amt:<span style="color:#F00;">*</span></td>
                                    <td>
                                        <input type="text" name="card_amt" id="card_amt" style="width: 40%" placeholder="Enter amt" onkeyup="cal_rec_amt();" onkeypress='return allow_decimal(event);'>

                                        <input type="text" name="card_trans_number" id="card_trans_number" style="width: 40%" placeholder="Card number" >
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
                                	<td>Total Received</td>
                                    <td>
                                    	<input type="text" class="form-control" id="rec_amt" readonly="">
                                    	<br><span style="color: red;" id="error_rec"></span>
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
                           <input type="submit" id="getpaid" class="btn btn-primary" name="submit" value="Recive Payment" onClick="return rec_payment1();"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
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
	paymode = '';
	tran_no = jQuery('#tran_no').val();
	bank_name = jQuery('#bank_name').val();
	remarks = jQuery('#remarks').val();
	table_id = jQuery('#m_table_id').val();
	billid = jQuery('#m_billid').val();
	paytm_amt = jQuery('#paytm_amt').val();
    paytm_trans_no = jQuery('#paytm_trans_no').val();
    card_amt = jQuery('#card_amt').val();
    card_trans_number = jQuery('#card_trans_number').val();
    cash_amt = jQuery('#cash_amt').val();
    rec_amt = jQuery('#rec_amt').val();
    jQuery("#getpaid").attr("disabled", true);
    
    //alert(rec_amt);
	
	
	if(cash_amt =="" && paytm_amt =="" && card_amt =="")
	{
		alert("Enter Amount Atleast One Field");
		return false;
	}
		jQuery.ajax({
		  type: 'POST',
		  url: 'save_order_payment.php',
		  data: 'paymode=' + paymode +'&tran_no=' + tran_no + '&bank_name=' + bank_name + '&remarks=' + remarks + '&table_id=' + table_id + '&billid=' + billid + '&paytm_amt=' + paytm_amt + '&paytm_trans_no=' + paytm_trans_no + '&card_amt=' + card_amt + '&card_trans_number=' + card_trans_number + '&cash_amt=' + cash_amt + '&rec_amt=' + rec_amt,
		  dataType: 'html',
		  success: function(data){
			  //alert(data);
			  if(data > 0)
			  {
					location='in-entry.php?table_id='+table_id;
			  }
			  else{
				  alert("Error");
				  jQuery("#getpaid").attr("disabled", false);
			}
			  
		 }
	});//ajax close
			
}

hide_text_pay_options('');



function cancel_bill(billid,is_paid)
{
	//alert(billid);
	if(is_paid == 0)
	{
		var is_cancelled = confirm("Do you want to cancell this bill?");
		if(is_cancelled)
		{
			if(billid!="")
			{
				var cancel_remark = prompt("Enter Reson to cancell...");
				jQuery.ajax({
					  type: 'POST',
					  url: 'ajax_cancell_bill.php',
					  data: "billid=" + billid + '&cancel_remark=' +cancel_remark,
					  dataType: 'html',
					  success: function(data){
						  //alert(data);
						  if(data > 0)
						  {
								location='bill_report_list.php';
						  }
						  else{
							  alert("Error");
						}
						  
					 }
						
				});//ajax close
			}
		}
	}//outer if
	else
	alert('Order can not be cancelled after payment.');
}


function cal_rec_amt()
{
	rec_amt = 0;
	cash_amt = jQuery('#cash_amt').val();
	paytm_amt = jQuery('#paytm_amt').val();
	card_amt = jQuery('#card_amt').val();
	payment_amt = jQuery('#payment_amt').html();
	//alert(card_amt);

	if(cash_amt!='')
	{
		rec_amt += parseFloat(cash_amt);
	}
	if(paytm_amt!='')
	{
		rec_amt += parseFloat(paytm_amt);
	}
	if(card_amt!='')
	{
		rec_amt += parseFloat(card_amt);
	}

	if(rec_amt > parseFloat(payment_amt))
	{
		jQuery('#error_rec').html('Received amt can not more than bill amount');
		jQuery("#getpaid").attr("disabled", true);
	}
	else
	{
		jQuery('#error_rec').html('');
		jQuery("#getpaid").attr("disabled", false);
	}

	jQuery('#rec_amt').val(rec_amt);
	
}

</script>

</body>

</html>
