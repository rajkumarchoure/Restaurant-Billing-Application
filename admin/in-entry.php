<?php include("../adminsession.php");
include("../lib/smsinfo.php");
$pagename = "in-entry.php";
$module = "Add Bill";
$submodule = "Bill Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "bill_details";
$tblpkey = "billdetailid";

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_GET['inentry_id']))
$keyvalue = $_GET['inentry_id'];
else
$keyvalue = 0;


$billid = 0;
if(isset($_GET['table_id']))
{
	$table_id = addslashes($_GET['table_id']);
	$table_no = $cmn->getvalfield("m_table","UPPER(table_no)","table_id='$table_id'");
	$billid = $cmn->getvalfield("bills","billid","table_id='$table_id' and is_paid = 0");
	if($billid == "")
	$billid = 0;
	
}
else
$table_id = 0;
if(isset($_GET[$tblpkey]))
{
	 $btn_name = "Update";
	 //echo "SELECT * from $tblname where $tblpkey = $keyvalue";die;
	 $sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
	 $rowedit = mysql_fetch_array(mysql_query($sqledit));
	 $shop_name =  $rowedit['shop_name'];
	 $telphone  =  $rowedit['telphone'];
	 $address =  $rowedit['address'];
	 
	
}


$cust_list_qry = "SELECT cust_name FROM bills WHERE cust_name !=''";
$result_cust_list = mysql_query($cust_list_qry);

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
<style type="text/css">
    .text-muted{color: red;}
</style>
</head>

<body onLoad="getrecord();">

