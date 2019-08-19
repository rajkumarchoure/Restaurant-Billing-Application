<?php
include("../adminsession.php");
$productid=$_REQUEST['productid'];
$unitid=$_REQUEST['unitid'];
$qty=$_REQUEST['qty'];
$rate=$_REQUEST['rate'];
$table_id=$_REQUEST['table_id'];
$tblname="bill_details";


//restrict produc to add if biill is saved
$issaved = $cmn->getvalfield("bills","count(*)","table_id='$table_id' and is_paid='0'");

if($issaved == 0)
{
	if($productid !='' && $unitid !='' && $qty !='' && $rate !='' )
	{
		$form_data = array('productid'=>$productid,'unitid'=>$unitid,'qty'=>$qty,'rate'=>$rate,'table_id'=>$table_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$createdby);
		dbRowInsert($tblname, $form_data);
		$process = "insert";	
		echo "1";
	}
}
else
{
	echo "0";	
}

?>