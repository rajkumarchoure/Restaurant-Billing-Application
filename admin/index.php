<?php include("../adminsession.php");
$pagename = "index.php";
$module = "Dashboard";
$submodule = "Dashboard";


if($fromdate!="" && $todate!="")
{
	$fromdate = $cmn->dateformatusa($fromdate);
	$todate = $cmn->dateformatusa($todate);
	$crit .= " and  bills.billdate between '$fromdate' and '$todate'";
}	

$curr_date=date('Y-m-d');
$total_order=$cmn->getvalfield("bills","count(*)","billdate='$curr_date'"); 
$total_sell=$cmn->getvalfield("bills","count(*)","billdate='$curr_date'");
$total_unpaid = $cmn->getvalfield("bills","count(*)","billdate='$curr_date' && is_paid='0'");

//$total_completed=$cmn->getvalfield("bills","count(*)","billdate='$curr_date' && yh n='1'");
$product_count = $cmn->getvalfield("m_product","count(*)"," 1=1 ");
$expanse = $cmn->getvalfield("expanse","sum(exp_amount)"," 1=1 ");

$firstdate = date('Y-m-01');
$lastdate = date("Y-m-t", strtotime($curr_date));

$product_amt = $cmn->getvalfield("bills","sum(net_bill_amt)","billdate between '$firstdate' and '$lastdate'");
//$product_today_amt = $cmn->getvalfield("bills","sum(net_bill_amt)","billdate='$curr_date && is_paid='1' ");
//$total_sell = $cmn->getTotalsell($curr_date);
$today_sell = $cmn->getTodaysell($curr_date); 

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
        	<div class="contentinner content-dashboard">
            	<div class="alert alert-info">
                	<button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Welcome!</strong> This alert needs your attention, but it's not super important.
                </div><!--alert-->
                
                <div class="row-fluid">
                	<div class="span12">
                    
                    
                    
                      <ul class="widgeticons row-fluid">
                 
                        <li class="one_fifth"><a><small>&nbsp;</small><h1><?php echo $total_order; ?></h1><span>Today's Order</span></a></li>
<li class="one_fifth"><a><small>&nbsp;</small>
 <h1 style="color:#F00;"><?php echo $total_unpaid; ?> </h1>
  <span>Today's Unpaid Order</span></a> </li>
   
