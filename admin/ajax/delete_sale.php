<?php include("../../adminsession.php");
 $billid  = $_REQUEST['id'];
$tblname  =$_REQUEST['tblname'];
$tblpkey  =$_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];

//echo "delete from bill_details where billid = '$billid'";die;
$res1 = mysql_query("delete from bill_details where billid = '$billid'");
if($res1)
{
	mysql_query("delete from kot_entry where billid = '$billid'");
	$res =  mysql_query("delete from $tblname where $tblpkey = '$billid' ");
	echo "<script>location='$pagename?action=3';</script>";
}


?>