<?php
include("../adminsession.php");
$pcatid= addslashes($_REQUEST['pcatid']);

if($pcatid !='')
{
	if($pcatid == 0)
	$crit = " where 1 = 1 ";
	else
	$crit = " where pcatid='$pcatid' ";
	?>  
 <table class="table table-condensed table-bordered" style="width:100%; border-radius:5px; float:left" id="myTable">
 <tr class="header">
 	<th style="width:5%;">SL</th>
    <th style="width:55%;">Item</th>
    <th style="width:20%;">Rate</th>
    <th style="width:20%;">Image</th>
  </tr>
    <?php
	$sql=mysql_query("select * from m_product $crit order by productid asc");
	while($row=mysql_fetch_assoc($sql))
	{
		$unitid=$row['unitid'];
		$imgname=$row['imgname'];
		$unit_name=$cmn->getvalfield("m_unit","unit_name","unitid='$unitid'");
		$rate=$row['rate'];
		$disc=$row['disc'];
		$disc_amt= ($rate * $disc)/100;
		$product_price=$rate-$disc_amt;
		
		
		if($imgname=='')
		{
			$imgname="image.jpg";	
		}
 ?>
 

                                        
            <tr onClick="addproduct('<?php echo $row['productid'];  ?>','<?php echo $row['prodname']; ?>','<?php echo $unitid ?>','<?php echo $unit_name; ?>','<?php echo $product_price; ?>');" style="cursor:pointer;">
            	<td><span style="font-weight:bold;font-size:14px;"><?php echo ++$slnos; ?></span></td>
                <td><span style="font-weight:bold;font-size:14px;"> <?php echo $row['prodname']; ?> </span><br/></td>
                <td><span style="font-weight:bold; color:#F00;font-size:16px;"> Rs.<?php echo $product_price; ?>/- </span></td>
                <td><a><img src="uploaded/<?php echo $imgname; ?>" alt="" height="50px" width="80px" /></a></td>
            </tr>
<!--<div class="alert alert-info" style="width:15%;height:20%; float:left; margin-left:1px;">


 <p style="font-size:10px;color:#000;"><?php //echo $row['prodname']; ?>
 <a><img src="uploaded/<?php //echo $imgname; ?>" alt="" height="50px" width="80px" /></a>
 <span style="font-weight:bold; color:#F00"> Rs.<?php //echo $product_price; ?>/- </p> 
</div>                                    
                             
</div>     -->                           
                                    	



<?php 		
	}//while close
	?>
    </table>
    <?php
}//if close

?>




<!--<button class="btn btn-success" style="width:19%; height:10%; padding:2px; margin-bottom:2px; margin-top:2px; z-index:100;" onClick="addproduct('<?php echo $row['productid'];  ?>','<?php echo $row['prodname']; ?>','<?php echo $unitid ?>','<?php echo $unit_name; ?>','<?php echo $product_price; ?>')" ><?php echo $row['prodname']; ?></button>  
-->

