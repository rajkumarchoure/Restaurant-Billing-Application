<?php include("../adminsession.php");
$pagename = "master_relation.php";
$module = "Add Relation";
$submodule = "Relation Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_relation";
$tblpkey = "relation_id";
if(isset($_GET['relation_id']))
$keyvalue = $_GET['relation_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$relation_name = test_input($_POST['relation_name']);
	
	
	
	//check Duplicate
	$check = check_duplicate($tblname,"relation_name = '$relation_name' and $tblpkey <> '$keyvalue'");
	if($check > 0)
	{
		$dup = " Error : Duplicate Record";
	}
	else
	{
		if($keyvalue == 0)
		{
			//insert
			$form_data = array('relation_name'=>$relation_name,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			  dbRowInsert($tblname, $form_data);
			 
			  $action=1;
			  $process = "insert";
		}
		else
		{
			//update
			$form_data = array('relation_name'=>$relation_name,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
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
	 $relation_name     =  $rowedit['relation_name'];
	
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
                    
                    
                    <table width="100%" border="1">
  <tr>
    <td><p>
                                <label>Relation Name<span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="relation_name" id="relation_name" class="input-xxlarge" value="<?php echo $relation_name;?>" autofocus/></span>
                            </p></td>
    <td><p class="stdformbutton">
                                <button  type="submit" name="submit"class="btn btn-primary" onClick="return checkinputmaster('relation_name'); "><?php echo $btn_name; ?></button> 
                                &nbsp;&nbsp;
                                
                                <button type="reset" class="btn">Reset</button>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p></td>
              </tr>
          </table>
        
                        </form>
                    </div>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_relation.php" class="btn btn-info" target="_blank"><span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span>
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
                            <th class="head0">Relation Name</th>
                            <th class="head0">Edit / Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                      
                           </span></td>
                               <?php
								$slno=1;
								$sql_get = mysql_query("select * from m_relation where 1=1 order by relation_id desc");
								while($row_get = mysql_fetch_assoc($sql_get))
								{
									?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $row_get['relation_name'] ; ?></td>    
                                               
                             
                              <td><a class='icon-edit' href='?relation_id=<?php echo  $row_get['relation_id'] ; ?>' title="Edit"></a>
                                                <a class='icon-remove' onclick='funDel(<?php echo  $row_get['relation_id'] ; ?>);' style='cursor:pointer' title="Delete"></a></td>
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
