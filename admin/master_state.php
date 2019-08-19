<?php include("../adminsession.php");
$pagename = "master_state.php";
$module = "Add State";
$submodule = "State Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "master_state";
$tblpkey = "state_id";
if(isset($_GET['state_id']))
$keyvalue = $_GET['state_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$state_name = test_input($_POST['state_name']);
	$count_id = test_input($_POST['count_id']);
	
	
	
	//check Duplicate
	$check = check_duplicate($tblname,"state_name = '$state_name' and $tblpkey <> '$keyvalue'");
	if($check > 0)
	{
		$dup = " Error : Duplicate Record";
	}
	else
	{
		if($keyvalue == 0)
		{
			//insert
			$form_data = array('state_name'=>$state_name,'count_id'=>$count_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			  dbRowInsert($tblname, $form_data);
			  $action=1;
			  $process = "insert";
		}
		else
		{
			//update
			$form_data = array('state_name'=>$state_name,'count_id'=>$count_id,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
			dbRowUpdate($tblname, $form_data,"WHERE $tblpkey = '$keyvalue'");
			 $keyvalue = mysql_insert_id();
			$action=2;
			$process = "updated";
		}
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
	 $state_name    =  $rowedit['state_name'];
	 $count_id      = $rowedit['count_id'];
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
                    
                    

                            <p>
                                <label>State Name <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="state_name" id="state_name" class="input-xxlarge" value="<?php echo $state_name;?>" autofocus/></span>
                            </p>
                            
                            
                            
                            <p>
                                <label>Country <span class="text-error">*</span></label>
                                <span class="field">
                                
                                <select name="count_id" id="count_id" class="input-xxlarge chzn-select">
                                                <option value="">-select-</option>
                                                <?php
												$sql = mysql_query("select count_id,count_name from master_country order by count_id desc");
												while($row = mysql_fetch_assoc($sql))
												{
												?>
                                                	<option value="<?php echo $row['count_id']; ?>"><?php echo $row['count_name']; ?></option>
                                                <?php
												}
												?>
                                             </select>
                                             <script>document.getElementById("count_id").value="<?php echo $count_id;?>" ;</script>
                                
                                </span>
                            </p>
                            
                          <center> <p class="stdformbutton">
                                <button  type="submit" name="submit"class="btn btn-primary" onClick="return checkinputmaster('state_name,count_id'); "><?php echo $btn_name; ?></button>
                                <button type="reset" class="btn">Reset</button>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
                    </div>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_state.php" class="btn btn-info" target="_blank"><span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span>
</a></p>
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
                            <th class="head0">State</th>
                            <th class="head0">Country</th>
                            <th class="head0">Edit / Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                      
                           </span></td>
                               <?php
									$slno=1;
									$sql_get = mysql_query("select * from master_state where 1=1 order by state_id desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $row_get['state_name'] ; ?></td>    
                                               <td><?php echo $cmn->getvalfield("master_country","count_name","count_id = '$row_get[count_id]' "); ; ?></td>
                             
                              <td><a class='icon-edit' title="Edit" href='?state_id=<?php echo  $row_get['state_id'] ; ?>'></a>
                                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['state_id']; ?>);' style='cursor:pointer'></a></td>
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



</body>

</html>
