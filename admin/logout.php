<?php
session_start();
include("../adminsession.php");
mysql_query("insert into loginlogoutreport set userid ='$loginid',usertype = '$usertype',process = 'Logout',loginlogouttime = now(),createdate = now(),ipaddress = '$ipaddress'");
session_destroy();

echo "<script>location='../index.php?msg=logout' </script>" ;

?>