<div class="mainwrapper">
	
    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
    
    <!-- START OF RIGHT PANEL -->
    
   <div class="rightpanel">
    	<?php include("inc/header.php"); ?>
        
        
        <div class="maincontent">
        	 <div class="contentinner content-dashboard">
            	<div class="alert alert-info">
                <?php 
				$sqlgettable=mysql_query("select * from m_table order by table_no");
				while($rowgettable=mysql_fetch_assoc($sqlgettable))
				{
					
					$count_product = $cmn->getvalfield("bill_details","count(*)","table_id='$rowgettable[table_id]' and billid='0'");
					//echo $count_product;
				?>
                	<a style="margin:3px;" href="?table_id=<?php echo $rowgettable['table_id']; ?>" class="btn <?php if($count_product > 0 || $rowgettable['table_id'] == $table_id) {?> 
                    btn-danger <?php } else if($count_product == 0) { ?> btn-success <?php } ?>" /> <?php echo ucwords($rowgettable['table_no']); ?> </a>
                   <?php } ?>
                    <?php
				   $currdate = date('Y-m-d');
				   $total_saved_orders = 0;
				   $total_saved_orders = $cmn->getvalfield("bills","count(*)","billdate='$currdate'");
                   ?>
               <span style="float:right;"><code>Total Saved Orders: <span id="countproduct"><?php echo $total_saved_orders; ?></span> </code></span>     
              </div><!--alert-->
              
               <!--row-fluid-->
                <div class="alert alert-info">
                <input type="button" class="btn btn-warning" value="Show All" onClick="getproductlist('0','<?php echo $table_id; ?>');" style="margin-bottom:3px;" />
                
                  <?php 
					  $sqlget=mysql_query("select * from m_product_category order by catname");
					  while($rowget=mysql_fetch_assoc($sqlget))
					  {
						  $pcatid=$rowget['pcatid'];
						  $catname=$rowget['catname'];
					  ?>
                	<input type="button" class="btn btn-inverse" value="<?php echo $catname; ?>" onClick="getproductlist('<?php echo $pcatid; ?>','<?php echo $table_id; ?>');" style="font-size:14px;margin:3px;" />
                     <?php 
					  }	
					   ?>
                </div>
              
              
              <!--<div class="alert alert-danger" id="pendingorderlists">
                <?php 
				$sqlgetorders=mysql_query("select * from bills where is_completed = 0 order by billid");
				$cnt_pending = 0;
				while($rowgetorders=mysql_fetch_assoc($sqlgetorders))
				{
					
					//echo $count_product;
					$billnumber = $rowgetorders['billnumber'];
					$is_completed = $rowgetorders['is_completed'];
					//href="?billnumber=<?php echo $billnumber; 
					$cnt_pending++;
					
				?>
                	<a id="btn<?php echo $rowgetorders['billid']; ?>" onClick="changestatus('<?php echo $rowgetorders['billid']; ?>','<?php echo $rowgetorders['is_completed']; ?>')" class="btn <?php if($is_completed == 1) {?> 
                    btn-success <?php } else { ?> btn-warning <?php } ?>" /> <?php echo ucwords($billnumber); ?> </a>
                   <?php 
				 }
				 if($cnt_pending == 0)
				 echo "Hurray, You have no any pending orders for today!";
				 
				 ?>
                 
                  <div style="float:right;">
                 <strong></strong>
                 </div>
               
                  
              </div>-->
                
                <div class="row-fluid">
                	<div class="span6">
                    	<h4 class="widgettitle nomargin"> <span style="color:#00F;" >  ORDER ENTRY FOR <?php echo $table_no; ?>
                        </span></h4>
                        <div class="widgetcontent bordered" id="showrecord">
                        	
                        </div><!--widgetcontent-->
                     </div>
                    
                    <!--span8-->
                    <div class="span6">
                    		 <div class="alert alert-success" >
                             <input type="text" id="myInput" onKeyUp="myFunction()" placeholder="Search for names or serial number.." title="Type in a name" autocomplete='off'>
                             </div>
                 			 <div class="widgetcontent  padding" id="productnamelist" style="overflow:scroll; height:400px;">
                             
                        	 </div>
                    </div><!--span4-->
                </div>
                
                
                
               
            </div><!--contentinner-->
        </div><!--maincontent-->
        
   
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
</div>
<!--product add modal-->
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
                                            <th width="18%">Unit &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>
                                            <td>                                           
                                           <input class="form-control" name="mprodname" id="prodname" value="" autofocus="" type="text" readonly style="z-index:-44;" >
                                           <input type="hidden" name="mproductid" id="productid"  readonly > </td>
                                           <td>                                           
                                           <input class="form-control" name="unit_name" id="unit_name"  value="" autocomplete="off" autofocus="" type="text" readonly >
                                            <input type="hidden" name="unitid" id="unitid" readonly > 
                                            </td>
                                        </tr>
                                        
                                       
                                        
                                        <tr>
                                         <th width="18%">Rate &nbsp;<span style="color:#F00;">*</span></th>
                                          <th colspan="2" width="18%">Quantity &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>  
                                        <td>                                           
                                           <input class="form-control" name="rate" id="rate" autofocus="" autocomplete="off" type="text" onChange="gettotal();"  >                               </td>                                          
                                            <td> 
                                            <input class="form-control" name="qty" id="qty"  value="1" autocomplete="off" autofocus="" type="text" onChange="gettotal();" placeholder="Enter Quantity" style="width:50%"  >  
                                            <input type="button" style="font-size:16px;" class="btn-sm btn btn-success btn-plus" id="add" value="+" onClick="addqty()" >  
                                            <input type="button"  style="font-size:16px;" class="btn-sm btn btn-danger" id="minus" value="--" onClick="minusqty();" >                                        
                                           </td>
                                        </tr>
                                    </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="total"></span></h2>
                           <input type="submit" class="btn btn-primary" name="submit" value="Add" onClick="addlist();"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"   ><i class="fa fa-times"></i> Discard</button>
                           
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div>
        
        
        
 
 <!--discount modal-->
 <div class="modal fade" id="myModal_disc"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Save Bill For <?php echo $table_no; ?></h4>
                    </div>
                        <div class="modal-body">
                        	<table class="table table-bordered table-condensed" style="font-size:16px;">
                            
                            	<tr>
                                	<th width="40%">Order Type &nbsp;<span style="color:#F00;">*</span></th>
                        			<td><input class="form-control" name="parsal_status" id="parsal_status" value="" autofocus="" type="text" readonly ></td>
                                </tr> 
                        		<tr>
                                	<th width="40%">Basic Amt &nbsp;<span style="color:#F00;">*</span></th>
                        			<td><input class="form-control" name="basic_bill_amt" id="basic_bill_amt" value="" autofocus="" type="text"  readonly></td>
                                </tr> 
                                <tr>
                                	<th width="18%">Discount (In %) &nbsp;</th>
                                	<td><input class="form-control" name="disc_percent" id="disc_percent" value="" onKeyUp="get_discount();" autofocus="" 
                                    type="text" ></td>
                                </tr> 
                                <tr>
                                	<th width="18%">Discount (Rs) &nbsp;</th>
                                	<td><input class="form-control" name="disc_rs" id="disc_rs" value="" onKeyUp="get_discount();" autofocus="" 
                                    type="text" ></td>
                                </tr> 
                                <?php
								$sql_tax = mysql_query("select * from tax_setting_new");
								$row_tax =  mysql_fetch_array($sql_tax);
								$sgst = $row_tax['sgst'];
								$cgst = $row_tax['cgst'];
								$sercharge = $row_tax['sercharge'];
								?>
                                
                                <?php if($sgst > 0){ ?>
                                <tr>
                                	<th width="18%">SGST&nbsp;<span style="color:#F00;">*</span></th>
                                	<td><input class="form-control" id="sgst" value="<?php echo $sgst; ?>" type="text" readonly ></td>
                                </tr> 
                                <?php } ?>
                                
                                <?php if($cgst > 0){ ?>
                                <tr>
                                	<th width="18%">CGST&nbsp;<span style="color:#F00;">*</span></th>
                                	<td><input class="form-control" id="cgst" value="<?php echo $cgst; ?>" type="text" readonly ></td>
                                </tr> 
                                <?php } ?>
                                
                                <?php if($sercharge > 0){ ?>
                                <tr>
                                	<th width="18%">SERCHARGE&nbsp;<span style="color:#F00;">*</span></th>
                                	<td><input class="form-control" id="sercharge" value="<?php echo $sercharge; ?>" type="text" readonly ></td>
                                </tr> 
                                <?php } ?>
                                 
                                <tr>
                                	<th width="18%">Net Bill Amt &nbsp;<span style="color:#F00;">*</span></th>
                                	<td><input class="form-control" name="net_bill_amt" id="net_bill_amt" value="" autofocus="" type="text" readonly ></td>
                                </tr> 
                            </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="nettotal"></span></h2>
                           <input type="submit" class="btn btn-primary" name="submit" value="Save Bill" id="save_bill_order" onClick="save_order();"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div>       


 <!--Payment modal-->
