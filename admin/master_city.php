<?php include("../adminsession.php");
$pagename = "master_city.php";
$module = "Add City";
$submodule = "City Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "master_city";
$tblpkey = "city_id";
if(isset($_GET['city_id']))
$keyvalue = $_GET['city_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$city_name = test_input($_POST['city_name']);
	$pin_code = test_input($_POST['pin_code']);
	$state_id = test_input($_POST['state_id']);
	
	
	
	//check Duplicate
	$check = check_duplicate($tblname,"city_name = '$city_name' and $tblpkey <> '$keyvalue'");
	if($check > 0)
	{
		$dup = " Error : Duplicate Record";
	}
	else
	{
		if($keyvalue == 0)
		{
			//insert
			$form_data = array('city_name'=>$city_name,'state_id'=>$state_id,'pin_code'=>$pin_code,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			  dbRowInsert($tblname, $form_data);
			  $action=1;
			  $process = "insert";
		}
		else
		{
			//update
			$form_data = array('city_name'=>$city_name,'state_id'=>$state_id,'pin_code'=>$pin_code,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
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
	 $city_name    =  $rowedit['city_name'];
	 $state_id      = $rowedit['state_id'];
	 $pin_code      = $rowedit['pin_code'];
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
                                <label>City Name <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="city_name" id="city_name" class="input-xxlarge" value="<?php echo $city_name;?>" autofocus/></span>
                            </p>
                            
                             <p>
                                <label>Pin-Code <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="pin_code" id="pin_code" class="input-xxlarge" value="<?php echo $pin_code;?>"/></span>
                            </p>
                            
                            
                            
                            <p>
                                <label>State <span class="text-error">*</span></label>
                                <span class="field">
                                
                                <select name="state_id" id="state_id" class="input-xxlarge chzn-select">
                                        <option value="">-select-</option>
                                        <?php
                                        $sql = mysql_query("select state_id,count_id,state_name from master_state order by state_id desc");
                                        while($row = mysql_fetch_assoc($sql))
                                         {  
										   $count_id = $row['count_id'];
                                             
											 $count_name = $cmn->getvalfield("master_country","count_name","count_id = '$count_id' ");
                                            
                                        ?>
                                            <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']."( ".$count_name." ) "; ?></option>
                                        <?php
                                        }
                                        ?>
                                             </select>
                                             <script>document.getElementById("state_id").value="<?php echo $state_id;?>" ;</script>
                                
                                </span>
                            </p>
                            
                             <center> <p class="stdformbutton">
                                <button  type="submit" name="submit"class="btn btn-primary" onClick="return checkinputmaster('city_name,pin_code,state_id'); "><?php echo $btn_name; ?></button>
                                <button type="reset" class="btn">Reset</button>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
                    </div>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_city.php" class="btn btn-info" target="_blank"><span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span>
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
                            <th class="head0">City</th>
                            <th class="head0">State</th>
                             <th class="head0">Pin-Code</th>
                            <th class="head0">Edit / Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                      
                           </span></td>
                               <?php
											$slno=1;
											$sql_get = mysql_query("select * from master_city where 1=1 order by city_id desc");
											while($row_get = mysql_fetch_assoc($sql_get))
											{
											  $state_name = $cmn->getvalfield("master_state","state_name","state_id = '$row_get[state_id]' "); 
											   $count_id = $cmn->getvalfield("master_state","count_id","state_id = '$row_get[state_id]' ");
												$count_name = $cmn->getvalfield("master_country","count_name","count_id = '$count_id' ");
												
												?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $row_get['city_name'] ; ?></td>    
                                                <td><?php echo $state_name." ( ".$count_name." ) ";  ?></td>
                                                <td><?php echo $row_get['pin_code'] ; ?></td>  
                             
                              <td><a class='icon-edit' href='?city_id=<?php echo  $row_get['city_id'] ; ?>'></a>
                                                <a class='icon-remove' onclick='funDel(<?php echo  $row_get['city_id'] ; ?>);' style='cursor:pointer'></a></td>
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
    <!--footer-->

    
</div><!--mainwrapper-->

<script type="text/javascript">
    
 // $('#partyid').trigger('chosen:activate'); // for autofocus
 
</script>
</body>

</html>
