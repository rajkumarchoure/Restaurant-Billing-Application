<?php include("../adminsession.php");
$pagename = "master_shop.php";
$module = "Add Shop";
$submodule = "Shop Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_shop";
$tblpkey = "shop_id";
if(isset($_GET['shop_id']))
$keyvalue = $_GET['shop_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$shop_name = test_input($_POST['shop_name']);
	$telphone = test_input($_POST['telphone']);
	$address = test_input($_POST['address']);
	$enable="enable";
	
	//check Duplicate
	$check = check_duplicate($tblname,"shop_name = '$shop_name' && $tblpkey <> $keyvalue");
	
		
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
			$form_data = array('shop_name'=>$shop_name,'telphone'=>$telphone,'address'=>$address,
							   'status'=>$enable,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			dbRowInsert($tblname, $form_data);
			$action=1;
			$process = "insert";
			
			}
		
		else
		{
			//update
			$form_data = array('shop_name'=>$shop_name,'telphone'=>$telphone,'address'=>$address,
							   'status'=>$enable,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
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
	 $shop_name    =  $rowedit['shop_name'];
	 $telphone  =  $rowedit['telphone'];
	 $address  =  $rowedit['address'];
	
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
                                <label>Shop  Name <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="shop_name" id="shop_name" class="input-xxlarge" value="<?php echo $shop_name;?>" 
                                autofocus/></span>
                     </div>
                     	
                        <div class="lg-12 md-12 sm-12">
                        <label>Tel. No </label>
                        <span class="field"><input type="text" name="telphone" id="telphone" class="input-xxlarge" value="<?php echo $telphone;?>" 
                        autofocus/></span>
                        </div>
                        
                        <div class="lg-12 md-12 sm-12">
                        <label>Address </label>
                        <span class="field"><input type="text" name="address" id="address" class="input-xxlarge" value="<?php echo $address;?>" 
                        autofocus/></span>
                        </div>
                        
                                                         
                          <center> <p class="stdformbutton">
                                <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('shop_name'); ">
								<?php echo $btn_name; ?></button>
                                <a href="master_shop.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
                    </div>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_master_shop.php" class="btn btn-info" target="_blank">
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
                        	
                          	<th width="11%" class="head0 nosort">S.No.</th>
                            <th width="18%" class="head0">Shop Name</th>
                             <th width="19%" class="head0">Telephone no</th>
                              <th width="33%" class="head0">Address</th>
                            <th width="9%" class="head0">Edit</th>
                            <th width="10%" class="head0">Delete</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                               <?php
									$slno=1;
									$sql_get = mysql_query("select * from m_shop where 1=1 order by shop_id desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $row_get['shop_name']; ?></td> 
                                                 <td><?php echo $row_get['telphone']; ?></td> 
                                                  <td><?php echo $row_get['address']; ?></td>                                                 
                              					<td><a class='icon-edit' title="Edit" href='?shop_id=<?php echo  $row_get['shop_id'] ; ?>'></a></td>
                                                <td>
                                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['shop_id']; ?>);' style='cursor:pointer'></a>
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
