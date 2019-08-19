<?php 
include("../adminsession.php");
include("../lib/smsinfo.php");

if(isset($_REQUEST['table_id']))
{
	$table_id = trim(addslashes($_REQUEST['table_id']));
	$paymode = trim(addslashes($_REQUEST['paymode']));
	$tran_no = trim(addslashes($_REQUEST['tran_no']));
	$bank_name = trim(addslashes($_REQUEST['bank_name']));
	$remarks = trim(addslashes($_REQUEST['remarks']));
	$billid = trim(addslashes($_REQUEST['billid']));
	$cust_name = trim(addslashes($_REQUEST['cust_name']));
	$cust_mobile = trim(addslashes($_REQUEST['cust_mobile']));
	$paydate = trim(addslashes($_REQUEST['paydate']));
	$paydate = $cmn->dateformatusa($paydate);
	$rec_amt = trim(addslashes($_REQUEST['rec_amt']));
	$cash_amt = trim(addslashes($_REQUEST['cash_amt']));
	$card_amt = trim(addslashes($_REQUEST['card_amt']));
	$paytm_amt = trim(addslashes($_REQUEST['paytm_amt']));
	$zomato = trim(addslashes($_REQUEST['zomato']));
	$swiggy = trim(addslashes($_REQUEST['swiggy']));
	$card_trans_number = trim(addslashes($_REQUEST['card_trans_number']));
	$paytm_trans_no = trim(addslashes($_REQUEST['paytm_trans_no']));
	$is_paid = 1;
	
	//get owner number\
	$mobile1 = $cmn->getvalfield("company_setting","mobile","compid=1");
	$mobile2 = $cmn->getvalfield("company_setting","mobile2","compid=1");
	$billnumber = $cmn->getvalfield("bills","billnumber","billid='$billid'");
	$net_bill_amt = $cmn->getvalfield("bills","net_bill_amt","billid='$billid'");
	$billdate = $cmn->getvalfield("bills","billdate","billid='$billid'");
	$billdate = $cmn->dateformatindia($billdate);
	$table_no = $cmn->getvalfield("m_table","table_no","table_id='$table_id'");
	

	if($billid > 0)
	{
			//update payment data
			$form_data = array('isbilled'=>1);
			dbRowUpdate("bill_details", $form_data,"billid='$billid'");
			
			// isbill update to 1
			$form_data = array('paymode'=>$paymode,'tran_no'=>$tran_no,'bank_name'=>$bank_name,'remarks'=>$remarks,'is_paid'=>$is_paid,'cust_name'=>$cust_name,'cust_mobile'=>$cust_mobile,'paydate'=>$paydate, 'rec_amt'=>$rec_amt, 'cash_amt'=>$cash_amt, 'paytm_amt'=>$paytm_amt, 'paytm_trans_no'=>$paytm_trans_no, 'card_amt'=>$card_amt, 'card_trans_number'=>$card_trans_number,'zomato'=>$zomato, 'swiggy'=>$swiggy);
			dbRowUpdate("bills", $form_data,"billid='$billid'");
			
			$msg = "Dear $cust_name, Thank you for dining at Cafe Jungle!\nWe await to serve you again!!\nFROM\nCafe Jungle ";
			if(strlen($cust_mobile) == 10)
			$cmn->sendsms($smsuname,$msg_token,$smssender,$msg,$cust_mobile);
			
			$msg = "Dear Admin,\nNew Bill Generated at Cafe Jungle!\nBill No: $billnumber\nBill Date: $billdate\nBill Amt: $net_bill_amt\nRec Amt: $rec_amt\nCustomer: $cust_name\nMobile: $cust_mobile";
			
			if(strlen($mobile1) == 10)
			$cmn->sendsms($smsuname,$msg_token,$smssender,$msg,$mobile1);
			
			if(strlen($mobile2) == 10)
			$cmn->sendsms($smsuname,$msg_token,$smssender,$msg,$mobile2);
			
			echo $billid;
			
	}
	else
	echo "0";
}


?>