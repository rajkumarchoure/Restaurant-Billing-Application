<?php include("../adminsession.php");
$pagename = "master_product.php";
$module = "Add Menu Item";
$submodule = "Menu Item Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_product";
$tblpkey = "productid";
$imgpath = "uploaded/";
if(isset($_GET['productid']))
$keyvalue = $_GET['productid'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";


if($keyvalue == 0)
{
	$sqlgetcat=mysql_query("select * from m_product order by productid desc");
	$rowgetcat=mysql_fetch_assoc($sqlgetcat);
	$pcatid =$rowgetcat['pcatid'];
	$unitid =$rowgetcat['unitid'];
}



if(isset($_POST['submit']))
{
	$pcatid = test_input($_POST['pcatid']);
	$prodname = test_input($_POST['prodname']);
	$rate = test_input($_POST['rate']);
	$disc = test_input($_POST['disc']);
	$unitid = test_input($_POST['unitid']);	
	$enable="enable";
	$imgname= $_FILES['imgname'];	
		
		
	
	//check Duplicate
	$check = check_duplicate($tblname,"prodname = '$prodname' && $tblpkey <> $keyvalue");
	
		
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
			$form_data = array('prodname'=>$prodname,'pcatid'=>$pcatid,'rate'=>$rate,'unitid'=>$unitid,'disc'=>$disc,						   
							   'enable'=>$enable,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			dbRowInsert($tblname, $form_data);
			$keyvalue = mysql_insert_id();
			
			if($_FILES['imgname']['tmp_name']!="")
			{			
			$uploaded_filename = uploadImage($imgpath,$imgname);			
			$cmn->convert_image($uploaded_filename,"uploaded/","100","100");
			 mysql_query("update $tblname set imgname='$uploaded_filename' where $tblpkey='$keyvalue'"); 
			}
			
			$action=1;
			$process = "insert";
			
			
			}
		
		else
		{
			//update
			$form_data = array('prodname'=>$prodname,'pcatid'=>$pcatid,'rate'=>$rate,'unitid'=>$unitid,'disc'=>$disc,						   
							   'enable'=>$enable,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
			dbRowUpdate($tblname, $form_data,"WHERE $tblpkey = '$keyvalue'");
					
			
			if($_FILES['imgname']['tmp_name']!="")
				{
					//delete old file
						$rowimg = mysql_fetch_array(SelectDB($tblname,"where $tblpkey='$keyvalue'"));
					 $oldimg = $rowimg["imgname"];
					if($oldimg != "")
					{
						unlink("uploaded/$oldimg");
						
					}
					
					//insert new file
					
					$uploaded_filename = uploadImage($imgpath,$imgname);					
					$cmn->convert_image($uploaded_filename,"uploaded/","100","100");
					mysql_query("update $tblname set imgname='$uploaded_filename' where $tblpkey='$keyvalue'");
					
				}
			
			
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
	 $pcatid    =  $rowedit['pcatid'];
	 $prodname    =  $rowedit['prodname'];
	 $rate    =  $rowedit['rate'];
	 $disc    =  $rowedit['disc'];
	 $unitid    =  $rowedit['unitid'];
	 $imgname=  $rowedit['imgname'];
		
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
                    <form class="stdform stdform2" method="post" action="" enctype="multipart/form-data" >
                    <?php echo  $dup;  ?>
                    
                    <div class="lg-12 md-12 sm-12">
                                <label>Menu Heading Name <span class="text-error">*</span></label>
                                <span class="field">
                                <select name="pcatid" id="pcatid" style="width:80%;"  class="chzn-select">
                                	<option value="">--Choose Categary--</option>
                                    <?php
									$sql=mysql_query("select * from m_product_category order by catname");
									while($row=mysql_fetch_assoc($sql))
									{								
									?>
                                    <option value="<?php echo $row['pcatid'];  ?>"> <?php echo $row['catname']; ?></option>
                                    <?php } ?>
                                </select>
                                <script> document.getElementById('pcatid').value='<?php echo $pcatid; ?>'; </script>
                      </span>
                     </div>
                     
                     
                       <div class="lg-12 md-12 sm-12">
                                <label>Menu Item Name <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="prodname" id="prodname" class="input-xxlarge" value="<?php echo $prodname;?>" style="width:80%;" autocomplete="off" autofocus/></span>
                     </div>
                     
                      <div class="lg-12 md-12 sm-12">
                                <label>Unit<span class="text-error">*</span></label>
                                <span class="field"> 
                                
                                <select name="unitid" id="unitid" style="width:80%;"  class="chzn-select" >
                                	<option value="">--Choose Unit--</option>
                                    <?php
									$sql=mysql_query("select * from m_unit order by unit_name");
									while($row=mysql_fetch_assoc($sql))
									{								
									?>
                                    <option value="<?php echo $row['unitid'];  ?>"> <?php echo $row['unit_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <script> document.getElementById('unitid').value='<?php echo $unitid; ?>'; </script>
                        </span>
                     </div>
                     
                     <div class="lg-12 md-12 sm-12">
                                <label>Rate<span class="text-error">*</span></label>
                                <span class="field"> <input type="text" name="rate" id="rate" class="input-xxlarge" value="<?php echo $rate;?>" style="width:80%;" autocomplete="off" autofocus /> </span>
                     </div>
                     
                      <div class="lg-12 md-12 sm-12">
                                <label>Disc % </label>
                                <span class="field"> <input type="text" name="disc" id="disc" class="input-xxlarge" value="<?php echo $disc;?>" style="width:80%;" autocomplete="off" autofocus /> </span>
                     </div>
                     
                     
                     <div class="lg-12 md-12 sm-12">
                                <label>Product Image </label>
                                <span class="field">
                               <input type="file" name="imgname"id="imgname">
                               
                               <img id="blah" alt="" height='80px' width="80px" title='Text Image' src='<?php if($imgname!="" && file_exists("uploaded/".$imgname))
					        { echo "uploaded/".$imgname;  }?>'/>
                                            
                                 </span>
                     </div>
                     	                                              
                                                         
                          <center> <p class="stdformbutton">
                    <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('pcatid,prodname,unitid,rate'); ">
								<?php echo $btn_name; ?></button>
                                <a href="master_product.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                       
                    </div>
                     </form>
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_master_product.php" class="btn btn-info" target="_blank">
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
                        	
                          	<th width="11%" class="head0 nosort">S.No.</th>
                            <th width="18%" class="head0">Categary Name</th>
                            <th width="16%" class="head0">Product Name</th>
                            <th width="17%" class="head0">Unit Name</th>
                            <th width="17%" class="head0">Rate</th>
                            <th width="17%" class="head0">images</th>
                            <th width="9%" class="head0">Edit</th>
                            <th width="12%" class="head0">Delete</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                               <?php
									$slno=1;
									$sql_get = mysql_query("select * from m_product where 1=1 order by productid desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
										$unitid=$row_get['unitid'];
										$pcatid=$row_get['pcatid'];
										$imgname=$row_get['imgname'];
										$rate=$row_get['rate'];
										$unit_name=$cmn->getvalfield("m_unit","unit_name","unitid='$unitid'");
										$catname=$cmn->getvalfield("m_product_category","catname","pcatid='$pcatid'");
									   ?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $catname; ?></td> 
                                                 <td><?php echo $row_get['prodname']; ?></td> 
                                                  <td><?php echo $unit_name; ?></td> 
                                                  <!--<td><?php// if($imgname !='') { ?><img src="uploaded/<?php// echo $imgname; ?>" height="50px" width="50pc">
                                                  <?php// } ?> </td>--> 
                                                  <td><?php echo $rate; ?></td>
                                                  <td><img src="uploaded/<?php echo $row_get['imgname']; ?>" height="50" width="50"></td>  
                              					<td><a class='icon-edit' title="Edit" href='?productid=<?php echo  $row_get['productid'] ; ?>'></a></td>
                                                <td>
                                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['productid']; ?>);' style='cursor:pointer'></a>
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
		imgpath = '<?php echo $imgpath; ?>';
		 //alert(module); 
		if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_image_master.php',
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module+'&imgpath='+imgpath,
			  dataType: 'html',
			  success: function(data){
				 //alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close
	
	


	
		

  </script>



</body>

</html>
