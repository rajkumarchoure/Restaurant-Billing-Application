<?php 
include("../adminsession.php");

if(isset($_REQUEST['table_id']))
{ //print_r($_REQUEST['is_parsal']);
	$table_id = trim(addslashes($_REQUEST['table_id']));
	$basic_bill_amt = trim(addslashes($_REQUEST['basic_bill_amt']));
	$disc_percent = trim(addslashes($_REQUEST['disc_percent']));
	$net_bill_amt = trim(addslashes($_REQUEST['net_bill_amt']));
	$is_parsal = trim(addslashes($_REQUEST['is_parsal']));
	$parsal_status = trim(addslashes($_REQUEST['parsal_status']));
	$disc_rs =  trim(addslashes($_REQUEST['disc_rs']));
	$billnumber = $cmn->getcode("bills","billid","1=1");
	
	if($is_parsal == "on")
	$is_parsal = 1;
	else
	$is_parsal = 0;
	
	$sgst = trim(addslashes($_REQUEST['sgst']));
	$cgst = trim(addslashes($_REQUEST['cgst']));
	$sercharge = trim(addslashes($_REQUEST['sercharge']));
	
	$billdate = date('Y-m-d');
	$billtime =  date("h:i A");
	//echo $billtime; 
	
	/*$billnumber = $cmn->getcode("bills","billid","1=1");
	$enable="enable";
	
	if($sgst > 0)
	{
		$sgst_amt = $basic_bill_amt * ($sgst/100);
	}
	else
	{
		$sgst_amt= 0;
	}
	
	if($cgst > 0)
	{
		$cgst_amt = $basic_bill_amt * ($cgst/100);
	}
	else
	{
		$cgst_amt = 0;
	}
		
	if($sercharge > 0)
	{
		$sercharge_amt = $basic_bill_amt * ($sercharge/100);
	}
	else
	{
		$sercharge_amt = 0;
	}
	
	$net_bill_amt = $basic_bill_amt + $sgst_amt + $cgst_amt + $sercharge_amt;*/
	
	if($table_id !='')
	{
		//restricte order bill to save duplicate
		$check_billed = $cmn->getvalfield("bills","count(*)","table_id='$table_id' and is_paid=0");
		if($check_billed > 0)
		{
			echo "0";
		}
		else
		{
			//ALTER TABLE `bills` ADD `disc_rs` FLOAT NOT NULL AFTER `disc_percent` 
			$form_data = array('table_id'=>$table_id,'billdate'=>$billdate,'billtime'=>$billtime,'billnumber'=>$billnumber,'cgst'=>$cgst,'sgst'=>$sgst,'sercharge'=>$sercharge,'is_parsal'=>$is_parsal,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'net_bill_amt'=>$net_bill_amt,'disc_percent'=>$disc_percent,'basic_bill_amt'=>$basic_bill_amt,'parsal_status'=>$parsal_status,'disc_rs'=>$disc_rs);
			dbRowInsert("bills", $form_data);
			$keyvalue = mysql_insert_id();
			$action=1;
			$process = "insert";
			mysql_query("update bill_details set billid='$keyvalue' where table_id='$table_id' and billid=0");	
			mysql_query("update kot_entry set billid='$keyvalue' where table_id='$table_id' and billid=0");	
			echo $keyvalue;
		}
	}
}


?>