<li class="one_fifth"><a href="bill_report_list.php"><small>&nbsp;</small><h1 style="color:#090;"><?php echo "Rs.". round($product_amt); ?></h1><span>Total Sale</span></a></li>
                          <!-- <li class="one_fifth"><a href=""><small>&nbsp;</small><h1><?php echo "Rs.".$product_today_amt; ?></h1><span>Today's Sale</span></a></li>-->
                         <li class="one_fifth"><a href="master_product.php"><small>&nbsp;</small><h1 style="color:#090;"><?php echo $product_count; ?></h1><span>Total Menu Items</span></a></li></ul>                       
                        
                        <!--widgetcontent-->
                    
                    
                        
                        <br />
                        
                       <h4 class="widgettitle">Today's Transactions (<?php echo $cmn->dateformatindia($curr_date); ?>)</h4>
        <div class="row-fluid" >
          <div class="span12">
            <div class="widgetcontent">
              <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                  
                  <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><span class="icon-forward"></span>Todays Bills</a></li>
                                  
                  
                </ul>
                <div id="tabs-1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
                  <table class="table table-bordered" >
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
                        <th  class="head0">Customer Name </th>
                        <th  class="head0">Order Type</th> 
                        <th  class="head0">Bill Amt</th>
                        <th  class="head0">Cash</th>
                        <th  class="head0">Paytm</th>
                        <th  class="head0">Card</th>  
                        <th  class="head0">Balance</th>                                         
                        </tr>
                    </thead>
                    <tbody id="record">
                                <?php
									$slno = 1;
									$cash_amt = 0;
									$paytm_amt = 0;
									$card_amt = 0;
									$net_total = 0;
									$net_paid = 0;
									$net_bal = 0;
									//$total_cancelled_amt = 0;
									$sql_get = mysql_query("Select * from bills where billdate='$curr_date' order by billid desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{  //print_r($row_get); die;
										$table_no = $cmn->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");

										//check bill balance amt
										

										$balance = $row_get['net_bill_amt'] - $row_get['cash_amt'] - $row_get['paytm_amt'] - $row_get['card_amt'];

										$net_paid += ($row_get['cash_amt'] + $row_get['paytm_amt'] + $row_get['card_amt']);
										$net_total += $row_get['net_bill_amt'];
										$cash_amt += $row_get['cash_amt'];
										$paytm_amt += $row_get['paytm_amt'];
										$card_amt += $row_get['card_amt'];
										$net_bal += $balance;


										 if($balance >0){ $clsname = "alert-danger"; }
										 else
										 { $clsname = "alert-success"; }

									   ?>
                                        <tr class="<?php echo $clsname; ?>">
                                        <td style="text-align:center;"><?php echo $slno++; ?></td> 
                                        <td><?php echo $row_get['billnumber']; ?></td>
                                        <td style="text-align:center;"><?php echo $cmn->dateformatindia($row_get['billdate']); ?></td>
                                        <td style="text-align:center;"><?php echo $row_get['billtime']; ?></td>
                                        <td style="text-align:center;"><?php echo strtoupper($table_no); ?></td>
                                        <td style="text-align:center;"><?php echo $row_get['cust_name']; ?></td>
                                        <td style="text-align:center;"><?php echo strtoupper($row_get['parsal_status']); ?></td>
                                        <td style="text-align:right;"><?php echo number_format(round($row_get['net_bill_amt']),2); ?></td>
                                        <td style="text-align:right;"><?php echo number_format(round($row_get['cash_amt']),2); ?></td>
                                        <td style="text-align:right;"><?php echo number_format(round($row_get['paytm_amt']),2); ?></td>
                                         <td style="text-align:right;"><?php echo number_format(round($row_get['card_amt']),2); ?></td>
                   						 <td style="text-align:right;"><?php 
                   						 echo number_format(round($balance),2); ?></td>
                   						</tr>
				   					<?php 
				   					//$total_cash_bill += $row_get['net_bill_amt'];
									//$total_cash_rec += $row_get['rec_amt'];
									}?>
                    </tbody>
                </table>
                <br>
                <table class="table tab-content" style="font-size:16px;" >
                	<tr>
                        <td style="text-align:right;width:85%">Total Sale Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($net_total,2); ?></td>
                        </td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Cancelled Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($total_cancelled_amt,2); ?></td>
                        </td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Total Rec Amt :</td>
                        <td style="text-align:right;"><?php echo number_format($net_paid,2); ?></td>
                        </td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Balance Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($net_bal,2); ?></td>
                        </td>
                    </tr>	
                </table>
                </div>
                               
                
              </div>
              <!--#tabs-->
            </div>
          </div>
          <!--span8-->
          <!--span4-->
        </div>
                        
                    </div><!--span8-->
                    
                    
                    
                    <!--span4-->
                </div>
                
                <div class="row-fluid" style="display:none">
                	<div class="span12">
                    	<ul class="widgeticons row-fluid">
                        	 <!-- <li class="one_fifth"><a href="master_product.php"><small>&nbsp;</small><h1 style="color:#090;"><?php echo $product_count; ?></h1><span>Total Menu Items</span></a></li>-->
                        <li class="one_fifth"><a href="master_add_table.php"><img src="../img/gemicon/reports.png" alt="" /><span>Add Table</span></a></li>
             			<!-- <li class="one_fifth"><a href="master_pcat.php"><img src="../img/gemicon/location.png" alt="" ><span>Menu Heading</span></a></li>-->
                       <!--  <li class="one_fifth"><a href="master_product.php"><img src="../img/gemicon/edit.png" ><span>Menu Item</span></a></li>
                        <li class="one_fifth"><a href="in-entry.php"><img src="../img/gemicon/image.png"><span>Bill-Entry</span></a></li>
                        <li class="one_fifth"><a href="expanse.php"><img src="../img/gemicon/edit.png" ><span>Expanse Entry</span></a></li>
                        <li class="one_fifth"><a href="company_setting.php"><img src="../img/gemicon/image.png"><span>Company Setting</span></a></li>
                        <li class="one_fifth"><a href="changepassword.php"><img src="../img/gemicon/settings.png" alt=""><span>Change Password</span></a></li>-->
                        </ul>
                        
                        <br />
                        
                        
                        <!--widgetcontent-->
                        
                        
                        <!--widgetcontent-->
                        
                        
                    </div><!--span8-->
                    <!--span4-->
                </div>
                
                <div class="row-fluid">
                	<div class="span12">
                    	<ul class="widgeticons row-fluid">
                        	 <!--<li class="one_fifth"><a href="master_product.php"><small>&nbsp;</small><h1 style="color:#090;"><?php echo $product_count; ?></h1><span>Total Menu Items</span><br/></a></li>-->
                     
             			<!--<li class="one_fifth"><a href="master_pcat.php"><img src="../img/gemicon/location.png" alt="" ><span>Menu Heading</span></a></li>
                        <li class="one_fifth"><a href="master_product.php"><img src="../img/gemicon/edit.png" ><span>Menu Item</span></a></li>
                        <?php $firsttableid = $cmn->getvalfield("m_table","table_id","1=1 order by table_id limit 0,1"); ?>
                        <li class="one_fifth"><a href="in-entry.php?table_id=<?php echo $firsttableid; ?>"><img src="../img/gemicon/image.png"><span>Bill-Entry</span></a></li>
                        <li class="one_fifth"><a href="expanse.php"><img src="../img/gemicon/edit.png" ><span>Expanse Entry</span></a></li>
                        <li class="one_fifth"><a href="company_setting.php"><img src="../img/gemicon/image.png"><span>Company Setting</span></a></li>
                        <li class="one_fifth"><a href="changepassword.php"><img src="../img/gemicon/settings.png" alt=""><span>Change Password</span></a></li>
