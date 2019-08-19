<?php include("../../adminsession.php");
 $id  = $_REQUEST['id'];
$tblname  =$_REQUEST['tblname'];
$tblpkey  =$_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];
$imgpath = $_REQUEST['imgpath'];
 $rowimg = mysql_fetch_array(SelectDB($tblname,"$tblpkey = '$id'"));
 $oldimg = $rowimg["imgname"];
 

 
 if($oldimg != "")
{
	unlink("../uploaded/".$oldimg);
	
}



//echo "delete from $tblname where $tblpkey = '$id'";die;
$res =  mysql_query("delete from $tblname where $tblpkey = '$id'");
$keyvalue = mysql_insert_id();
if($res)
{
	$cmn->InsertLog($pagename, $module, $submodule, $tblname, $tblpkey, $id, "deleted");
	echo "<script>location='$pagename?action=3';</script>";
}


?>