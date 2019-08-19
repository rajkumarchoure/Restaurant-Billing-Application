<?php include("../adminsession.php");
$pagename = "out-entry.php";
$module = "Add In Entry";
$submodule = "In-Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "in-entry";
$tblpkey = "inentry_id";
if(isset($_GET['inentry_id']))
$keyvalue = $_GET['inentry_id'];
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


<!-- Add jQuery library -->
	
	<!-- Add fancyBox main JS and CSS files -->
<!--	<script type="text/javascript" src="../inline/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="../inline/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<script type="text/javascript">
		$(document).ready(function() {
	
			jQuery('.fancybox').fancybox();


		});
	</script>-->
    
    
    
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
                  
                    <?php echo  $dup;  ?>
                    <div class="lg-12 md-12 sm-12">
                                <label>Godown<span class="text-error">*</span></label>
                                <span class="field"> 
                                
                                <select name="shop_id" id="shop_id" style="width:80%;"  class="chzn-select" >
                                	<option value="">--Choose Godown--</option>
                                    <?php
									$sql=mysql_query("select * from m_shop order by shop_name");
									while($row=mysql_fetch_assoc($sql))
									{								
									?>
                                    <option value="<?php echo $row['shop_id'];  ?>"> <?php echo $row['shop_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <script> document.getElementById('shop_id').value='<?php echo $shop_id; ?>'; </script>
                        </span>
                     </div>
                       <div style="float:left; width:400px; height:470px; background:#039;" id="productnamelist" >
                          
                             
                     </div>
                     
                      <div style="float:right; width:580px;height:470px; background:#039;" >
                        <h2 align="center" style="color:#FFF;">Out-Entry</h2> 
                      <div style="text-align:left; color:#FFF; float:left; margin:2px auto;"><strong> &nbsp; &nbsp; Out-Entry No :</strong>  </div>  <div style="text-align:right; color:#FFF; float:right; margin:2px auto;"><strong> Total Amount :</strong> <span id="grossamt"> 0  </span> &nbsp; &nbsp; </div>
                      <table id="mytable" width="100%" style="color:#FFF; text-align:left;">
                      <thead>
                      <th width="6%">Sn</th>
                     <th width="29%">Product Name</th>
                     <th width="10%">Unit</th>
                     <th width="13%">Quantity</th>
                     <th width="12%">Rate</th>
                     <th width="18%">Amount</th>
                     <th width="11%">Action</th>
                     <td width="1%"></thead>
                      </table>       
                      
                <input type="hidden" name="check_product" id="check_product" value="<?php echo $productlist;?>"  >
                <input type="hidden" name="input_product_type" id="input_product_type" value="0"  >
                      
                               
                     </div>
                     	
                        <div class="lg-12 md-12 sm-12" style="float:left; width:100%; height:200px; background:#333;" >
                      <?php 
					  $sqlget=mysql_query("select * from m_product_category order by catname");
					  while($rowget=mysql_fetch_assoc($sqlget))
					  {
						  $pcatid=$rowget['pcatid'];
						  $catname=$rowget['catname'];
					  ?>
                        
                       <button class="btn btn-primary" style="width:18%; height:18%;" onClick="getproductlist('<?php echo $pcatid; ?>');" ><?php echo $catname; ?></button>
					   <?php 
					  }	
					   ?>
                               
                     </div> 
                        
                        
                        
                                                         
                          
                     
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
                   <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_master_shop.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>
                <!--widgetcontent-->
                <!--<h4 class="widgettitle"><?php // echo $submodule; ?> List</h4>-->
            	<!--<table class="table table-bordered" id="dyntable">
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
									/*$slno=1;
									$sql_get = mysql_query("select * from m_shop where 1=1 order by inentry_id desc");
									while($row_get = mysql_fetch_assoc($sql_get))
									{
									  */ ?> <tr>
                                                <td><?php //echo $slno++; ?></td> 
                                                <td><?php //echo $row_get['shop_name']; ?></td> 
                                                 <td><?php //echo $row_get['telphone']; ?></td> 
                                                  <td><?php // echo $row_get['address']; ?></td>                                                 
                              					<td><a class='icon-edit' title="Edit" href='?inentry_id=<?php // echo  $row_get['inentry_id'] ; ?>'></a></td>
                                                <td>
                                                <a class='icon-remove' title="Delete" onclick='funDel(<?php // echo  $row_get['inentry_id']; ?>);' style='cursor:pointer'></a>
                                                </td>
                        </tr>
                    
                        <?php
					//	}
						?>
                        
                        
                    </tbody>
                </table>-->
                
               
            </div><!--contentinner-->
        </div><!--maincontent-->
        
   
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->



    
</div><!--mainwrapper-->

<div class="modal fade" id="myModal"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Product</h4>
                    </div>
                        <div class="modal-body">
                          
                          
							<table class="table table-bordered table-condensed">
                                    	<tr>
                                        	<td colspan="5"><p id="dup_err" class="text-red"><?php echo $duplicate; ?></p></td>
                                        </tr>
										<tr>
                                            <th width="18%">Product Name &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>
                                        	<td>                                           
                                           <input class="form-control" name="mprodname" id="prodname" value="" autofocus="" type="text" readonly style="z-index:-44;" >
                                           <input type="hidden" name="mproductid" id="productid" >                               </td>
                                        </tr>
                                          <tr>
                                            <th width="18%">Unit &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>
                                        	<td>                                           
                                           <input class="form-control" name="unit_name" id="unit_name"  value="" autocomplete="off" autofocus="" type="text" readonly >
                                            <input type="hidden" name="unitid" id="unitid" readonly > 
                                                                          </td>
                                        </tr>
                                        <tr>
                                            <th width="18%">Quantity &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>
                                        	<td>                                           
                                           <input class="form-control" name="qty" id="qty"  value="" autocomplete="off" autofocus="" type="text" onChange="gettotal();">                               </td>
                                        </tr>
                                        
                                        <tr>
                                            <th width="18%">Rate &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>
                                        	<td>                                           
                                           <input class="form-control" name="rate" id="rate" autofocus="" autocomplete="off" type="text" onChange="gettotal();">                               </td>
                                        </tr>
                                        
                                        <tr>
                                            <th width="18%">Total Amount &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>
                                        	<td>                                           
                                           <input class="form-control" name="tot_amount" id="tot_amount" autocomplete="off"  autofocus="" type="text">                               </td>
                                        </tr>
                                         
                                        
                                    </table>
                        </div>
                        <div class="modal-footer clearfix">
                           <input type="submit" class="btn btn-primary pull-left" name="submit" value="Add" onClick="addlist();"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"   ><i class="fa fa-times"></i> Discard</button>
                           
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

        </div>
          
          
          
          
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
				  
				}
				
			  });//ajax close
		}//confirm close
	} //fun close
	
	
	function getproductlist(pcatid)
	{
		//alert(pcatid);
		if(pcatid !='' && !isNaN(pcatid))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax_getproductlist.php',
			  data: 'pcatid='+pcatid,
			  dataType: 'html',
			  success: function(data){
				// alert(data);
				 
				 //$("#productnamelist").data(data);
				   document.getElementById('productnamelist').innerHTML=data;
				}
				
				  });//ajax close
		}		
	}	
	
	
	function addproduct(productid,prodname,unitid,unit_name)
	
	{
				
		jQuery("#myModal").modal('show');		
		jQuery("#prodname").val(prodname);
		jQuery("#productid").val(productid);
		jQuery("#unitid").val(unitid);
		jQuery("#unit_name").val(unit_name);
		//alert(productid);
	}	
	
	function addlist()
	{
		var  productid= document.getElementById('productid').value;
		var  prodname= document.getElementById('prodname').value;
		var  unit_name= document.getElementById('unit_name').value;
		var  unitid= document.getElementById('unitid').value;
		var  qty= document.getElementById('qty').value;
		var  rate= document.getElementById('rate').value;
		var  tot_amount= document.getElementById('tot_amount').value;
	    var gross = document.getElementById("grossamt").innerHTML;
		
		if( productid !='' && qty !='' && rate !='')
		{
		check_check_product_old = document.getElementById("check_product").value ;
		//check check_product
		var pro_arr = check_check_product_old.split(","); 
		var check_dup_check_product = 0;//pro_arr.indexOf(productid); 
		//alert('indexof='+check_dup_check_product);
		
		if(check_dup_check_product > 0)
			{
				
				alert('This Product Already Exist');
				document.getElementById('qty').value = "" ;
				document.getElementById('rate').value = "" ;
				document.getElementById('tot_amount').value = "" ;
				document.getElementById('productid').value = "" ;
				document.getElementById('prodname').value = "" ;
				return false;
			}//end if
			else
			{
				document.getElementById("check_product").value = check_check_product_old +','+productid;
				//alert('hi');
				var table = document.getElementById("mytable");
				var rowcount = document.getElementById('mytable').getElementsByTagName("tr").length;
				//alert(rowcount);
				slno = 1;
				
				if(rowcount > 1)
				{
					var slno; 
					//alert(document.getElementById("mytable").rows[rowcount-1].cells[0].innerHTML);
					slno = parseInt(document.getElementById("mytable").rows[rowcount-1].cells[0].innerHTML);
					slno = slno + 1;
					//alert(slno);
					//rowcount++;
					//alert($('#mytable tr:last')[0].val());
				}
				
				var row = table.insertRow(rowcount);
				//row.style.backgroundColor = "#ABE4F8";
				row.className = "bg-gray";
				
				var cell1 = row.insertCell(0);
				cell1.innerHTML = slno;
				
				var cell2 = row.insertCell(1);
				var t2 = document.createElement("input");
				t2.id = "prodname" + slno;
				t2.name = "prodname[]";
				t2.style.width = "98%";
				t2.style.border = "none";
				t2.style.background="#039";
				t2.style.color="white";
				t2.className = "bg-gray";
				t2.readOnly = "true";
				t2.value = prodname.trim();
				cell2.appendChild(t2);
				
				var elehid1 = document.createElement("input");
				elehid1.type = "hidden";
				elehid1.name = 'productid[]';
				elehid1.id = 'productid'+slno;
				elehid1.value = productid.trim();
				cell2.appendChild(elehid1);
				
				var cellu = row.insertCell(2);
				var tu = document.createElement("input");
				tu.id = "unit_name" + slno;
				tu.name = "unit_name[]";
				tu.style.width = "98%";
				tu.style.background="#039";
				tu.style.border = "none";
				tu.className = "bg-gray";
				tu.style.color="white";
				tu.readOnly = "true";
				tu.value = unit_name;
				cellu.appendChild(tu);
				
				var elehid2 = document.createElement("input");
				elehid2.type = "hidden";
				elehid2.name = 'unitid[]';
				elehid2.id = 'unitid'+slno;
				elehid2.value = unitid.trim();
				cellu.appendChild(elehid2);
				
				
				
				var cell3 = row.insertCell(3);
				var t5 = document.createElement("input");
				t5.id = "qty" + slno;
				t5.name = "qty[]";
				t5.style.width = "98%";
				t5.style.background="#039";
				t5.style.border = "none";
				t5.style.color="white";
				t5.className = "bg-gray";
				t5.readOnly = "true";
				t5.value = qty;
				cell3.appendChild(t5);
				
				
				var cell4 = row.insertCell(4);
				var t6 = document.createElement("input");
				t6.id = "rate" + slno;
				t6.name = "rate[]";
				t6.style.width = "98%";
				t6.style.background="#039";
				t6.style.border = "none";
				t6.style.color="white";
				t6.className = "bg-gray";
				t6.readOnly = "true";
				t6.value = rate;
				cell4.appendChild(t6);
				
				
				var cell5 = row.insertCell(5);
				var t3 = document.createElement("input");
				t3.id = "tot_amount" + slno;
				t3.name = "tot_amount[]";
				t3.style.width = "98%";
				t3.style.background="#039";
				t3.style.border = "none";
				t3.style.color="white";
				t3.className = "bg-gray";
				t3.readOnly = "true";

				t3.value = tot_amount;
				cell5.appendChild(t3);
				
				
				
				var cell6 = row.insertCell(6);
				var btn = document.createElement("BUTTON");
				btn.id = "del" + slno;
				//t5.name = "pquantity[]";
				//btn.style.width = "50px";
				//btn.style.height = "25px";
				var txtbtn = document.createTextNode("X");
				btn.appendChild(txtbtn); 
				btn.className ="btn btn-danger btn-sm";
				btn.onclick = function()
				{ 
					//code for delete row
					//alert('hi javascript');
					if(confirm('Are you sure want to remove this item'))
					{
					
						delproduct = document.getElementById("productid" + slno).value;
						deltotal = document.getElementById("tot_amount" + slno).value;
						gross = document.getElementById("grossamt").innerHTML;
						//alert(deltotal);
						
						prod_cnt_old = document.getElementById("check_product").value;
						if(prod_cnt_old != "")
						{
							gross = parseFloat(gross) - parseFloat(deltotal);
							document.getElementById("grossamt").innerHTML = gross.toFixed(2); 
							var prod_cnt_new = prod_cnt_old.replace(delproduct, "0");
							//alert(gross);
							document.getElementById("check_product").value = prod_cnt_new;
							var i = this.parentNode.parentNode.rowIndex;
							document.getElementById("mytable").deleteRow(i);
							return true;
						}
						return false;
						
					}
					else
					return false;
					
				}; 
				cell6.appendChild(btn);
				grossamt = parseFloat(gross) + parseFloat(total);
				netamt = parseFloat(grossamt) ;
				jQuery("#grossamt").html(grossamt.toFixed(2));
				
				
				jQuery('#productid').val('');
				jQuery('#prodname').val('');
				jQuery('#qty').val('');
				jQuery('#unit_name').val('');
				jQuery('#rate').val('');
				jQuery('#unitid').val('');
				jQuery('#tot_amount').val('');
				jQuery("#myModal").modal('hide');
				
				
			}
		}		
		
		
	}
	
		function gettotal()
	{
		var rate=document.getElementById('rate').value;
		var qty=document.getElementById('qty').value;
		
		if(! isNaN(rate) && ! isNaN(qty))
		{
			total=	rate * qty; 
		}
		
		document.getElementById('tot_amount').value=total;
	}
	
	
  </script>



</body>

</html>
