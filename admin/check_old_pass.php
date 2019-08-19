<?php
include("../adminsession.php");
$oldpass=$_SERVER['QUERY_STRING'];

$sql =mysql_query("select password from user where password = '$oldpass' and userid ='$loginid'");
//echo "select password from user where password = '$oldpass' and userid ='$loginid'";die;

$cnt = mysql_num_rows($sql);
//echo $sql;
$idname = "";

if($cnt!=0)
$idname ="Old passsword is correct";
else
$idname = "Old password is wrong";

echo $idname;
?>
