<?php include("../adminsession.php");
$pagename = "index.php";
$module = "Dashboard";
$submodule = "Dashboard";
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
                    
                    <div class="widgetcontent">
                            <div id="tabs">
                                <ul>
                                    <!--<li><a href="#tabs-1"><span class="icon-forward"></span> Add User</a></li>-->
                                    <li><a href="#tabs-1"><span class="icon-eye-open"></span> Master</a></li>
                                    <!--<li><a href="#tabs-3"><span class="icon-leaf"></span> Profile Setting</a></li>-->
                                </ul>
                                <div id="tabs-1">
                        <ul class="widgeticons row-fluid">
                        <li class="one_fifth"><a href="master_customer.php"><img src="../img/gemicon/users.png" ><span>Add Customer</span></a></li>
                        <li class="one_fifth"><a href="master_item.php"><img src="../img/gemicon/location.png" ><span>Add Item</span></a></li>
                        <li class="one_fifth"><a href="bill_entry.php"><img src="../img/gemicon/edit.png" ><span>Bill Entry</span></a></li>
                        <li class="one_fifth"><a href="bill_list.php"><img src="../img/gemicon/image.png"><span>Bill List</span></a></li>
                        <li class="one_fifth"><a href="bill_payment.php"><img src="../img/gemicon/reports.png"><span>Bill Payment</span></a></li>
                        <li class="one_fifth"><a href="master_user.php"><img src="../img/gemicon/calendar.png"><span>Add Users</span></a></li>
                        <li class="one_fifth"><a href="profile_setting.php"><img src="../img/gemicon/archive.png" alt=""><span>Edit Profile</span></a></li>
                        <li class="one_fifth"><a href="changepassword.php"><img src="../img/gemicon/settings.png" alt=""><span>Change Password</span></a></li>
                           
                            
                            
                            
                        </ul> 
                                    
                                    
                                    
                                    
                                    
                                </div>
                            </div><!--#tabs-->
                        </div>
                        
                        
                    	
                        
                        <br />
                        
                       
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