<div class="modal fade" id="payment_modal"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>Payment Entry</h4>
                    </div>
                        <div class="modal-body">
                        	<table class="table table-bordered">
                            	<tr>
                                	<td style="width:40%">Bill Number </td>
                                    <td id="payment_bill_number" style="font-weight:bold"></td>
                                </tr>
                                <tr>
                                	<td>Table Number</td>
                                    <td id="payment_table_no" style="font-weight:bold"></td>
                                </tr>
                                <tr>
                                	<td>Net Bill Amount</td>
                                    <td id="payment_amt" style="font-weight:bold"></td>
                                </tr>
                                <tr>
                                	<td>Payment Date</td>
                                    <td style="font-weight:bold">
                                    <input type="text" id="paydate" readonly value="<?php echo date('d-m-Y'); ?>" placeholder='dd-mm-yyyy' data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                    </td>
                                </tr>
                                 <tr >
                                	<td>Payment Mode <span style="color:#F00;">*</span></td>
                                    <td>
                                    	<select id="paymode" class="form-control" onChange="hide_text_pay_options(this.value)">
                                        	<option value="">--Select--</option>
                                        	<!-- <option value="cash">Cash</option>
                                            <option value="checque">Cheque</option>
                                            <option value="card">Card</option>
                                            <option value="paytm">Paytm</option> -->
                                            <option value="credit">Credit</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="hidden-tr">
                                    <td>Cash Amt <span style="color:#F00;">*</span></td>
                                    <td>
                                        <input type="text" class="form-control" id="cash_amt" onChange="calc_rec_amt();">
                                    </td>
                                </tr>
                                <tr class="hidden-tr">
                                    <td>Paytm Amt <span style="color:#F00;">*</span></td>
                                    <td>
                                        <input type="text" class="form-control" id="paytm_amt" style="width: 100px;float: left;" onChange="calc_rec_amt();">

                                        <input type="text" class="form-control" id="paytm_trans_number" placeholder="Paytm Trans. No." style="width: 150px;float: right;">
                                    </td>
                                    
                                </tr>
                                
                                <tr class="hidden-tr">
                                    <td>Card Amt <span style="color:#F00;">*</span></td>
                                    <td>
                                        <input type="text" class="form-control" id="card_amt" style="width: 100px;float: left;" onChange="calc_rec_amt();">
                                        <input type="text" class="form-control" id="card_trans_number" placeholder="Card Trans. No." style="width: 150px;float: right;">
                                    </td>                                   
                                </tr>   
                                <tr class="hidden-tr">
                                    <td>zomato</td>
                                    <td>
                                        <input type="text" class="form-control" id="zomato"><br>
                                        <small id="zomato_error" class="form-text text-muted"></small>
                                    </td>
                                </tr>
                                <tr class="hidden-tr">
                                    <td>swiggy</td>
                                    <td>
                                        <input type="text" class="form-control" id="swiggy"><br>
                                        <small id="swiggy_error" class="form-text text-muted"></small>
                                    </td>
                                </tr>                            

                                <tr class="hidden-tr">
                                    <td>Bank Name</td>
                                    <td>
                                        <input type="text" class="form-control" id="bank_name">
                                    </td>
                                </tr>

                                 <tr>
                                	<td>Rec. Amt <span style="color:#F00;">*</span></td>
                                    <td>
                                    	<input type="text" class="form-control" id="rec_amt" readonly=""><br>
                                        <small id="rec_amt_error" class="form-text text-muted"></small>
                                    </td>
                                </tr>
                                 <!-- <tr id="td_tran_no">
                                	<td>Checque No./ Trans.No.</td>
                                    <td>
                                    	<input type="text" class="form-control" id="tran_no">
                                    </td>
                                </tr> -->
                                
                                <tr id="td_customer_name">
                                	<td>Customer Name</td>
                                    <td>
                                        <input list="browsers" name="browser" class="form-control" id="cust_name" onChange="get_mobile_by_cust_name(this.value);">
                                          <datalist id="browsers">
                                            <?php
                                            while ($row=mysql_fetch_array($result_cust_list)){ ?>
                                            <option value="<?php echo $row['cust_name']; ?>">
                                            <?php } ?>
                                          </datalist><br>

                                    	<!-- <input type="text" class="form-control" id="cust_name"><br> -->
                                        <small id="cust_name_error" class="form-text text-muted"></small>
                                    </td>
                                </tr>
                                 <tr id="td_customer_mobile">
                                	<td>Customer Mobile</td>
                                    <td>
                                    	<input type="text" class="form-control" id="cust_mobile">
                                    </td>
                                </tr>
                                <tr>
                                	<td>Remark</td>
                                    <td>
                                    	<input type="text" class="form-control" id="remarks">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="payment_total"></span></h2>
                           <img src="../img/loaders/loader6.gif" alt="" id="loaderimg" class="pull-right"/>
                           <input type="button" class="btn btn-primary" name="submit" value="Recive Payment" onClick="rec_payment();" id="savepayment"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"   id="disacrdpayment" ><i class="fa fa-times"></i> Discard</button>
                           
                           
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
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close
	
	



	function getproductlist(pcatid,table_id)
	{
		//alert(table_id);
		if(table_id ==0)
		{
			alert("Please Select Table No. First");
			return false;
		}
		
		
	//alert(pcatid);
	if(pcatid !='' && !isNaN(pcatid))
	{
	jQuery.ajax({
	type: 'POST',
	url: 'ajax_getproductlist.php',
	data: 'pcatid='+pcatid,
	dataType: 'html',
	success: function(data){
	//alert(data);
	
	//$("#productnamelist").data(data);
	document.getElementById('productnamelist').innerHTML=data;
	}
	
	});//ajax close
	}		
	}	
	
	
	
	
	function addproduct(productid,prodname,unitid,unit_name,product_price)
	{
				
		jQuery("#myModal").modal('show');			
		jQuery("#prodname").val(prodname);
		jQuery("#productid").val(productid);
		jQuery("#unitid").val(unitid);
		jQuery("#unit_name").val(unit_name);		
		jQuery("#rate").val(product_price);
		jQuery("#total").html(product_price);
		jQuery("#qty").val('1');
		jQuery("#qty").focus();
	}	
	
	
	function addlist()
	{
		var  productid= document.getElementById('productid').value;
		var  prodname= document.getElementById('prodname').value;
		var  unit_name= document.getElementById('unit_name').value;
		var  unitid= document.getElementById('unitid').value;
		var  qty= document.getElementById('qty').value;
		var  rate= document.getElementById('rate').value;
		var  total= document.getElementById('total').innerHTML;
		var  table_id = "<?php echo $table_id; ?>";
		
		if(qty =='' && rate =='')
		{
			alert('Quantity and rate cant be blank');	
			
		}
		else
		{
			
			jQuery.ajax({
			  type: 'POST',
			  url: 'savebillentry.php',
			  data: 'productid='+productid+'&unitid='+unitid+'&qty='+qty+'&rate='+rate+'&table_id='+table_id,
			  dataType: 'html',
			  success: function(data){				  
				if(data == 0)
				{
					alert("This Bill is Saved, Cant add product.");
				}
				else
				{
					getrecord();
					jQuery('#productid').val('');
					jQuery('#prodname').val('');
					jQuery('#qty').val('');
					jQuery('#unit_name').val('');
					jQuery('#rate').val('');
					jQuery('#unitid').val('');
					jQuery('#total').html('');				
					jQuery("#myModal").modal('hide');
					jQuery('#myInput').val('');
					jQuery('#myInput').focus();
				}
				
			  }
				
			  });//ajax close
				
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
		
		document.getElementById('total').innerHTML=total;
	}
	
  function addqty()
  {
  	var qty = parseInt(document.getElementById('qty').value);
	var rate = parseFloat(document.getElementById('rate').value);
	var addqty1;
	//alert(qty);
	if(!isNaN(qty))
		{
			 addqty1 = parseInt(qty)+1;
		}
 		document.getElementById('qty').value=addqty1;
		var prodamt = rate * addqty1;
		jQuery("#total").html(prodamt);
		
		//alert(prodamt);
		
		
  }
  
  
  function minusqty()
  {
	  
  	var qty = parseInt(document.getElementById('qty').value);	
	var rate = parseFloat(document.getElementById('rate').value);
	 var addqty1;
	
	if(!isNaN(qty) && qty > 1)
	{
		 addqty1 = parseInt(qty)-1;
		 document.getElementById('qty').value=addqty1;
		 var prodamt = rate * addqty1;
		 jQuery("#total").html(prodamt);
		 
	}else
	alert("Quntity can not be less than 1");
 	
  }
  
  
   
  
  function deleterecord(billdetailid)
  {
	  tblname = '<?php echo $tblname; ?>';
		tblpkey = '<?php echo $tblpkey; ?>';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';
		var  table_id= "<?php echo $table_id; ?>";
		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+billdetailid+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				  getrecord();
				}
				
			  });//ajax close
		}//confirm close
	
  }  
   
