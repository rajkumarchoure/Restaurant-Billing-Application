<?php include("../adminsession.php");
$pagename = "tax_setting.php";
$module = "Add Tax";
$submodule = "Tax Setting";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "tax_setting";
$tblpkey = "tax_id";
if(isset($_GET['tax_id']))
$keyvalue = $_GET['tax_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$tax_name = test_input($_POST['tax_name']);
	$tax = test_input($_POST['tax']);
	$is_applicable = test_input($_POST['is_applicable']);
	
	
	//check Duplicate
	$check = check_duplicate($tblname,"tax_name = '$tax_name'");
	
	
	
		if($keyvalue == 0)
		{
			
			if($check > 0)
			{
			/*$dup = " Error : Duplicate Record";*/
			$dup="<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
			
			} 
			
			else {
			//insert
			$form_data = array('tax_name'=>$tax_name,'tax'=>$tax,'is_applicable'=>$is_applicable,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			dbRowInsert($tblname, $form_data);
			$action=1;
			$process = "insert";
			
			}
		}
		else
		{
			//update
			$form_data = array('tax_name'=>$tax_name,'tax'=>$tax,'is_applicable'=>$is_applicable,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
			dbRowUpdate($tblname, $form_data,"WHERE $tblpkey = '$keyvalue'");
			$keyvalue = mysql_insert_id();
			$action=2;
			$process = "updated";
		}
		
		//insert into log report
		$cmn->InsertLog($pagename, $module, $submodule, $tblname, $tblpkey, $keyvalue, $process);
		echo "<script>location='$pagename?action=$action'</script>";
	}










if(isset($_GET[$tblpkey]))
{
	 $btn_name = "Update";
	 //echo "SELECT * from $tblname where $tblpkey = $keyvalue";die;
	 $sqledit       = "SELECT * from $tblname where $tblpkey = $keyvalue";
	 $rowedit       = mysql_fetch_array(mysql_query($sqledit));
	 $tax_name    =  $rowedit['tax_name'];
	 $tax  =  $rowedit['tax'];
	 $is_applicable  =  $rowedit['is_applicable'];
	
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
                            <p>
                                <label>Tax Name <span class="text-error">*</span></label>
                                <label>Tax (in %) <span class="text-error">*</span></label>
                                <label>Is Applied <span class="text-error">*</span></label>
                            </p>
                            
                             <p>
                                <label> <input type="text" name="tax" id="tax" class="input-xxlarge" value="<?php echo $tax;?>" autofocus /> </label>
                               
                            </p>
                            
                            
                             <p>
                                <label>IS Applied</label>
                                <span class="field"> 
                                <select name="is_applicable" id="is_applicable" class="input-xxlarge ">
                            	<option value="">Choose One</option>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                                <script> document.getElementById('is_applicable').value='<?php echo $is_applicable; ?>'; </script>
                                 </span>
                            </p>
                     
                                               
                                
                             
                          <center> <p class="stdformbutton">
                                <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('tax_name,tax nu,is_applicable'); ">
								<?php echo $btn_name; ?></button>
                                <a href="master_item.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
                    </div>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_item.php" class="btn btn-info" target="_blank">
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
                            <th class="head0">Tax Name</th>
                            <th class="head0">Tax (in %)</th>
                            <th class="head0">Is Applied</th>
                            <th class="head0">Edit</th>
                            <th class="head0">Delete</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                               <?php
									$slno=1;
									$sql_get = mysql_query("select * from tax_setting where 1=1 order by tax_id desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$is_applicable =$row_get['is_applicable'];
										if($is_applicable==1)
										{
											$is_applicable="Yes";
										}
										else
										{
											$is_applicable="No";
										}
										
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $row_get['tax_name']; ?></td> 
                                                <td><?php echo $row_get['tax']; ?></td>  
                                                <td><?php echo $is_applicable; ?></td>  
                                                
                              					<td><a class='icon-edit' title="Edit" href='?tax_id=<?php echo  $row_get['tax_id'] ; ?>'></a></td>
                                                <td>
                                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['tax_id']; ?>);' style='cursor:pointer'></a>
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



</body>

</html>
