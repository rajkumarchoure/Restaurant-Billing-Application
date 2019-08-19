<?php 
include("../adminsession.php");

if(isset($_REQUEST['billid']))
{
	$cancel_remark = trim(addslashes($_REQUEST['cancel_remark']));
	$billid = trim(addslashes($_REQUEST['billid']));
	
	if($billid > 0)
	{
			//update payment data
			$form_data = array('is_cancelled'=>1,'cancel_remark'=>$cancel_remark);
			dbRowUpdate("bills", $form_data,"billid='$billid'");
			echo $billid;
			
	}
	else
	echo "0";
}


?>