<?php include("../adminsession.php");
$pagename = "expanse.php";
$module = "Add Expense";
$submodule = "Expanse Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "expanse";
$tblpkey = "expanse_id";
if(isset($_GET['expanse_id']))
$keyvalue = $_GET['expanse_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$exp_name = test_input($_POST['exp_name']);
	$exp_date = $cmn->dateformatusa(test_input($_POST['exp_date']));
	$exp_amount = test_input($_POST['exp_amount']);
		$ex_group_id = test_input($_POST['ex_group_id']);
	
	$enable="enable";
	
	//check Duplicate
	$check = check_duplicate($tblname,"exp_name = '$exp_name' && $tblpkey <> $keyvalue");
	
		
			if($check > 0)
			{
			/*$dup = " Error : Duplicate Record";*/
			$dup="<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
			
			} 
			
			else {

            if($keyvalue == 0)
		     {
			//insert
			$form_data = array('ex_group_id'=>$ex_group_id,'exp_name'=>$exp_name,'exp_date'=>$exp_date,'exp_amount'=>$exp_amount,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			dbRowInsert($tblname, $form_data);
			$action=1;
			$process = "insert";
			
			}
		
		else
		{
			//update
			$form_data = array('ex_group_id'=>$ex_group_id,'exp_name'=>$exp_name,'exp_date'=>$exp_date,'exp_amount'=>$exp_amount,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
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


if(isset($_GET[$tblpkey]))
{
	 $btn_name = "Update";
	 //echo "SELECT * from $tblname where $tblpkey = $keyvalue";die;
	 $sqledit       = "SELECT * from $tblname where $tblpkey = $keyvalue";
	 $rowedit       = mysql_fetch_array(mysql_query($sqledit));
	 $exp_name    =  $rowedit['exp_name'];
	 $exp_date    =  $rowedit['exp_date'];
	 $exp_amount    =  $rowedit['exp_amount'];
	 $ex_group_id    =  $rowedit['ex_group_id'];
		
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
                                <label>Expanses Group <span class="text-error">*</span></label>
                                <span class="field">
                                <select name="ex_group_id" id="ex_group_id" style="width:74%;"  class="chzn-select">
                                	<option value="">--Choose Group--</option>
                                    <?php
									$sql=mysql_query("select * from m_expanse_group order by group_name");
									while($row=mysql_fetch_assoc($sql))
									{								
									?>
                                    <option value="<?php echo $row['ex_group_id'];  ?>"> <?php echo $row['group_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <script> document.getElementById('ex_group_id').value='<?php echo $ex_group_id; ?>'; </script>
                      </span>
                     </div>
                       <div class="lg-12 md-12 sm-12">
                                <label>Expanse  Name <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="exp_name" id="exp_name" class="input-xxlarge" value="<?php echo $exp_name;?>" 
                                autofocus autocomplete="off" placeholder="Enter Expanse Name" /></span>
                     </div>
                     
                       <div class="lg-12 md-12 sm-12">
                                <label>Expanse  Date <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="exp_date" id="exp_date" class="input-xxlarge" value="<?php echo $cmn->dateformatindia($exp_date);?>"  autofocus autocomplete="off" placeholder="dd-mm-yyyy"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></span>
                     </div>
                     
                     
                       <div class="lg-12 md-12 sm-12">
                                <label>Expanse  Amount <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="exp_amount" id="exp_amount" class="input-xxlarge" value="<?php echo $exp_amount;?>" 
                                autofocus autocomplete="off" placeholder="Enter Amount" /></span>
                     </div>
                            
                                                         
                          <center> <p class="stdformbutton">
                                <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('ex_group_id,exp_name,exp_date,exp_amount'); ">
								<?php echo $btn_name; ?></button>
                                <a href="expanse.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
                    </div>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_expanse.php" class="btn btn-info" target="_blank">
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
                             <th class="head0">Expanse Group</th>
                            <th class="head0">Expanse Name</th>
                            <th class="head0">Expanse Date</th>
                            <th class="head0">Expanse Amount</th>
                            <th class="head0">Edit</th>
                            <th class="head0">Delete</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                               <?php
									$slno=1;
									$sql_get = mysql_query("select * from expanse where 1=1 order by expanse_id desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$group_name = $cmn->getvalfield("m_expanse_group","group_name","ex_group_id = '$row_get[ex_group_id]'");
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                 <td><?php echo $group_name; ?></td>
                                                <td><?php echo $row_get['exp_name']; ?></td> 
                                                <td><?php echo $cmn->dateformatindia($row_get['exp_date']); ?></td> 
                                                <td><?php echo $row_get['exp_amount']; ?></td>                                                 
                              					<td><a class='icon-edit' title="Edit" href='?expanse_id=<?php echo  $row_get['expanse_id'] ; ?>'></a></td>
                                                <td>
                                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['expanse_id']; ?>);' style='cursor:pointer'></a>
                                                </td>
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
                jQuery("#exp_date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});               
                jQuery("[data-mask]").inputmask();
		 });
		</script>

</body>

</html>