-->                        </ul>
                        
                      <br />
                        
                        
                        <!--widgetcontent-->
                        
                        
                        <!--widgetcontent-->
                        
                        
                    </div><!--span8-->
                    <!--span4-->
                </div><!--row-fluid-->
            </div><!--contentinner-->
        </div><!--maincontent-->
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
</div><!--mainwrapper-->
<script type="text/javascript">
jQuery(document).ready(function(){
								
		// basic chart
		var flash = [[0, 2], [1, 6], [2,3], [3, 8], [4, 5], [5, 13], [6, 8]];
		var html5 = [[0, 5], [1, 4], [2,4], [3, 1], [4, 9], [5, 10], [6, 13]];
			
		function showTooltip(x, y, contents) {
			jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5
			}).appendTo("body").fadeIn(200);
		}
	
			
		var plot = jQuery.plot(jQuery("#chartplace2"),
			   [ { data: flash, label: "Flash(x)", color: "#fb6409"}, { data: html5, label: "HTML5(x)", color: "#096afb"} ], {
				   series: {
					   lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },
					   points: { show: true }
				   },
				   legend: { position: 'nw'},
				   grid: { hoverable: true, clickable: true, borderColor: '#ccc', borderWidth: 1, labelMargin: 10 },
				   yaxis: { min: 0, max: 15 }
				 });
		
		var previousPoint = null;
		jQuery("#chartplace2").bind("plothover", function (event, pos, item) {
			jQuery("#x").text(pos.x.toFixed(2));
			jQuery("#y").text(pos.y.toFixed(2));
			
			if(item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
						
					jQuery("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);
						
					showTooltip(item.pageX, item.pageY,
									item.series.label + " of " + x + " = " + y);
				}
			
			} else {
			   jQuery("#tooltip").remove();
			   previousPoint = null;            
			}
		
		});
		
		jQuery("#chartplace2").bind("plotclick", function (event, pos, item) {
			if (item) {
				jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
				plot.highlight(item.series, item.datapoint);
			}
		});


		// bar graph
		var d2 = [];
		for (var i = 0; i <= 10; i += 1)
			d2.push([i, parseInt(Math.random() * 30)]);
			
		var stack = 0, bars = true, lines = false, steps = false;
		jQuery.plot(jQuery("#bargraph2"), [ d2 ], {
			series: {
				stack: stack,
				lines: { show: lines, fill: true, steps: steps },
				bars: { show: bars, barWidth: 0.6 }
			},
			grid: { hoverable: true, clickable: true, borderColor: '#bbb', borderWidth: 1, labelMargin: 10 },
			colors: ["#06c"]
		});
		
		// calendar
		jQuery('#calendar').datepicker();


});
</script>
</body>

</html>

