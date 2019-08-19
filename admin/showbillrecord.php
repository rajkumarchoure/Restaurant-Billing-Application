<?php
include("../adminsession.php");
$table_id = $_REQUEST['table_id'];

$sqlget=mysql_query("select * from bill_details where table_id='$table_id' && isbilled='0'");
$sn=1;

//check bill is saved if yes show payemnt button
$net_bill_amt = $cmn->getvalfield("bills","net_bill_amt","table_id='$table_id' and is_paid=0");
$billnumber = $cmn->getvalfield("bills","billnumber","table_id='$table_id' and is_paid=0");
$table_no = $cmn->getvalfield("m_table","table_no","table_id='$table_id'");


?>



<table class="table table-bordered" >
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Product Name</th>
            <th>Unit</th>
            <th>Qty.</th>
            <th>Rate</th>
            <th>Amt</th>
            <th class="center">Action</th>
        </tr>
    </thead>
    <tbody>
                                        
                                        <?php
										$total=0;
			while($rowget=mysql_fetch_assoc($sqlget))
			{
				$amount=0;
				$billdetailid=$rowget['billdetailid'];
				$productid=$rowget['productid'];
				$unitid=$rowget['unitid'];
				$qty=$rowget['qty'];
				$rate=$rowget['rate'];
				$amount= $qty * $rate;
				
				$prodname=$cmn->getvalfield("m_product","prodname","productid='$productid'");
				$unit_name=$cmn->getvalfield("m_unit","unit_name","unitid='$unitid'");
				
										?>
                                            <tr>
                                            	<td><?php echo $sn; ?></td>
                                                <td><?php echo $prodname; ?></td>
                                                <td><?php echo $unit_name; ?></td>
                                                <td><?php echo $qty;  ?></td>
                                                <td align="right"><?php echo number_format($rate,2);  ?></td>
                                                <td style="color:#900; font-weight:bold" align="right"><?php echo number_format($amount,2); ?></td>
                                                <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $billdetailid; ?>');"> X </a></td>
                                            </tr>
                                            
             <?php
			 $total += $amount;
$sn++;
}

?>    
 <tr>
 <td colspan="2"><label> <strong>Is Parcel</strong>  &nbsp; <input type="checkbox" name="is_parsal" id="is_parsal" value="" class="form-control"/> </label> </td>
 <td colspan="5" align="right" style="text-align:right;">
  <h3> <strong>Basic Total : <span  style="color:#00F;" > <?php echo number_format($total,2); ?> </span></strong> </h3> 
               <input type="hidden" name="hidden_basic_amt" id="hidden_basic_amt" value="<?php echo $total; ?>" /></td>
 </tr>
 <tr>
 	<td colspan="7">KOT's : 
    <?php
	$res_kot = mysql_query("select * from kot_entry where table_id = '$table_id' and billid=0");
	while($row_kot = mysql_fetch_array($res_kot))
	{
		++$slno;
		?>
		<a target="_blank" href="pdf_restaurant_kot_recipt_old.php?kotid=<?php echo $row_kot['kotid']; ?>" class="btn  btn-danger"><?php echo $slno; ?></a>	
	<?php
    }
	?>
    
    </td>
 </tr>
      <tr>
      <td colspan="7">
          <p align="center"> 
          <input type="submit" class="btn btn-danger" value="Save" name="submit" onclick="show_discount_modal()" >  
          <input type="hidden" name="table_id" value="<?php echo $table_id; ?>"  />&nbsp;
          <a  onclick="refreshkot(0,'<?php echo $table_id;?>');" class="btn btn-info btn-xm" target="_blank" >
          <i class="iconfa-print"></i> Print KOT</a>&nbsp;
          <?php if($net_bill_amt > 0){ ?>
          <a class="btn btn-success btn-xm" onclick="show_payment_modal('<?php echo $net_bill_amt; ?>','<?php echo $billnumber; ?>','<?php echo $table_no; ?>');">
          <i class="iconfa-money"></i> Payment</a>&nbsp;
          <?php } ?>
          
          <a href="in-entry.php" class="btn btn-primary" > Reset </a>
          </p>
      </td>
      </tr>                                      
             						  </tbody>
                                    </table>

