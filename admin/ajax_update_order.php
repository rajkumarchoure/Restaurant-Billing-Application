<?php
include("../adminsession.php");
$billid= trim(addslashes($_REQUEST['billid']));
$crit= trim($_REQUEST['crit']);
$is_completed=trim(addslashes($_REQUEST['is_completed']));

if($is_completed==1)
{
	$is_completed=0;
}
else
{
	$is_completed=1;
}
//echo $crit; die;

$sql=mysql_query("update bills set is_completed='$is_completed' where billid='$billid'");
//echo "update bills set is_completed='$is_completed' where billid='$billid'";

$status=$cmn->getvalfield("bills","is_completed","billid='$billid'");

$currdate = date('Y-m-d');
$count_product = $cmn->getvalfield("bills","count(*)","is_completed='1' and billdate='$currdate'");



echo $status .' | '. $count_product;

?>

                               
                        
            