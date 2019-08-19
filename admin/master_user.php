<?php include("../adminsession.php");
$pagename = "master_user.php";
$module = "Add User";
$submodule = "User Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "user";
$tblpkey = "userid";
if(isset($_GET['userid']))
$keyvalue = $_GET['userid'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']);
	$usertype = test_input($_POST['usertype']);
	$enable="enable";

	//check Duplicate
	$check = check_duplicate($tblname,"username = '$username' && $tblpkey <> $keyvalue");
	
		
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
			$form_data = array('username'=>$username,'password'=>$password,'usertype'=>$usertype,							   
							   'enable'=>$enable,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			dbRowInsert($tblname, $form_data);
			$action=1;
			$process = "insert";
			
			}
		
		else
		{
			//update
			$form_data = array('username'=>$username,'password'=>$password,'usertype'=>$usertype,							   
							   'enable'=>$enable,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
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
	 $sqledit       = "SELECT * from $tblname where $tblpkey = $keyvalue";
	 $rowedit       = mysql_fetch_array(mysql_query($sqledit));
	 $username    =  $rowedit['username'];
	 $password    =  $rowedit['password'];
	 $usertype    =  $rowedit['usertype'];
			
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
                                <label>Username<span class="text-error">*</span></label>
                                <span class="field">
                               <input type="text" name="username" id="username" class="input-xxlarge" value="<?php echo $username;?>" style="width:80%;" autocomplete="off" autofocus/>
                     			 </span>
                     </div>
                     
                     
                       <div class="lg-12 md-12 sm-12">
                                <label>Password <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="password" id="password" class="input-xxlarge" value="<?php echo $password;?>" style="width:80%;" autocomplete="off" autofocus/></span>
                     </div>
                     
                      <div class="lg-12 md-12 sm-12">
                                <label>User Type<span class="text-error">*</span></label>
                                <span class="field"> 
                                
                                <select name="usertype" id="usertype" style="width:80%;"  class="chzn-select" >
                                	<option value="">--Choose User--</option>
                                    <option value="admin">admin</option>
                                    <option value="user">user</option>
                                 </select>
                                    
                                <script> document.getElementById('usertype').value='<?php echo $usertype; ?>'; </script>
                        </span>
                     </div>
                     
                     
                     <div class="lg-12 md-12 sm-12">
                        
                          <center> <p class="stdformbutton">
                                <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('username,password,usertype'); ">
								<?php echo $btn_name; ?></button>
                                <a href="master_user.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                       
                    </div>
                   
                        </form>
                   
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_master_user.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>
                <!--widgetcontent-->
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
            	<table width="98%" class="table table-bordered" id="dyntable">
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
                        	
                          	<th width="14%" class="head0 nosort">S.No.</th>
                            <th width="21%" class="head0">User Name</th>
                            <th width="21%" class="head0">Password</th>
                            <th width="21%" class="head0">User Type</th>
                            <th width="11%" class="head0">Edit</th>
                            <th width="12%" class="head0">Delete</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                               <?php
									$slno=1;
									$sql_get = mysql_query("select * from user order by userid desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$userid=$row_get['userid'];
										$username=$row_get['username'];
										$password=$row_get['password'];
										$usertype=$row_get['usertype'];
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $username; ?></td> 
                                                 <td><?php echo $password; ?></td> 
                                                  <td><?php echo ucwords($usertype); ?></td> 
                              					<td><a class='icon-edit' title="Edit" href='?userid=<?php echo  $row_get['userid'] ; ?>'></a></td>
                                                <td>
                                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['userid']; ?>);' style='cursor:pointer'></a>
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