</script>

<script>
function myFunction() {
  //alert('hi');
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td1 = tr[i].getElementsByTagName("td")[0];
	td2 = tr[i].getElementsByTagName("td")[1];
	//alert(td);
    if(td1 || td2) {
      if(td1.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>  


 
<script>
function getrecord(){
								  
		var table_id='<?php echo $table_id; ?>';	
		//alert(table_id);
		if(table_id !=0)
		{
			  jQuery.ajax({
			  type: 'POST',
			  url: 'showbillrecord.php',	
			  data: 'table_id='+table_id,
			  dataType: 'html',
			  success: function(data){				  
				
					jQuery('#showrecord').html(data);
				}
			  });//ajax close
		}
							  
	}

//calling fun for view all items
getproductlist('0','2');
	

function changestatus(billid,is_completed)
{
var crit="<?php echo '1=1'; ?>";

	
	//alert(crit);
	if(confirm("Are you sure ! Do You want to Complete order no  ?"))
	{
		  jQuery.ajax({
		  type: 'POST',
		  url: 'ajax_update_order.php',
		  data: "billid="+billid+'&crit='+crit+'&is_completed='+is_completed,
		  dataType: 'html',
		  success: function(data){
			//alert(data);
			  //jQuery('#record').html(data);
			  jQuery("#btn"+billid).hide();
			 //document.getElementById().
			 
					arr = data.split("|");						
					status =arr[0].trim(); 
					count_product = arr[1].trim();
					jQuery("#countproduct").html(count_product);
					
			  
			  
			}
			
		  });//ajax close
	}//confirm close
}


function refreshkot(billid,table_id)
{
	//alert(table_id);
	 jQuery.ajax({
		  type: 'POST',
		  url: 'ajax_check_kot_products.php',
		  data: "billid=" + billid + '&table_id=' + table_id,
		  dataType: 'html',
		  success: function(data){
			  var count_prod = data.trim();
			  //alert(count_prod);
			  if(count_prod == 0)
			  alert('Please add product to generate new KOT!');
			  else{
					var myurl = "pdf_restaurant_kot_recipt.php?billid="+billid+"&table_id="+table_id;
					window.open(myurl,'_blank');	
					getrecord();	
					location='in-entry.php?table_id='+table_id;
			}
			  
		 }
			
	});//ajax close
}


function show_discount_modal()
{
	//alert(is_parsal);
	jQuery("#myModal_disc").modal('show');	
	basic_bill_amt = jQuery("#hidden_basic_amt").val();	
	
	//check parcel
	if(jQuery('#is_parsal').prop("checked"))
	jQuery("#parsal_status").val('Parcel');
	else
	jQuery("#parsal_status").val('Table Order');
	
	jQuery("#basic_bill_amt").val(basic_bill_amt);	
	get_discount();
	if(basic_bill_amt == 0)
	{
		jQuery("#save_bill_order").attr("disabled", "disabled");
	}
	else
	jQuery('#save_bill_order').removeAttr('disabled');
	
}



function get_discount()
{
	basic_bill_amt = parseFloat(jQuery("#basic_bill_amt").val());	
	disc_percent = parseFloat(jQuery("#disc_percent").val());	
	disc_rs = parseFloat(jQuery("#disc_rs").val());	
	sgst = parseFloat(jQuery("#sgst").val());	
	cgst = parseFloat(jQuery("#cgst").val());	
	sercharge = parseFloat(jQuery("#sercharge").val());	
	
	//alert(cgst);
	
	if(disc_percent > 0)
	{
		disc_amt =  basic_bill_amt * (disc_percent / 100) ;
	}else
	disc_amt = 0;
	
	if(disc_rs > 0)
	disc_amt_rs = disc_rs;
	else
	disc_amt_rs = 0;
	
	
	
	net_bill_amt = basic_bill_amt - disc_amt - disc_amt_rs;
	
	if(sgst > 0)
	sgst_amt =  net_bill_amt * (sgst/100);
	else
	sgst_amt = 0;
	
	if(cgst > 0)
	cgst_amt =  net_bill_amt * (cgst/100);
	else
	cgst_amt = 0;
	
	if(sercharge > 0)
	sercharge_amt =  net_bill_amt * (sercharge/100);
	else
	sercharge_amt = 0;
	
	//alert(sercharge);
	//total net bill
	net_bill_amt = net_bill_amt + sgst_amt + cgst_amt + sercharge_amt;
	
	net_bill_amt = net_bill_amt.toFixed(2);
	jQuery("#net_bill_amt").val(net_bill_amt);
	jQuery("#nettotal").html(net_bill_amt);
	
}


function save_order()
{
	
	basic_bill_amt = jQuery("#basic_bill_amt").val();
	disc_percent = jQuery("#disc_percent").val();
	disc_rs = jQuery("#disc_rs").val();
	net_bill_amt = jQuery("#net_bill_amt").val();
	table_id = <?php echo $table_id; ?>;
	is_parsal = jQuery("#is_parsal").val();
	sgst = jQuery("#sgst").val();
	cgst = jQuery("#cgst").val();
	sercharge = jQuery("#sercharge").val();
	parsal_status = jQuery("#parsal_status").val();
	
	//alert(is_parsal);//alert(basic_bill_amt);alert(disc_percent);alert(net_bill_amt);alert(table_id);alert(is_parsal);alert(sgst);alert(cgst);alert(sercharge);alert(parsal_status);

	if(net_bill_amt > 0)
	{
		//alert(is_parsal);
		jQuery("#save_bill_order").attr("disabled", "disabled");
		jQuery.ajax({
			  type: 'POST',
			  url: 'save_order_bill.php',
			  data: "basic_bill_amt=" + basic_bill_amt + '&table_id=' + table_id + '&disc_percent=' + disc_percent + '&net_bill_amt=' + net_bill_amt + '&is_parsal=' + is_parsal + '&sgst='+ sgst + '&cgst=' + cgst + '&sercharge=' + sercharge + '&parsal_status=' + parsal_status + '&disc_rs=' + disc_rs,
			  dataType: 'html',
			  success: function(data){
				 //alert(data);
				  if(data > 0)
				  {
				  		var myurl1 = "pdf_restaurant_recipt.php?billid="+data;
						window.open(myurl1,'_blank');	
						//var myurl2 = "in-entry.php?table_id="+table_id;
						jQuery("#save_bill_order").removeAttr("disabled"); 
						location='in-entry.php?table_id='+table_id;
				  }
				  else{
					  	alert("This Bill is already Saved, Go to Payment");						
				      }
				  
			 }
				
		});//ajax close
	}
}


function show_payment_modal(net_bill_amt,billnumber,table_no)
{
	//alert('hi');
	net_bill_amt = parseFloat(net_bill_amt);
	net_bill_amt = net_bill_amt.toFixed(2);
	jQuery('#payment_bill_number').html(billnumber);
	jQuery('#payment_table_no').html(table_no);
	jQuery('#payment_amt').html(net_bill_amt);
	jQuery('#payment_total').html(net_bill_amt);
	jQuery('#payment_modal').modal('show');
	jQuery('#loaderimg').css("display", "none");
	
}



function hide_text_pay_options(credit)
{
    if (credit=="credit") {
        jQuery(".hidden-tr").hide();
        jQuery("#card_amt").val("");
        jQuery("#paytm_amt").val("");
        jQuery("#cash_amt").val("");
        jQuery("#zomato").val("");
        jQuery("#swiggy").val("");
        jQuery("#rec_amt").val(0);
    }else{
        jQuery(".hidden-tr").show();
    }
}


function rec_payment()
{
	
	var result = 'true';
	paymode = jQuery('#paymode').val();
	tran_no = jQuery('#tran_no').val();
	bank_name = jQuery('#bank_name').val();
	remarks = jQuery('#remarks').val();
	table_id = <?php echo $table_id; ?>;
	billid = <?php echo $billid; ?>;
	cust_name = jQuery('#cust_name').val();
	cust_mobile = jQuery('#cust_mobile').val();
	paydate = jQuery('#paydate').val();
	rec_amt = jQuery('#rec_amt').val();
    cash_amt = jQuery('#cash_amt').val();
    paytm_amt = jQuery('#paytm_amt').val();
    swiggy = jQuery('#swiggy').val();
    zomato = jQuery('#zomato').val();
    payment_amt = jQuery('#payment_amt').html();
    card_amt = jQuery('#card_amt').val();
    card_trans_number = jQuery('#card_trans_number').val();
    paytm_trans_number = jQuery('#paytm_trans_number').val();
	//alert(payment_amt);
	
	if(rec_amt=="")
	{
		 jQuery('#rec_amt_error').html("Receve Amount is Required.");
		 //return false;
	}
	else
	{
        jQuery('#rec_amt_error').html("");
         //return false;
    }
    if(cust_name=="")
    {
         jQuery('#cust_name_error').html("Please Choose Customer Name.");
         //return false;
    }
    else
    {
        jQuery('#cust_name_error').html("");
         //return false;
    }
		// if(paymode=="checque")
		// {
		// 	if(tran_no =="" || bank_name == "")
		// 	{
		// 		alert("Bank name or Checque no is mandatory, if paymode is checque.");
		// 		return false;
		// 	}
		// }
		// if(paymode=="card")
		// {
		// 	if(tran_no =="" || bank_name == "")
		// 	{
		// 		alert("Card Name and Transaction No is mandatory, if paymode is Card.");
		// 		return false;
		// 	}
		// }
		// if(paymode=="paytm")
		// {
		// 	if(tran_no =="")
		// 	{
		// 		alert("Transaction No is mandatory, if paymode is Paytm.");
		// 		return false;
		// 	}
		// }
		// if(paymode=="credit")
		// {
		// 	if(cust_name =="")
		// 	{
		// 		alert("Customer Name is mandatory, if paymode is Credit.");
		// 		return false;
		// 	}
		// }
		
	if (rec_amt!="" && cust_name!=""  && parseFloat(payment_amt)>=rec_amt) {
			jQuery('#loaderimg').css("display", "block");
			jQuery('#savepayment').css("display", "none");
			jQuery('#disacrdpayment').css("display", "none");
			
			jQuery.ajax({
			  type: 'POST',
			  url: 'save_order_payment.php',
			  data: "paymode=" + paymode + '&tran_no=' + tran_no + '&bank_name=' + bank_name + '&remarks=' + remarks + '&table_id=' + table_id + '&billid=' + billid + '&cust_mobile=' + cust_mobile + '&cust_name=' + cust_name + '&paydate=' + paydate + '&rec_amt=' + rec_amt + '&cash_amt=' + cash_amt + '&card_amt=' + card_amt + '&paytm_amt=' + paytm_amt + '&card_trans_number=' + card_trans_number + '&paytm_trans_number=' + card_trans_number + '&zomato=' + zomato + '&swiggy=' + swiggy,
			  dataType: 'html',
			  success: function(data){
				//  alert(data);
				  if(data > 0)
				  {
						location='in-entry.php?table_id='+table_id;
				  }
				  else{
					  alert("Error");
				}
				  
			 }
				
		});//ajax close
			
	}else{
        jQuery('#rec_amt_error').html("Invalid Receve Amount.");
    }
}

// hide_text_pay_options(0);


//for date mask
jQuery(function() {
		//Datemask dd/mm/yyyy
		jQuery("#paydate").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
		//Money Euro
		jQuery("[data-mask]").inputmask();
 });

function get_mobile_by_cust_name(cust_name) {
    jQuery.ajax({
        type:'post',
        url:'getMobileByName.php',
        data:'fun=getName&cust_name='+cust_name,
        success:function(data){
            // alert(data);
            jQuery("#cust_mobile").val(data);
        }
    });
}

function calc_rec_amt() {
    var card_amt = jQuery("#card_amt").val();
    var paytm_amt = jQuery("#paytm_amt").val();
    var cash_amt = jQuery("#cash_amt").val();
    var payment_amt = jQuery("#payment_amt").html();
    if (card_amt=="") { card_amt=0; } 
    if (paytm_amt=="") { paytm_amt=0; }
    if (cash_amt=="") { cash_amt=0; }
    // alert(card_amt);alert(paytm_amt);alert(cash_amt);
    var total = parseFloat(card_amt)+parseFloat(paytm_amt)+parseFloat(cash_amt);
    //alert(total);
    jQuery("#rec_amt").val(total);
    if (parseFloat(payment_amt)<total) {
        jQuery("#rec_amt_error").html("Invalid Amount");
    }else{
        jQuery("#rec_amt_error").html("");
    }
}
</script>
</body>

</html>
