<?php include("../adminsession.php");
$pagename = "expense_entry.php";
$module = "Master";
$submodule = "Other Expense";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "expense_entry";
$tblpkey = "expense_entry_id";
if(isset($_GET['expense_entry_id']))
$keyvalue = $_GET['expense_entry_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
if(isset($_POST['submit']))
{
	$keyvalue = test_input($_POST['expense_entry_id']);
	$expen_date   =  $cmn->dateformatusa(test_input($_POST['expen_date']));
	$expense_id =  test_input($_POST['expense_id']);
	$amount =  test_input($_POST['amount']);
	$remark =  test_input($_POST['remark']);
	//check Duplicate
	$check = check_duplicate($tblname,"expense_id = '$expense_id' && $tblpkey <> $keyvalue");
			if($check > 0)
			{
			/*$dup = " Error : Duplicate Record";*/
			$dup="<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
			
			} 
			
			else {
			//insert
			
			if($keyvalue == 0)
		   {
			$form_data = array('expen_date'=>$expen_date,'expense_id'=>$expense_id,'remark'=>$remark,'amount'=>$amount,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
			dbRowInsert($tblname, $form_data);
			$action=1;
			$process = "insert";
			
			}
		else
		{
			//update
			$form_data = array('expen_date'=>$expen_date,'expense_id'=>$expense_id,'remark'=>$remark,'amount'=>$amount,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid);
			dbRowUpdate($tblname, $form_data,"WHERE $tblpkey = '$keyvalue'");
			$keyvalue = mysql_insert_id();
			$action=2;
			$process = "updated";
		}
		//insert into log report
		$cmn->InsertLog($pagename, $module, $submodule, $tblname, $tblpkey, $keyvalue, $process);
		echo "<script>location='$pagename?action=$action'</script>";
		
		}
		
	}
	
if($_GET['expense_entry_id'])
  {
	 $btn_name = "Update";
	$sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
	 $rowedit = mysql_fetch_array(mysql_query($sqledit));
	 $expense_id =  $rowedit['expense_id'];
	 $expen_date = $rowedit['expen_date'];
	 $amount = $rowedit['amount'];
	  $remark = $rowedit['remark'];
  }else
  {
	  $expen_date=date('Y-m-d');
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
                    <form class="stdform stdform2" method="post" action="">
                    <?php echo  $dup;  ?>
                       <div class="lg-12 md-12 sm-12">
                        <table id="mytable01" align="center" class="table table-bordered table-condensed">
                       <tr> 
                       <th>Expense Name</th>
                       <th>Expense Date</th>
                       <th>Amount</th>
                       <th>Remark</th>
                      </tr>
                      <tr> 
                       <td>
                       <select name="expense_id" id="expense_id" class="chzn-select">
						<option value="">Select Expense</option>
                        <?php $sql = mysql_query("select * from expense_head");
						while($row = mysql_fetch_assoc($sql))
						{?>  
                        <option value="<?php echo $row['expense_id']; ?>"><?php echo $row['expense_name']; ?></option>
                    <?php }    ?>                       
                       </select>
                       <script>document.getElementById('expense_id').value='<?php echo $row['expense_id']; ?>';</script>
                        </td>
                       
                      <td><input type="text" name="expen_date" id="expen_date" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $cmn->dateformatindia($expen_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                      <td><input type="text"  name="amount" id="amount"class="input-medium" value="<?php echo $amount;?>"></td>
                       <td><input type="text"  name="remark" id="remark"class="input-medium" value="<?php echo $remark;?>"></td>
                      <td> <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('expense_id,expen_date,amount,'); ">
								<?php echo $btn_name; ?></button>
                                <a href="master_session.php"  name="reset" id="reset" class="btn btn-success">Reset</a> </td>
                      </tr>
                       
                       </table>
                               
                     </div>
                     	     <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                         
                        </form>
                    </div>
                   <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_master_unit.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>-->
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
                            <th class="head0">Expense Name</th>
                            <th class="head0">Expense Date</th>
                            <th class="head0"> Amount</th>
                              <th class="head0">Remark</th>
                            <th width="9%" class="head0">Edit</th>
                            <th width="10%" class="head0">Delete</th>
                         </tr>
                    </thead>
                    <tbody>
                           </span>
                               <?php
									$slno=1;
									$sql_get = mysql_query("select * from expense_entry order by expense_entry_id desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$exp_name = $cmn->getvalfield("expense_head","expense_name","expense_id='$row_get[expense_id]'");
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $exp_name; ?></td> 
                                                 <td><?php echo $cmn->dateformatindia($row_get['expen_date']); ?></td>
                                                  <td><?php echo $row_get['amount']; ?></td>
                                                   <td><?php echo $row_get['remark']; ?></td>
                                        <td><a class='icon-edit' title="Edit" href='?expense_entry_id=<?php echo  $row_get['expense_entry_id'] ; ?>'></a></td>
                             <td> <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['expense_entry_id']; ?>);' style='cursor:pointer'></a></td>
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
		
		jQuery('#expen_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
</script>
</body>

</html>
