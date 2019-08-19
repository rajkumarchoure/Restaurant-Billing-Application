<?php include("../adminsession.php");
$pagename ="expanse_report.php";
$module = "Expanse Report";
$submodule = "Expanse Report List";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "expanse";
$tblpkey = "expanse_id";
if(isset($_GET['expanse_id']))
$keyvalue = $_GET['expanse_id'];
else
$keyvalue = 0;


$search_sql = "";
$crit = " where 1 = 1 ";
if(isset($_GET['search']))
{
	
	$fromdate = $_GET['fromdate'];
	$todate = $_GET['todate'];
	$ex_group_id=$_GET['ex_group_id'];
	
	if($fromdate!="" && $todate!="")
	{
		$fromdate1 = $cmn->dateformatusa($fromdate);
		$todate1 = $cmn->dateformatusa($todate);
		$crit .= " and exp_date between '$fromdate1' and '$todate1' ";
	}
	
	if($ex_group_id !='')
	{
		$crit.=" and  ex_group_id='$ex_group_id' ";	
	}
	
	
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
                    
                    <table align="center" class="table table-bordered table-condensed"  >
                    <tr>
                    	<th>Expense Group</th>
                        <th>From Date</th>
                        <th>To Date : </th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                    
                  
                    <td>
                    
                        <select name="ex_group_id" id="ex_group_id" style="width:80%;"  class="chzn-select">
                        <option value="">--Choose Categary--</option>
                        <?php
                        $sql=mysql_query("select * from m_expanse_group order by group_name");
                        while($row=mysql_fetch_assoc($sql))
                        {								
                        ?>
                        <option value="<?php echo $row['ex_group_id'];  ?>"> <?php echo $row['group_name']; ?></option>
                        <?php } ?>
                        </select>
                        <script> document.getElementById('ex_group_id').value='<?php echo $ex_group_id; ?>'; </script>
                                
                    
                    </td>
                    <td><input type="text" name="fromdate" id="fromdate" class="input-medium"  
                     value="<?php echo $fromdate; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                    
                    
                    <td><input type="text" name="todate" id="todate" class="input-medium" 
                     value="<?php echo $todate; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td> 
                    
                    <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('paytype');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="expanse_report.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    
                    
                        </form>
                    </div>
                   
                <!--widgetcontent-->
              
                <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_expanse_report.php?ex_group_id=<?php echo $ex_group_id; ?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>
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
                            <th class="head0" >Expanse Group</th>
                            <th class="head0" >Expanse Name</th>
                             <th class="head0">Expanse Date</th>
                            <th class="head0" >Expanse Amount</th>
                          
                           
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                                <?php
									$slno=1;
								
									$sql_get = mysql_query("Select * from expanse $crit order by expanse_id desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
											 
									
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                 <td><?php echo $cmn->getvalfield("m_expanse_group","group_name","ex_group_id ='$row_get[ex_group_id]'"); ?></td>
                                                 <td><?php echo $row_get['exp_name']; ?></td>
                                                <td><?php echo $cmn->dateformatindia($row_get['exp_date']); ?></td>
                                               <td><?php echo $row_get['exp_amount']; ?></td> 
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
		
		 jQuery(function() {
                //Datemask dd/mm/yyyy
                jQuery("#fromdate").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
                //Datemask2 mm/dd/yyyy
                jQuery("#todate").inputmask("mm-dd-yyyy", {"placeholder": "mm-dd-yyyy"});
                //Money Euro
                jQuery("[data-mask]").inputmask();
		 });
		</script>



</body>

</html>
