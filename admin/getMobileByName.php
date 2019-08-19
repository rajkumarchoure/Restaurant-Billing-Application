<?php
include("../adminsession.php");
$fun = $_POST['fun'];

if ($fun=="getName") {
	$cust_name = $_POST['cust_name'];
	echo $cust_mobile = $cmn->getvalfield("bills","cust_mobile","cust_name='$cust_name'");
}
?>